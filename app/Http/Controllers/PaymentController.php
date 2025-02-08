<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use App\Models\PaymentModel;
use App\Http\Requests\PaymentsRequest;
use App\Http\Resources\PaymentResource;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('CreatePayment');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentsRequest $request)
    {
        $validated = $request->validated();

        Log::info('Received Form Data:', $validated);

        $totalCourtCost = $validated['court_hours'] * $validated['court_rate'];
        $totalShuttleCost = $validated['shuttle_num'] * $validated['shuttle_rate'];
        $totalCost = $totalCourtCost + $totalShuttleCost;
        $paymentPerPerson = $totalCost / $validated['players'];

        $payment = new PaymentModel();
        $payment->court_hours = $validated['court_hours'];
        $payment->court_rate = $validated['court_rate'];
        $payment->shuttle_num = $validated['shuttle_num'];
        $payment->shuttle_rate = $validated['shuttle_rate'];
        $payment->total_cost = $totalCost;
        $payment->payment_per_person = $paymentPerPerson;
        $payment->date = now();

        $payment->save();

        Log::info('Payment Created:', ['payment_id' => $payment->id]);

        return Redirect::route('payments.show', ['payment' => $payment->id])
        ->with('success', 'Payment recorded successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentModel $payment)
    {
        return Inertia::render('ShowPayments', [
            'payment' => new PaymentResource($payment),
            'flash' => session('success'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
