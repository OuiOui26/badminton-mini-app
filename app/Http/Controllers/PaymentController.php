<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use App\Models\PaymentModel;
use App\Models\Player;
use App\Http\Requests\PaymentsRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\PlayerResource;

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
        $players = $validated['players'] ?? []; 
        Log::info('Received Form Data:', $validated);

        $totalCourtCost = $validated['court_hours'] * $validated['court_rate'];
        $totalShuttleCost = $validated['shuttle_num'] * $validated['shuttle_rate'];
        $totalCost = $totalCourtCost + $totalShuttleCost;
        
        $playerCount = count($players);
        $paymentPerPerson = $playerCount > 0 ? $totalCost / $playerCount : 0;

        $payment = new PaymentModel();
        $payment->court_hours = $validated['court_hours'];
        $payment->court_rate = $validated['court_rate'];
        $payment->shuttle_num = $validated['shuttle_num'];
        $payment->shuttle_rate = $validated['shuttle_rate'];
        $payment->total_cost = $totalCost;
        $payment->payment_per_person = $paymentPerPerson;
        $payment->date = now();
        $payment->save(); 
        
        if (!empty($validated['players'])) {
            $payment->players()->attach($validated['players'], ['paid' => 0]);
        }

        Log::info('Payment Created:', ['payment_id' => $payment->id]);

        return Redirect::route('payments.show', ['payment' => $payment->id])
        ->with('success', 'Payment recorded successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentModel $payment)
    {
        $players = $payment->players()->withPivot('paid')->get();
        return Inertia::render('ShowPayments', [
            'payment' => new PaymentResource($payment),
            'players' => PlayerResource::collection($players)->toArray(request()), 
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
    public function update(UpdatePaymentRequest $request, PaymentModel $payment)
    {
        $validated = $request->validated();

        $payment->update([
            'court_hours' => $validated['court_hours'],
            'court_rate' => $validated['court_rate'],
            'shuttle_num' => $validated['shuttle_num'],
            'shuttle_rate' => $validated['shuttle_rate'],
            'total_cost' => $validated['total_cost'],
            'payment_per_person' => $validated['payment_per_person'],
        ]);
    
        if (!empty($validated['players'])) {
            foreach ($validated['players'] as $playerData) {
                $payment->players()->updateExistingPivot(
                    $playerData['id'],
                    ['paid' => $playerData['paid']]
                );
            }
        }
    
        return response()->json(['message' => 'Payment updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function addPlayer(Request $request, PaymentModel $payment)
    {
        $validated = $request->validate([
            'player_id' => 'required|exists:players,id',
        ]);
    
        $payment->players()->attach($validated['player_id']);
    
        return back()->with('success', 'Player added successfully!');
    }

    public function getPlayers(PaymentModel $payment)
    {
        $players = $payment->players()->get();
        
        return response()->json([
            'success' => true,
            'players' => $players
        ]);
    }

    
}
