<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\Pendeta;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    /**
     * Send a message to another pendeta
     */
    public function sendMessage(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'receiver_id' => 'required|exists:pendetas,id',
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $sender = Auth::user();

        // Check if sender is trying to send message to themselves
        if ($sender->id == $request->receiver_id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot send message to yourself'
            ], 400);
        }

        $message = ChatMessage::create([
            'sender_id' => $sender->id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'is_read' => false
        ]);

        // Load sender information for response
        $message->load('sender:id,nama_pendeta');

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully',
            'data' => $message
        ], 201);
    }

    /**
     * Get conversation with a specific pendeta
     */
    public function getConversation(Request $request, $pendetaId): JsonResponse
    {
        $validator = Validator::make(['pendeta_id' => $pendetaId], [
            'pendeta_id' => 'required|exists:pendetas,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid pendeta ID',
                'errors' => $validator->errors()
            ], 422);
        }

        $currentUser = Auth::user();

        // Get messages between current user and the specified pendeta
        $messages = ChatMessage::where(function ($query) use ($currentUser, $pendetaId) {
            $query->where('sender_id', $currentUser->id)
                  ->where('receiver_id', $pendetaId);
        })->orWhere(function ($query) use ($currentUser, $pendetaId) {
            $query->where('sender_id', $pendetaId)
                  ->where('receiver_id', $currentUser->id);
        })
        ->with(['sender:id,nama_pendeta', 'receiver:id,nama_pendeta'])
        ->orderBy('created_at', 'asc')
        ->get();

        // Mark received messages as read
        ChatMessage::where('sender_id', $pendetaId)
                  ->where('receiver_id', $currentUser->id)
                  ->where('is_read', false)
                  ->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'data' => $messages
        ]);
    }

    /**
     * Get all conversations (list of pendetas with recent messages)
     */
    public function getConversations(): JsonResponse
    {
        $currentUser = Auth::user();

        // Get unique pendetas that the current user has chatted with
        $conversations = ChatMessage::where('sender_id', $currentUser->id)
            ->orWhere('receiver_id', $currentUser->id)
            ->with(['sender:id,nama_pendeta', 'receiver:id,nama_pendeta'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($message) use ($currentUser) {
                return $message->sender_id == $currentUser->id
                    ? $message->receiver_id
                    : $message->sender_id;
            })
            ->map(function ($messages) use ($currentUser) {
                $latestMessage = $messages->first();
                $otherPendeta = $latestMessage->sender_id == $currentUser->id
                    ? $latestMessage->receiver
                    : $latestMessage->sender;

                $unreadCount = $messages->where('receiver_id', $currentUser->id)
                    ->where('is_read', false)
                    ->count();

                return [
                    'pendeta' => [
                        'id' => $otherPendeta->id,
                        'nama_pendeta' => $otherPendeta->nama_pendeta,
                    ],
                    'latest_message' => [
                        'id' => $latestMessage->id,
                        'message' => $latestMessage->message,
                        'created_at' => $latestMessage->created_at,
                        'is_from_me' => $latestMessage->sender_id == $currentUser->id,
                    ],
                    'unread_count' => $unreadCount
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'data' => $conversations
        ]);
    }

    /**
     * Get list of all pendetas for starting new conversations
     */
    public function getPendetaList(): JsonResponse
    {
        $currentUser = Auth::user();

        $pendetas = Pendeta::where('id', '!=', $currentUser->id)
            ->select('id', 'nama_pendeta', 'region_id', 'departemen_id')
            ->with(['region:id,nama_region', 'departemen:id,nama_departemen'])
            ->get()
            ->map(function ($pendeta) {
                return [
                    'id' => $pendeta->id,
                    'nama_pendeta' => $pendeta->nama_pendeta,
                    'region' => $pendeta->region ? $pendeta->region->nama_region : null,
                    'departemen' => $pendeta->departemen ? $pendeta->departemen->nama_departemen : null,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $pendetas
        ]);
    }

    /**
     * Mark messages as read
     */
    public function markAsRead(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'sender_id' => 'required|exists:pendetas,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $currentUser = Auth::user();

        $updated = ChatMessage::where('sender_id', $request->sender_id)
            ->where('receiver_id', $currentUser->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'message' => "Marked {$updated} messages as read"
        ]);
    }

    /**
     * Get unread message count
     */
    public function getUnreadCount(): JsonResponse
    {
        $currentUser = Auth::user();

        $unreadCount = ChatMessage::where('receiver_id', $currentUser->id)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'success' => true,
            'data' => [
                'unread_count' => $unreadCount
            ]
        ]);
    }
}
