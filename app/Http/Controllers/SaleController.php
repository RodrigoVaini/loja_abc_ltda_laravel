<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use App\Models\SaleItems;

class SaleController extends Controller {

    public function getAll()  {

        $result = [];

        $sales = Sale::all();
        $sales = Sale::orderBy('id', 'asc')->get();

        if (! $sales) {
            return response()->json(['message' => 'Nenhuma venda encontrada'], 404);
        }

        foreach($sales as &$sale) {

            $items = DB::table('items')
                ->join('products', 'items.products_id', '=', 'products.id')
                ->where('items.sales_id', $sale->id)
                ->select('items.id', 'products.name', 'items.quantity', 'items.amount')
                ->get();

            $array = [
                "id" => $sale->id,
                "date" => $sale->date,
                "amount" => $sale->amount,
                "items" => $items
            ];

            array_push($result, $array);

        }

        return $result ? response()->json($result) : abort(code:404);

    }

    public function getById($id) {

        $result = [];

        $sale = Sale::find($id);

        if (! $sale) {
            return response()->json(['message' => 'Venda não encontrada'], 404);
        }

        $items = DB::table('items')
            ->join('products', 'items.products_id', '=', 'products.id')
            ->where('items.sales_id', $id)
            ->select('items.id', 'products.name', 'items.quantity', 'items.amount')
            ->get();

        $array = [
            "id" => $sale->id,
            "date" => $sale->date,
            "amount" => $sale->amount,
            "items" => $items
        ];

        array_push($result, $array);

        return $result ? response()->json($result) : abort(code:404);

    }

    public function getSalesByDate($date) {

        $result = [];

        $sales = DB::table('sales')
            ->where('date', $date)
            ->orderBy('date', 'asc')
            ->get();

        if (! $sales->count() > 0) {
            return response()->json(['message' => 'Nenhuma venda encontrada'], 404);
        }
    
        foreach($sales as $sale) {

            $items = DB::table('items')
                ->join('products', 'items.products_id', '=', 'products.id')
                ->where('items.sales_id', $sale->id)
                ->select('items.id', 'products.name', 'items.quantity', 'items.amount')
                ->get();

            $array = [
                "id" => $sale->id,
                "date" => $sale->date,
                "amount" => $sale->amount,
                "items" => $items
            ];

            array_push($result, $array);
        }

        return $result ? response()->json($result) : abort(code:404);

    }

    public function create(Request $request) {

        $validated = $request->validate([
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'items' => 'required|array',
            'items.*.product_id' => 'required|integer',
            'items.*.amount' => 'required|numeric',
            'items.*.quantity' => 'required|integer',
        ]);

        $sale = Sale::create([
            'date' => $validated['date'],
            'amount' => $validated['amount']
        ]);

        foreach($validated['items'] as $item) {

            SaleItems::create([
                'sales_id' => $sale->id,
                'products_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'amount' => $item['amount']
            ]);

        }

        return response()->json($sale, 201);

    }

    public function delete($id) {

        $sale = Sale::find($id);

        if (! $sale) {
            return response()->json(['message' => 'Venda não encontrada'], 404);
        }

        $sale->Items()->delete();

        $sale->delete();

        return response()->json(['message' => 'Venda excluida com sucesso'], 200);

    }

    public function addItem(Request $request, $id) {

        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|integer',
            'items.*.amount' => 'required|numeric',
            'items.*.quantity' => 'required|integer',
        ]);

        $sale = Sale::find($id);
    
        if (! $sale) {
            return response()->json(['message' => 'Venda não encontrada'], 404);
        }

        $total = 0;

        foreach($validated['items'] as $item) {

            $item = new SaleItems([
                'sales_id' => $sale->id,
                'products_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'amount' => $item['amount']
            ]);

            $sale->Items()->save($item);
    
            $total += $item->quantity * $item->amount;
        }

        $sale->amount = $total;
        $sale->save();

        return response()->json($sale, 201);

    }

}
