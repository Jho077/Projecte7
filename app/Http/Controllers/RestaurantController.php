<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Redirect;


class RestaurantController extends Controller
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
        {
            return Inertia::render('Restaurant/Create');
        }
    
    }

    /**
     * Store a newly created resource in storage.
     */
        public function store(Request $request)
    {

        $imagePath = $request->file('image')->store('restaurant_images', 'public');
        
        $restaurant = new Restaurant();
        $restaurant->name = $request->input('name');
        $restaurant->address = $request->input('address');
        $restaurant->latitude = $request->input('latitude');
        $restaurant->longitude = $request->input('longitude');
        $restaurant->description = $request->input('description');
        $restaurant->image = $imagePath;
        
        $restaurant->user_id = auth()->id();
        $restaurant->save();

        
        return redirect()->route('welcome');
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
    public function edit($id)
{
    
    $restaurant = Restaurant::findOrFail($id);

    
    return Inertia::render('Restaurant/Edit', [
        'restaurant' => $restaurant
    ]);
}
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $restaurant = Restaurant::findOrFail($id);

    $restaurant->name = $request->input('name');
    $restaurant->address = $request->input('address');
    $restaurant->latitude = $request->input('latitude');
    $restaurant->longitude = $request->input('longitude');
    $restaurant->description = $request->input('description');
    
    if($request->hasFile('image')) {
        $restaurant->image = $request->file('image')->store('restaurant_images', 'public');
    }

    
    $restaurant->save();

    return Redirect::route('welcome');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         
         $restaurant = Restaurant::findOrFail($id);

         
         $restaurant->delete();
 
         
         return Redirect::route('welcome');
     }
    
}
