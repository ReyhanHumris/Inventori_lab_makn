<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class KelolaUser extends Component
{
    use WithPagination;

    public $search = '';
    public $isModalOpen = false;
    
    // Form fields
    public $user_id;
    public $name;
    public $email;
    public $password;
    public $role = 'petugas';

    public $selectedId = null; // for delete confirmation
    public $isDeleting = false;

    protected $queryString = ['search' => ['except' => '']];

    public function mount()
    {
        if (auth()->user()->role !== 'kepala') {
            abort(403, 'Hanya Kepala Laboratorium yang dapat mengakses halaman ini.');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->password = ''; // empty, if not changed
        $this->isModalOpen = true;
    }

    public function resetInputFields()
    {
        $this->user_id = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = 'petugas';
    }

    public function store()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user_id),
            ],
            'role' => 'required|in:kepala,petugas,peminjam',
        ];

        if (!$this->user_id) {
            $rules['password'] = 'required|string|min:8';
        } else {
            $rules['password'] = 'nullable|string|min:8';
        }

        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->user_id) {
            $user = User::findOrFail($this->user_id);
            $user->update($data);
            \App\Helpers\ActivityLogger::log('Mengubah User', 'Mengubah info user ' . $this->name . ' (Role: ' . $this->role . ')');
            session()->flash('message', 'User berhasil diperbarui.');
        } else {
            User::create($data);
            \App\Helpers\ActivityLogger::log('Menambahkan User', 'Menambahkan user baru: ' . $this->name . ' (Role: ' . $this->role . ')');
            session()->flash('message', 'User baru berhasil ditambahkan.');
        }

        $this->isModalOpen = false;
        $this->resetInputFields();
    }

    public function confirmDelete($id)
    {
        if ($id == auth()->user()->id) {
            session()->flash('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
            return;
        }
        $this->selectedId = $id;
    }

    public function delete()
    {
        if ($this->selectedId) {
            $user = User::findOrFail($this->selectedId);
            if ($user->id == auth()->user()->id) {
                session()->flash('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
            } else {
                $namaUser = $user->name;
                $user->delete();
                \App\Helpers\ActivityLogger::log('Menghapus User', 'Menghapus user: ' . $namaUser . ' (ID #' . $this->selectedId . ')');
                session()->flash('message', 'User berhasil dihapus.');
            }
            $this->selectedId = null;
        }
    }

    public function render()
    {
        $users = User::where(function($q) {
            $q->where('name', 'like', '%' . $this->search . '%')
              ->orWhere('email', 'like', '%' . $this->search . '%');
        })
        ->paginate(10);

        return view('livewire.kelola-user', [
            'users' => $users
        ]);
    }
}
