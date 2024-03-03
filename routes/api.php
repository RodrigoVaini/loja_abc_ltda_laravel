<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('products', [ProductController::class, 'getAll']);
Route::get('products/{id}', [ProductController::class, 'getItem']);
Route::post('products/create', [ProductController::class, 'create']);
Route::put('products/{id}', [ProductController::class, 'edit']);
Route::delete('products/{id}', [ProductController::class, 'delete']);

/**
 * @OA\Get(
 *     path="/api/sales",
 *     tags={"Sales"},
 *     summary="Listar todas as vendas",
 *     @OA\Response(response="200", description="Lista das vendas"),
 *     @OA\Response(response="404", description="Vendas não encontradas")
 * )
 */
Route::get('sales', [SaleController::class, 'getAll']);

/**
 * @OA\Get(
 *     path="/api/sales/{id}",
 *     tags={"Sales"},
 *     summary="Listar venda especifica pelo ID",
 *     @OA\Parameter(name="id", in="path", required=true, description="Listar pelo ID", @OA\Schema(type="integer")),
 *     @OA\Response(response="200", description="Detalhes da venda"),
 *     @OA\Response(response="404", description="Venda não encontrada")
 * )
 */
Route::get('sales/{id}', [SaleController::class, 'getById']);

/**
 * @OA\Get(
 *     path="/api/sales/date/{id}",
 *     tags={"Sales"},  
 *     summary="Listar venda especifica por DATA",
 *     @OA\Parameter(name="date", in="path", required=true, description="Listar pela DATA", @OA\Schema(type="date")),
 *     @OA\Response(response="200", description="Lista das vendas"),
 *     @OA\Response(response="404", description="Vendas não encontradas")
 * )
 */
Route::get('sales/date/{date}', [SaleController::class, 'getSalesByDate']);

/**
 * @OA\Post(
 *     path="/api/sales",
 *     tags={"Sales"},
 *     summary="Cadastrar nova venda",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Informações da nova venda",
 *         @OA\JsonContent(
 *             @OA\Property(property="date", type="string", format="date", example="2024-03-03"),
 *             @OA\Property(property="amount", type="string", example="5000.00"),
 *             @OA\Property(
 *                 property="items",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="product_id", type="integer"),
 *                     @OA\Property(property="quantity", type="integer"),
 *                     @OA\Property(property="amount", type="string")
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(response=201, description="Venda cadastrada"),
 *     @OA\Response(response="404", description="Venda não encontrada")
 * )
 */
Route::post('sales', [SaleController::class, 'create']);

/**
*  @OA\Delete(
*      path="/api/sales/{id}",
*      tags={"Sales"},
*      summary="Exclui venda especifica pelo ID",
*      @ OA\Parameter(name="id", in="path", required=true, description="Exclui pelo ID", @OA\Schema(type="integer")),
*      @ OA\Response(response=200, description="Venda deletada"),
*      @ OA\Response(response=404, description="Venda não encontrada")
*  )
*/
Route::delete('sales/{id}', [SaleController::class, 'delete']);

/**
 * @OA\Post(
 *     path="/api/sales/{id}/items",
 *     tags={"Sales"},
 *     summary="Cadastrar novo item na venda",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Informações da venda",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="items",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="product_id", type="integer"),
 *                     @OA\Property(property="quantity", type="integer"),
 *                     @OA\Property(property="amount", type="string")
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(response=201, description="Item cadastrado"),
 *     @OA\Response(response="404", description="Venda não encontrada")
 * )
 */
Route::post('/sales/{id}/items', [SaleController::class, 'addItem']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
