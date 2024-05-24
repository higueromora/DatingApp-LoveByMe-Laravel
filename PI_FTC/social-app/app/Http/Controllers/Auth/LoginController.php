<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }



    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember_credentials'))) {
            // Si el inicio de sesión es exitoso
            if ($request->filled('remember_credentials')) {
                // Guardar tanto el nombre de usuario como la contraseña si se marca el checkbox
                Cookie::queue('remembered_username', $request->input('email'), 1440); // 1 día de duración
                Cookie::queue('remembered_password', $request->input('password'), 1440); // 1 día de duración
                Cookie::queue('remember_credentials_checked', true, 1440); // Guardar el estado del checkbox
            } else {
                // Eliminar las cookies si no se marca el checkbox
                Cookie::queue(Cookie::forget('remembered_username'));
                Cookie::queue(Cookie::forget('remembered_password'));
                Cookie::queue(Cookie::forget('remember_credentials_checked'));
            }

            return redirect()->intended($this->redirectPath());
        }

        return redirect()->back()->withErrors(['email' => 'Estas credenciales no coinciden con nuestros registros']);
    }



}
