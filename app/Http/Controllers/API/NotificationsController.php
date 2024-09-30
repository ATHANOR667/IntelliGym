<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    /**
     * Récupérer toutes les notifications de l'utilisateur.
     */
    public function index(Request $request)
    {
        // Récupérer toutes les notifications de l'utilisateur connecté
        $notifications = auth()->user()->notifications;

        return response()->json([
            'status' => 'success',
            'message' => 'Toutes vos  notifications.',
            'notifications' => $notifications,
        ], 200); // HTTP status code 200 OK
    }

    /**
     * Récupérer seulement les notifications non lues de l'utilisateur.
     */
    public function unread(Request $request)
    {
        // Récupérer uniquement les notifications non lues
        $unreadNotifications = auth()->user()->unreadNotifications;

        return response()->json([
            'status' => 'success',
            'message' => 'Notifications non lues ',
            'notifications' => $unreadNotifications,
        ], 200); // HTTP status code 200 OK
    }

    /**
     * Marquer une notification comme lue.
     */
    public function markAsRead(Request $request, $id)
    {
        // Récupérer la notification par ID
        $notification = auth()->user()->notifications()->find($id);

        if ($notification) {
            // Marquer la notification comme lue
            $notification->markAsRead();

            return response()->json([
                'status' => 'success',
                'message' => 'Notification marquée comme lue.',
            ], 200); // HTTP status code 200 OK
        }

        // Si la notification n'est pas trouvée
        return response()->json([
            'status' => 'error',
            'message' => 'Notification non trouvée.',
        ], 404); // HTTP status code 404 Not Found
    }
}
