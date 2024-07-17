<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sales = Sale::with('user', 'saleDetails.product')->paginate();
        return view('sales.index', compact('sales'))
            ->with('i', ($request->input('page', 1) - 1) * $sales->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        return view('sales.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaleRequest $request)
    {
        DB::transaction(function () use ($request) {
            $sale = Sale::create([
                'user_id' => $request->user()->id,
                'sale_date' => now(),
                'total_amount' => 0, // We will update this later
                'state' => 'PENDING' // Default state
            ]);

            $totalAmount = 0;
            foreach ($request->products as $product) {
                $productModel = Product::findOrFail($product['id']);
                $productModel->decrement('stock_quantity', $product['quantity']);

                $totalAmount += $product['quantity'] * $productModel->price;

                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product['id'],
                    'quantity' => $product['quantity'],
                    'price' => $productModel->price,
                ]);
            }

            $sale->update(['total_amount' => $totalAmount]);
        });

        return redirect()->route('sales.index')->with('success', __('Sale created successfully.'));
    }

    public function cancel($id)
    {
        DB::transaction(function () use ($id) {
            $sale = Sale::findOrFail($id);
            $sale->update(['state' => 'CANCELED']);

            foreach ($sale->saleDetails as $detail) {
                $product = Product::findOrFail($detail->product_id);
                $product->increment('stock_quantity', $detail->quantity);
            }
        });

        return redirect()->route('sales.index')->with('success', __('Sale canceled successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $sale = Sale::with('user', 'saleDetails.product', 'payments')->findOrFail($id);
        return view('sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSaleRequest $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
