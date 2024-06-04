<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RatingController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    //Ver si el usuario ya voto
    $existingRating = Rating::where('user_id', $request->user()->id)
    ->where('restaurant_id', $request->restaurant_id)
    ->first();

     // Usuario que ya voto, se actualiza su voto
    if ($existingRating) {
    $existingRating->rating = $request->rating;
    $existingRating->save();

    return Inertia::location(route('showRestaurant', ['id' => $request->restaurant_id]));
    }

    // Usuario que nunca voto
    $rating = new Rating;
    $rating->user_id = $request->user()->id;
    $rating->restaurant_id = $request->restaurant_id;
    $rating->rating = $request->rating;
    $rating->save();
    
    return Inertia::location(route('showRestaurant', ['id' => $request->restaurant_id]));
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
