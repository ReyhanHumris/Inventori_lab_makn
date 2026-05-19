<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    public static function log(string $aktivitas, string $deskripsi): void
    {
        try {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'aktivitas' => $aktivitas,
                'deskripsi' => $deskripsi,
                'ip_address' => Request::ip(),
            ]);
        } catch (\Exception $e) {
            // Silently fail to prevent app crash if log fails
            logger()->error('Gagal mencatat activity log: ' . $e->getMessage());
        }
    }
}
