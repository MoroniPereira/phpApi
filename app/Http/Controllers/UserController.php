<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function users(){
        // Retorna todos os usuarios
        $users = User::all();
        return response()->json($users);
    }

    public function login(Request $request){
        //Validaçao dos dados de login
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //Autenticaçao do usuario
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User logged in successfully',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    public function register(Request $request) {
        // Aqui valida os dados
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nascimento' => 'required|date_format:d/m/Y',
            'genero' => 'required|in:feminino,masculino',
            'plano' => 'required|in:gold,silver',
            'password' => 'required|string|min:6',
        ]);

        //Aqui retorna erros de validaçoes
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Aqui cria o usuario
        $user = User::create([
            'name' => $request->nome,
            'email' => $request->email,
            'birthdate' => $request->nascimento,
            'gender' => $request->genero,
            'plan' => $request->plano,
            'password' => Hash::make($request->password),
        ]);

        // Aqui retorna a resposta
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    public function deleteUser(Request $request, $id)
    {
        // Encontrar o usuário pelo ID e deleta
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

    public function editUser(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $id,
            'nascimento' => 'sometimes|date_format:d/m/Y',
            'genero' => 'sometimes|in:feminino,masculino',
            'plano' => 'sometimes|in:gold,silver',
            'password' => 'sometimes|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Atualizar os campos do usuário
        $user->update($request->all());

        // Se a senha for fornecida, hash ela antes de salvar
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }
}
