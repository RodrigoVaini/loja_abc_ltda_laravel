<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Http\Controllers\ProductController;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase {

    use RefreshDatabase;

    public function testCreateProduct() {

        $product = [
            'name' => 'Smartphone Infinix Hot 30i',
            'description' => 'Smartphone Infinix Hot 30i 128GB Azul 4G MediaTek 8GB RAM 6,6 Câm. 50MP + Selfie 5MP Dual Chip',
            'price' => 764.10
        ];

        $prodController = new ProductController();
        $newProd = $prodController->create($product);

        $this->assertInstanceOf(Product::class, $newProd);
        $this->assertDatabaseHas('products', ['id' => $newProd->id]);

    }

    public function testDeleteProduct() {

        $product = Product::create([
            'name' => 'Smartphone Infinix Smart 7',
            'description' => 'Smartphone Infinix Smart 7 64GB Preto 4G MediaTek 3GB RAM 6,6 Câm. 13MP + Selfie 5MP Dual Chip',
            'price' => 539.10
        ]);

        $prodController = new ProductController();
        $prodController->destroy($product->id);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);

    }

}