<?php

namespace App\Http\Controllers;

use App\Helpers\HttpHelper;
use Exception;
use Illuminate\Http\Request;

class CustomRegistrationController extends Controller
{

    private $httpHelper;

    public function __construct() {
        $this->httpHelper = new HttpHelper();
    }

    /**
     * Form
     */
    public function showRegistrationForm(Request $request) {

        // Verifica se o usuario já está logado
        if($request->session()->get('user'))
            return redirect('home');


        return view("auth.register");
    }

    /**
     * Registrar User
     * 
     */
     public function register(Request $request) {
        
        try {   
            $result = $this->httpHelper->post('auth/register', [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'password_confirmation' => $request->password_confirmation
            ]);

        } catch(\GuzzleHttp\Exception\ClientException $e) {

            return redirect()->route('showRegistrationForm')->with('message', 'Preencha os campos corretamente.');

        }

        return redirect('/login');
    }

}