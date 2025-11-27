<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\OrderPlaced;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $user = Auth::user();
        $items = $request->get('items');
        $total = 0;
        $snapshot = [];
        foreach ($items as $item) {
            $product = Product::findOrFail($item['product_id']);
            $subtotal =  $product->price * $item['quantity'];
            $total += $subtotal;
            $snapshot[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $item['quantity'],
                'subtotal' => $subtotal,
            ];
        }
        $order = Order::create(
            [
                'user_id' => $user->id,
                'total' => $total,
                'status' => 'pending',
                'items' => $snapshot,
            ]
        );
        event(new OrderPlaced($order));
        return $this->success($order, 'Order created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::with('payments')->findOrFail((int)$id);
        return $this->success($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
