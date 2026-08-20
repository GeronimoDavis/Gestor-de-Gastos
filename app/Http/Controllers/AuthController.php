<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Mostrar formulario de registro
    public function showRegister(){
        return view('auth.register');
    }

    // Procesar el registro de usuario
    public function register(Request $request){

        $credentials = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password']),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    //mostrar login
    public function showLogin(){
        
        return view('auth.login');

    }

    //Inicio de sesion
    public function login(Request $request){

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        //validamos las credenciales 
        if(Auth::attempt($credentials, $request->remember)){
            //Este método elimina el ID de sesión anónimo anterior(usuario no logeado) y genera un identificador de sesión completamente nuevo y cifrado
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        //volvemos a /login
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');//guardamso email en la session
    }

    //Cierre de session
    public function logout(Request $request){
        //Eliminamos el identificador del usuario guardado en la sesión activa y borramos las cookies
        Auth::logout();

        //Aca se vacía por completo todos los datos almacenados en la sesión actual y destruye el ID de sesión del servidor
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
