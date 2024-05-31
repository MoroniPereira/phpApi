<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exame;
use App\Models\Consulta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExameController extends Controller
{
    public function exames(){
        $userId = Auth::id();
        $exames = Exame::where('user_id', $userId)->get();
        return response()->json($exames);
    }

    public function registerExame(Request $request){
        $validator = Validator::make($request->all(), [
            'consulta_id' => 'required|int',
            'medico' => 'required|string|max:255',
            'descricao' => 'required|string',
            'prescricao' => 'required|string',
            'data' => 'required|date_format:d/m/Y',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $userId = Auth::id();
        $consulta = Consulta::find($request->consulta_id);
        if(!$consulta){
            return response()->json([
                'Error' => true,
                'message' => 'Consulta_id not found'
            ], 404);
        }

        $exame = Exame::create([
            'user_id' => Auth::id(),
            'consulta_id' => $request->consulta_id,
            'medico' => $request->medico,
            'descricao' => $request->descricao, 
            'prescricao' => $request->prescricao,
            'data' => $request->data,
        ]);

        $exame['especialidade'] = $consulta->especialidade;

        return response()->json([
            'message' => 'Exame successfully registered',
            'consulta' => $exame
        ], 201);
    }

    public function updateExame(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'consulta_id' => 'required|int',
            'medico' => 'required|string|max:255',
            'descricao' => 'required|string',
            'prescricao' => 'required|string',
            'data' => 'required|date_format:d/m/Y',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $userId = Auth::id();
        $consulta = Consulta::find($request->consulta_id);
        if(!$consulta){
            return response()->json([
                'Error' => true,
                'message' => 'Consulta_id not found'
            ], 404);
        }

        $exame = Exame::find($id);
        if(!$exame){
            return response()->json([
                'Error' => true,
                'message' => 'Exame not found'
            ], 404);
        }

        $exame->update($request->all());
        return response()->json([
            'message' => 'Exame successfully updated',
            'consulta' => $exame
        ], 201);
    }

    public function deleteExame($id){
        $exame = Exame::find($id);
        if (!$exame) {
            return response()->json(['message' => 'Exame not found'], 404);
        }
        $exame->delete();
        return response()->json(['message' => 'Exame deleted successfully']);
    }
}
