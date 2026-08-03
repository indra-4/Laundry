<?php
// ========================================
// FILE: app/Http/Controllers/NotificationController.php
// ========================================

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifikasi;

class NotificationController extends Controller
{
    public function unread()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['count' => 0, 'notifications' => []]);
        }

        $notifications = $user->notifikasi()
            ->unread()
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'count' => $user->notifikasi()->unread()->count(),
            'notifications' => $notifications
        ]);
    }

    public function markAsRead($id)
    {
        $user = Auth::user();
        if ($user) {
            $user->notifikasi()->where('notifikasi_id', $id)->update(['is_read' => true]);
        }
        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        $user = Auth::user();
        if ($user) {
            $user->notifikasi()->unread()->update(['is_read' => true]);
        }
        return response()->json(['success' => true]);
    }
}
