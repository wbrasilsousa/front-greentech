<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\HttpHelper;

class SupplierAuthController extends Controller
{
    
    private $httpHelper;

    public function __construct() {
        $this->httpHelper = new HttpHelper();
    }

    /**
     * Lista 
     */
    public function index(Request $request){

        $user = $request->session()->get('user');
        
        try {   
            $suppliers = $this->httpHelper->get('suppliers/get', $user->access_token);


        } catch(\GuzzleHttp\Exception\ClientException $e) {

            if($e->getCode() == 401)
                return redirect('login');

            return redirect()->back()->with('error', 'Contate o Administrador');
        }

        return view('supplier', ['suppliers' => $suppliers]);
    }


    /**
     * Form add
     */
    public function add(Request $request){

        return view('add_supplier');
    }


    /**
     * Salvar
     */
    public function save(Request $request){

        $user = $request->session()->get('user');

        try {   
            $result = $this->httpHelper->post('suppliers/register', [
                'nome' => $request->nome,
                'telefone' => preg_replace('/[^0-9]/','',$request->telefone),
                'email' => $request->email,
                'cep' => $request->cep,
                'logradouro' => $request->logradouro,
                'complemento' => $request->complemento,
                'bairro' => $request->bairro,
                'estado' => $request->estado,
                'uf' => $request->uf,
            ], $user->access_token);


        } catch(\GuzzleHttp\Exception\ClientException $e) {
            
            $response = $e->getResponse();

            if($e->getCode() == 401)
                return redirect('login');

            return redirect()->back()->with('error', 'Contate o Administrador');
        }
        

        return redirect('suppliers/list');
    }


    /**
     * Form Editar
     */
    public function edit(Request $request, $id){

        $user = $request->session()->get('user');

        try {   
            $supplier = $this->httpHelper->get("suppliers/get/{$id}", $user->access_token);

        } catch(\GuzzleHttp\Exception\ClientException $e) {

            if($e->getCode() == 401)
                return redirect('login');

            return redirect()->back()->with('error', 'Contate o Administrador');
        }
        

        return view('edit_supplier', ['supplier' => $supplier]);
    }


    /**
     * Update
     */
    public function update(Request $request)
    {

        $user = $request->session()->get('user');

        try {   
            $result = $this->httpHelper->post("suppliers/update/{$request->id}", [
                'nome' => $request->nome,
                'telefone' => preg_replace('/[^0-9]/','',$request->telefone),
                'email' => $request->email,
                'cep' => $request->cep,
                'logradouro' => $request->logradouro,
                'complemento' => $request->complemento,
                'bairro' => $request->bairro,
                'estado' => $request->estado,
                'uf' => $request->uf,
            ], $user->access_token);


        } catch(\GuzzleHttp\Exception\ClientException $e) {
            
            $response = $e->getResponse();

            if($e->getCode() == 401)
                return redirect('login');

            return redirect()->back()->with('error', 'Contate o Administrador');
        }
        

        return redirect('suppliers/list');
    }


    /**
     * Delete
     */
    public function delete(Request $request, $id)
    {

        $user = $request->session()->get('user');

        try {   
            $supplier = $this->httpHelper->delete("suppliers/delete/{$id}", $user->access_token);

        } catch(\GuzzleHttp\Exception\ClientException $e) {

            if($e->getCode() == 401)
                return redirect('login');

            return redirect()->back()->with('error', 'Contate o Administrador');
        }
        

        return redirect('suppliers/list');
    }

}
