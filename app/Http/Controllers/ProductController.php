<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller {

    public function getAll() {

        $products = Product::all();
        $products = Product::orderBy('id', 'asc')->get();

        return response()->json(products);

    }

    public function getItem($id) {

        $product = Product::find($id);

        return $product ? response()->json($product) : abort(code:404);
    }

    public function create(Request $request) {

        $request->validate([
            'name' => 'required|string|min:10|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
        ]);

        $product = Product::create($request->all());

        return $product;

    }

    public function edit(Request $request, $id) {

        $name = $request->input('name');
        $description = $request->input('description');
        $price = $request->input('price');

        if ($name) {
            $request->validate([
                'name' => 'required|string|max:255'
            ]);
        }

        if ($description) {
            $request->validate([
                'description' => 'nullable|string'
            ]);
        }

        if ($price) {
            $request->validate([
                'price' => 'required|numeric'
            ]);
        }

        if (! $name && ! $description && ! $price) {
            return response()->json(['message' => 'Nenhum campo informado'], 404);
        }

        $product = Product::find($id);
    
        if (! $product) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }

        if ($name) {
            $product->name = $request->input('name');
        }

        if ($description) {
            $product->description = $request->input('description');
        }

        if ($price) {
            $product->price = $request->input('price');
        }
    
        $product->save();
    
        return response()->json($product);
    }

    public function delete(Request $request, $id) {

        $product = Product::find($id);
    
        if (! $product) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }

        $product->delete();
    
        return response()->json(['message' => 'Produto deletado com sucesso']);
    }

}
