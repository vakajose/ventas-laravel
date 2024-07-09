<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Http\Requests\StoreInventoryRequest;
use App\Http\Requests\UpdateInventoryRequest;
use App\Models\InventoryDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $inventories = Inventory::paginate();
        return view('inventory.index', compact('inventories'))
            ->with('i', ($request->input('page', 1) - 1) * $inventories->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        return view('inventory.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInventoryRequest $request)
    {
        DB::transaction(function () use ($request) {
            $inventory = Inventory::create([
                'type' => $request->type,
            ]);

            foreach ($request->products as $product) {
                InventoryDetail::create([
                    'inventory_id' => $inventory->id,
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'],
                ]);

                $productModel = Product::findOrFail($product['product_id']);
                if ($request->type == 'add') {
                    $productModel->increment('stock_quantity', $product['quantity']);
                } else {
                    $productModel->decrement('stock_quantity', $product['quantity']);
                }
            }
        });

        return redirect()->route('inventories.index')->with('success', 'Inventory created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($inventory)
    {
        $inventory = Inventory::findOrFail($inventory);
        $inventory->load('inventoryDetails.product');
        return view('inventory.show', compact('inventory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInventoryRequest $request, $inventory_id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($inventory_id)
    {
        //
    }
}
