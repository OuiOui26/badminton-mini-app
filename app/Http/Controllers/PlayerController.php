<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Player;
use App\Http\Resources\PlayerResource;
use App\Http\Requests\PlayerRequest;


class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Player::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(PlayerRequest $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlayerRequest $request)
    {
        $validated = $request->validated();
    
        $player = new Player();
        $player->player_name = $validated['player_name'];
        $player->save();
    
        return redirect()->back()->with('success', 'Player successfully created!');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('PlayerList', [
            'players' => PlayerResource::collection(Player::all())->toArray(request()),
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
