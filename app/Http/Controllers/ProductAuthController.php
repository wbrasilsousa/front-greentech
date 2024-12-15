<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\HttpHelper;

class ProductAuthController extends Controller
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
            $products = $this->httpHelper->get('products/get', $user->access_token);


        } catch(\GuzzleHttp\Exception\ClientException $e) {

            if($e->getCode() == 401)
                return redirect('login');

            return redirect()->back()->with('error', 'Contate o Administrador');
        }

        return view('product', ['products' => $products]);
    }


    /**
     * Form add
     */
    public function add(Request $request){

        $user = $request->session()->get('user');
        
        try {   
            $suppliers = $this->httpHelper->get('suppliers/get', $user->access_token);


        } catch(\GuzzleHttp\Exception\ClientException $e) {

            if($e->getCode() == 401)
                return redirect('login');

            return redirect()->back()->with('error', 'Contate o Administrador');
        }

        return view('add_product', ['suppliers' => $suppliers]);
    }


    /**
     * Salvar
     */
    public function save(Request $request){

        $user = $request->session()->get('user');

        try {   
            $result = $this->httpHelper->post('products/register', [
                'codigo' => $request->codigo,
                'nome' => $request->nome,
                'descricao' => $request->descricao,
                'preco' => $request->preco,
                'categoria' => $request->categoria,
                'quantidade' => $request->quantidade,
                'fornecedor_id' => $request->fornecedor_id,
            ], $user->access_token);


        } catch(\GuzzleHttp\Exception\ClientException $e) {
            
            $response = $e->getResponse();

            if($e->getCode() == 401)
                return redirect('login');

            return redirect()->back()->with('error', 'Contate o Administrador');
        }
        

        return redirect('products/list');
    }


    /**
     * Form Editar
     */
    public function edit(Request $request, $id){

        $user = $request->session()->get('user');

        try {   
            $product = $this->httpHelper->get("products/get/{$id}", $user->access_token);
            $suppliers = $this->httpHelper->get('suppliers/get', $user->access_token);

        } catch(\GuzzleHttp\Exception\ClientException $e) {

            if($e->getCode() == 401)
                return redirect('login');

            return redirect()->back()->with('error', 'Contate o Administrador');
        }
        

        return view('edit_product', ['product' => $product, 'suppliers' => $suppliers ]);
    }


    /**
     * Update
     */
    public function update(Request $request)
    {

        $user = $request->session()->get('user');

        try {   
            $result = $this->httpHelper->post("products/update/{$request->id}", [
                'codigo' => $request->codigo,
                'nome' => $request->nome,
                'descricao' => $request->descricao,
                'preco' => $request->preco,
                'categoria' => $request->categoria,
                'quantidade' => $request->quantidade,
                'fornecedor_id' => $request->fornecedor_id,
            ], $user->access_token);


        } catch(\GuzzleHttp\Exception\ClientException $e) {
            
            $response = $e->getResponse();

            if($e->getCode() == 401)
                return redirect('login');

            return redirect()->back()->with('error', 'Contate o Administrador');
        }
        

        return redirect('products/list');
    }


    /**
     * Delete
     */
    public function delete(Request $request, $id)
    {

        $user = $request->session()->get('user');

        try {   
            $supplier = $this->httpHelper->delete("products/delete/{$id}", $user->access_token);

        } catch(\GuzzleHttp\Exception\ClientException $e) {

            if($e->getCode() == 401)
                return redirect('login');

            return redirect()->back()->with('error', 'Contate o Administrador');
        }
        

        return redirect('products/list');
    }

}
