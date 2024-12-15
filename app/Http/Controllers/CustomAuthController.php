<?php

namespace App\Http\Controllers;

use App\Helpers\HttpHelper;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;

class CustomAuthController extends Controller
{

    private $httpHelper;

    public function __construct() {
        $this->httpHelper = new HttpHelper();
    }

    /**
     * Form Login
     *
     */
    public function showLoginForm(Request $request) {

        // Verifica se o usuario já está logado
        if($request->session()->get('user'))
            return redirect('home');


        return view("auth.login");
    }


    /**
     * Autenticação via API
     * 
     */
     public function login(Request $request) {
        
        try {   
            $result = $this->httpHelper->post('auth/login', [
                'email' => $request->email,
                'password' => $request->password
            ]);

            $user = new User();
            $user->email = $request->email;
            $user->access_token = $result->access_token;

            $request->session()->put('authenticated',true);
            $request->session()->put('user', $user);

        } catch(\GuzzleHttp\Exception\ClientException $e) {

            $request->session()->forget('authenticated');
            $request->session()->forget('user');

            return redirect()->route('login')->with('message', 'Login Inválido.');
        }

        return redirect('home');
    }
    
    
    /**
     * Logout
     */
    public function logout(Request $request) {

        $request->session()->forget('authenticated');
        $request->session()->forget('user');
        return redirect('login');
    }

}