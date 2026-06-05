<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required'
        ]);

        $product = Product::findOrFail(
            $request->product_id
        );

        $order = Order::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'total_price' =>
                $product->price * $request->quantity,
            'status' => 'pending'
        ]);

        return response()->json([
            'message' => 'Order berhasil dibuat',
            'data' => $order
        ]);
    }
}