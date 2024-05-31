<?php

namespace App\Http\Controllers;

use App\Models\Notificacao;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NotificacaoController extends Controller
{
    public function notification(){
        $userId = Auth::id();
        $notificacao = Notificacao::where('user_id', $userId)->get();
        return response()->json($notificacao);
    }

    public function createNotification(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'data' => ['required', function ($attribute, $value, $fail) {
                if (!\DateTime::createFromFormat('d/m/Y', $value) && !in_array($value, ['allday', 'semanal'])) {
                    $fail('The ' . $attribute . ' must be a valid date format (d/m/Y) or one of the values: allday, semanal.');
                }
            }],
            'hora' => 'required|date_format:H:i',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $notificacao = Notificacao::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'data' => $request->data,
            'hora' => $request->hora,
        ]);

        return response()->json([
            'message' => 'Notificação successfully registered',
            'notificacao' => $notificacao
        ]);
    }

    public function updateNotification(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'data' => ['required', function ($attribute, $value, $fail) {
                if (!\DateTime::createFromFormat('d/m/Y', $value) && !in_array($value, ['allday', 'semanal'])) {
                    $fail('The ' . $attribute . ' must be a valid date format (d/m/Y) or one of the values: allday, semanal.');
                }
            }],
            'hora' => 'required|date_format:H:i',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $notificacao = Notificacao::find($id);
        if (!$notificacao) {
            return response()->json(['message' => 'Notificação not found'], 404);
        }

        $notificacao->update($request->all());

        return response()->json([
            'message' => 'Notificação successfully updated',
            'notificacao' => $notificacao
        ], 201);
    }

    public function deleteNotification($id){
        $notificacao = Notificacao::find($id);
        if (!$notificacao) {
            return response()->json(['message' => 'Notificação not found'], 404);
        }
        $notificacao->delete();
        return response()->json(['message' => 'Notificação deleted successfully']);
    }
}
