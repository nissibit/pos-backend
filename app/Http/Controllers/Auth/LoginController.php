<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    /**
     * Processar a tentativa de autenticação.
     */
    public function authenticate(LoginRequest $request): RedirectResponse
    {
        // O FormRequest já validou os dados aqui
        $credentials = $request->only('login', 'password');

        // Lógica para decidir se é email ou username
        $fieldType = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) 
            ? 'email' 
            : 'username';

        if (Auth::attempt([$fieldType => $credentials['login'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();

            return $this->authenticated($request, Auth::user());
        }

        return back()->withErrors([
            'login' => 'As credenciais fornecidas não coincidem com os nossos registos.',
        ])->onlyInput('login');
    }

    /**
     * Lógica de redireccionamento após sucesso (antigo método authenticated).
     */
    protected function authenticated(Request $request, $user): RedirectResponse
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'editor') {
            return redirect()->route('editor.panel');
        }

        return redirect()->intended('/home');
    }

    /**
     * Terminar a sessão.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}