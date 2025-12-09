<?php
namespace App\Http\Controllers\Auth;


use App\Events\UserCreated;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest as ApiLoginRequest;
use App\Http\Requests\Api\RegisterRequest as ApiRegisterRequest;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    private User $user;
    public function register(ApiRegisterRequest $request)
    {
        $data = $request->all();
        array_merge($data, ['password' => bcrypt($data['password'])]);
        $data['role'] = $request->has('role') ? $data['role'] : 'user';
        $user = User::create($data);
        event(new UserCreated($user)); // Fire the UserCreated event
        $token = $user->createToken('api_token')->plainTextToken;
        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }
    public function login(ApiLoginRequest $request)
    {
        // 1. Validação: O Laravel fará isso automaticamente.
        // Se falhar, ele retorna 422 com os detalhes dos campos errados.

        try {
            $credentials = $request->only('email', 'password');
            // 2. Tentativa de Login
            if (!Auth::attempt($credentials)) {
                // Retorna 401 especificamente para credenciais erradas
                return ApiResponse::error('Credenciais inválidas (Email ou senha incorretos)', 401);
            }

            // 3. Sucesso
            $this->user = Auth::user();

            // O createToken retorna um objeto NewAccessToken, pegamos a string plainTextToken
            $token = $this->user->createToken('api_token')->plainTextToken;

            return ApiResponse::success([
                'user' => new UserResource($this->user),
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], "Bem vindo {$this->user->name}");
        } catch (\Exception $e) {
            $message = "Erro ao fazer login: {$e->getMessage()}";
            Log::info($message, $e->getTrace());
            return ApiResponse::error($message, $e->getCode(), config('app.debug') ? $e->getMessage() : null);
        }
    }
    /**
     * Log the user out (Revoke the token)
     */
    public function logout(Request $request)
    {
        try {
            $tempUser = $request()->user()->name;
            $response = $request->user()->currentAccessToken()->delete();
            return ApiResponse::success($response, "Até já {$tempUser}");
        } catch (\Exception $e) {
            $message = "Erro ao sair do sistema: {$e->getMessage()}";
            Log::info($message, $e->getTrace());
            return ApiResponse::error($message, $e->getCode(), config('app.debug') ? $e->getMessage() : null);
        }
    }

    public function profile(Request $request)
    {
        try {
            $user = $request->user();
            return ApiResponse::success($user, 'User profile retrieved successfully');
        } catch (\Exception $e) {
            $message = "Falha ao obter dados da sessão: {$e->getMessage()}";
            Log::info($message, $e->getTrace());
            return ApiResponse::error($message, $e->getCode(), config('app.debug') ? $e->getMessage() : null);
        }
    }
}
