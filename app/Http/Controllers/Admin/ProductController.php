<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Traits\UploadTrait;
use App\Http\Requests\ProductRequest; //Importando a classe que vai mandar as mensagens

class ProductController extends Controller
{

    use UploadTrait;

    private $product;

    public function __construct(Product $product) { // pra eu nao precisar ficar chamando o model, assim ele ja adiciona a instancia do produto/model nesse construct
        $this->product = $product;
    }
   
    public function index()
    {
        $userStore = auth()->user()->store;
        $products = $userStore->products()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

  
    public function create()
    {
        $categories = \App\Category::all(['id', 'name']);

        return view('admin.products.create', compact('categories'));
    }


    public function store(ProductRequest $request)
    {
        $data = $request->all();

        $categories = $request->get('categories', null);
        
        $store = auth()->user()->store;
        $product = $store->products()->create($data);

        $product->categories()->sync($categories);

        if($request->hasFile('photos')) {
            $images = $this->imageUpload($request->file('photos'), 'image');

            $product->photos()->createMany($images);
        }

        flash('Produto Criado com Sucesso!')->success();

        return redirect()->route('admin.products.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($product)
    {
        $product = $this->product->findOrFail($product); //se falhar da um 404

        $categories = \App\Category::all(['id', 'name']);

        return view('admin.products.edit', compact('product', 'categories'));
    }


    public function update(ProductRequest $request, $product)
    {
        $data = $request->all();

        $categories = $request->get('categories', null);

        $product = $this->product->find($product);
        $product->update($data);

        if(!is_null($categories))

            $product->categories()->sync($categories);

        if($request->hasFile('photos')) {
            $images = $this->imageUpload($request->file('photos'), 'image');

            $product->photos()->createMany($images);
        }

        flash('Produto Atualizado com Sucesso!')->success();

        return redirect()->route('admin.products.index');
    }


    public function destroy($product)
    {

        $product = $this->product->find($product);

        $product->delete();

        flash('Produto Removido com Sucesso!')->success();

        return redirect()->route('admin.products.index');
    }


}
