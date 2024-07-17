<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Reservation;
use App\Models\ReservationDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $reservations = [];
        if(Auth::user()->can('admin')){
            $reservations = Reservation::with('user')->paginate();
        }elseif (Auth::user()->can('access-common')){
            $reservations = Reservation::where('user_id', Auth::id())->with('user')->paginate();
        }

        return view('reservations.index', compact('reservations'))
            ->with('i', ($request->input('page', 1) - 1) * $reservations->perPage());
    }

    public function create()
    {
        $products = Product::all();
        return view('reservations.create', compact('products'));
    }

    public function store(StoreReservationRequest $request)
    {
        DB::transaction(function () use ($request) {
            $reservation = Reservation::create([
                'user_id' => Auth::id(),
                'reservation_date' => now(),
            ]);

            foreach ($request->products as $product) {
                ReservationDetail::create([
                    'reservation_id' => $reservation->id,
                    'product_id' => $product['id'],
                    'reserved_quantity' => $product['quantity'],
                ]);
            }
        });

        return redirect()->route('reservations.index')->with('success', __('Reservation created successfully.'));
    }

    public function show($id)
    {
        $reservation = null;
        if(Auth::user()->can('admin')){
            $reservation = Reservation::findOrfail($id)->with('user');
        }elseif (Auth::user()->can('access-common')){
            $reservation = Reservation::where([
                'id' => $id,
                'user_id' => Auth::id(),
            ])->with('user')->first();
        }
        if(!$reservation){
            return redirect()->route('reservations.index')->with('error', __('Reservation not found.'));
        }
        $reservation->load('reservationDetails.product');
        return view('reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        $products = Product::all();
        $reservation->load('details');
        return view('reservations.edit', compact('reservation', 'products'));
    }

    public function update(StoreReservationRequest $request, Reservation $reservation)
    {
        DB::transaction(function () use ($request, $reservation) {
            $reservation->details()->delete();

            foreach ($request->products as $product) {
                ReservationDetail::create([
                    'reservation_id' => $reservation->id,
                    'product_id' => $product['id'],
                    'reserved_quantity' => $product['quantity'],
                ]);

                $productModel = Product::findOrFail($product['product_id']);
                $productModel->decrement('stock_quantity', $product['quantity']);
            }
        });

        return redirect()->route('reservations.index')->with('success', __('Reservation updated successfully.'));
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('reservations.index')->with('success', __('Reservation deleted successfully.'));
    }
}
