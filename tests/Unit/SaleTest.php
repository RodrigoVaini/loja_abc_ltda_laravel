<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Sale;
use App\Http\Controllers\SaleController;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SaleTest extends TestCase {

    use RefreshDatabase;

    public function testCreateSale() {

        $sale = [
            'date' => '2024-03-03',
            'amount' => 10000.00,
            'items' => [
                'product_id' => 1,
                'quantity' => 10,
                'amount' => 1000.00 
            ]
        ];

        $SaleController = new SaleController();
        $newSale = $SaleController->create($sale);

        $this->assertInstanceOf(Sale::class, $newSale);
        $this->assertDatabaseHas('sales', ['id' => $newSale->id]);

    }

    public function testDeleteSale() {

        $sale = Sale::create([
            'date' => '2024-03-03',
            'amount' => 5000.00,
            'items' => [
                'product_id' => 1,
                'quantity' => 5,
                'amount' => 1000.00 
            ]
        ]);

        $SaleController = new SaleController();
        $SaleController->destroy($sale->id);

        $this->assertDatabaseMissing('sales', ['id' => $sale->id]);

    }

}