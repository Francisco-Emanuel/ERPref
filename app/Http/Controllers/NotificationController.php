<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    /**
     * Exibe a lista completa de notificações do usuário logado.
     */
    public function index(): View
    {
        $user = Auth::user();
        $notifications = $user->notifications()->paginate(10); // Pagina as notificações

        return view('notifications.index', compact('notifications'));
    }

    public function getNotifications(Request $request): JsonResponse
    {
        return response()->json([
            'notifications' => $request->user()->notifications,
            'unreadCount' => $request->user()->unreadNotifications->count()
        ]);
    }

    /**
     * Retorna a contagem de notificações não lidas do usuário logado.
     */
    public function getUnreadCount(Request $request): JsonResponse
    {
        return response()->json(['count' => $request->user()->unreadNotifications->count()]);
    }

    /**
     * Marca todas as notificações não lidas do usuário logado como lidas.
     */
    public function markAllAsRead(Request $request): JsonResponse
    {
        $request->user()->unreadNotifications->markAsRead();
        return response()->json(['status' => 'success', 'message' => 'Todas as notificações foram marcadas como lidas.']);
    }

    /**
     * Marca uma notificação específica como lida.
     */
    public function markAsRead(Request $request, $id): JsonResponse
    {
        $notification = $request->user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['status' => 'success', 'message' => 'Notificação marcada como lida.']);
        }

        return response()->json(['status' => 'error', 'message' => 'Notificação não encontrada.'], 404);
    }
}
