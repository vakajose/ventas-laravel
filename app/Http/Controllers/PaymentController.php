<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $sale = Sale::findOrFail($request->sale_id);
        return view('payments.create', compact('sale'));
    }

    public function store(StorePaymentRequest $request)
    {
        DB::transaction(function () use ($request) {
            $sale = Sale::findOrFail($request->sale_id);
            Payment::create([
                'sale_id' => $sale->id,
                'payment_date' => now(),
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
            ]);

            $sale->update(['state' => 'PAYED']);
        });

        return redirect()->route('sales.index')->with('success', __('Payment processed successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
