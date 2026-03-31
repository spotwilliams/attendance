<?php

namespace Cat\Modules\Presentismo\Controllers\Registration;

use Cat\Http\Controllers\Controller;
use Cat\Models\Comentario;
use Cat\Models\Presentismo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceCommentController extends Controller
{
    public function index(Presentismo $attendance): JsonResponse
    {
        $comments = $attendance->comentarios()
            ->with('user')
            ->orderBy('created_at', 'ASC')
            ->get()
            ->map(fn (Comentario $c) => [
                'id' => $c->id,
                'comentario' => $c->comentario,
                'created_at' => $c->created_at->toIso8601String(),
                'usuario' => $c->user->name ?? 'N/A',
            ]);

        return response()->json(['comments' => $comments]);
    }

    public function store(Request $request, Presentismo $attendance): JsonResponse
    {
        $request->validate([
            'comentario' => ['required', 'max:400'],
        ]);

        $comment = Comentario::create([
            'id_presentismo' => $attendance->id,
            'id_user' => Auth::id(),
            'comentario' => $request->input('comentario'),
        ]);

        $attendance->comentario = 'SI';
        $attendance->save();

        return response()->json([
            'comment' => [
                'id' => $comment->id,
                'comentario' => $comment->comentario,
                'created_at' => $comment->created_at->toIso8601String(),
                'usuario' => Auth::user()->name ?? 'N/A',
            ],
        ], 201);
    }
}
