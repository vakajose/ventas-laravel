<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePromotionRequest;
use App\Http\Requests\UpdatePromotionRequest;
use App\Models\Promotion;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $promotions = Promotion::paginate();

        return view('promotion.index', compact('promotions'))
            ->with('i', ($request->input('page', 1) - 1) * $promotions->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $products = Product::all();
        return view('promotion.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePromotionRequest $request): RedirectResponse
    {
        Promotion::create($request->validated());

        return Redirect::route('promotions.index')
            ->with('success', 'Promotion created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $promotion = Promotion::find($id);

        return view('promotion.show', compact('promotion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $promotion = Promotion::find($id);
        $products = Product::all();
        return view('promotion.edit', compact('promotion','products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePromotionRequest $request,  $promotion_id): RedirectResponse
    {
        print_r($promotion_id);
        $promotion = Promotion::findOrFail($promotion_id);
        $promotion->update($request->validated());

        return Redirect::route('promotions.index')
            ->with('success', 'Promotion updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Promotion::find($id)->delete();

        return Redirect::route('promotions.index')
            ->with('success', 'Promotion deleted successfully');
    }
}
