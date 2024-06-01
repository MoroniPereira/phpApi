<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Consulta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ConsultaController extends Controller
{
    public function consultas()
    {
        $userId = Auth::id();
        $consultas = Consulta::where('user_id', $userId)->get();
        return response()->json($consultas);
    }

    public function buscarConsulta($id){
        $consulta = Consulta::find($id);
        if (!$consulta) {
            return response()->json(['message' => 'Consulta not found'], 404);
        }

        return response()->json($consulta);
    }

    public function registerConsulta(Request $request){
        $validator = Validator::make($request->all(), [
            'especialidade' => 'required|string|max:255',
            'data' => 'required|date_format:d/m/Y',
            'hora' => 'required|date_format:H:i',
            'realizada' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $consulta = Consulta::create([
            'user_id' => Auth::id(),
            'especialidade' => $request->especialidade,
            'data' => $request->data,
            'hora' => $request->hora,
            'realizada' => $request->realizada,
        ]);

        return response()->json([
            'message' => 'Consulta successfully registered',
            'consulta' => $consulta
        ], 201);
    }

    public function updateConsulta(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'especialidade' => 'required|string|max:255',
            'data' => 'required|date_format:d/m/Y',
            'hora' => 'required|date_format:H:i',
            'realizada' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $consulta = Consulta::find($id);
        if (!$consulta) {
            return response()->json(['message' => 'Consulta not found'], 404);
        }

        $consulta->update($request->all());

        return response()->json([
            'message' => 'Consulta successfully updated',
            'consulta' => $consulta
        ], 201);
    }

    public function deleteConsulta($id){
        $consulta = Consulta::find($id);
        if (!$consulta) {
            return response()->json(['message' => 'Consulta not found'], 404);
        }
        $consulta->delete();
        return response()->json(['message' => 'Consulta deleted successfully']);
    }
}

