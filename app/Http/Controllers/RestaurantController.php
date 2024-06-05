<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Rating;
use App\Models\Comment;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index($id)
    {
        $user = Auth::user();
        // Busca el restaurante por su id
        $restaurant = Restaurant::find($id);

        // Si no se encuentra el restaurante, redirige a una página de error o vuelve a la página anterior
        if (!$restaurant) {
            return redirect()->back()->with('error', 'Restaurante no encontrado');
        }

        // Obtener todas las valoraciones asociadas a este restaurante
        $ratings = Rating::where('restaurant_id', $restaurant->id)->get();

        // Calcular el promedio de las valoraciones
        $averageRating = $ratings->avg('rating');
        // Obtener la puntuación del usuario actual si ha votado
        $userRating = $ratings->where('user_id', $user->id)->first();

         // Obtener todos los comentarios asociados a este restaurante
        $comments = Comment::where('restaurant_id', $restaurant->id)->with('user')->get();

        // Si se encuentra el restaurante, pasa los datos a la vista
        return Inertia::render('Restaurant/Index', [
        'restaurant' => $restaurant,
        'ratings' => $averageRating,
        'comments' => $comments,
        'userRating' => $userRating ? $userRating->rating : null,
        'user' => $user,
    ]);
    }

    public function misRestaurantes()
    {
        $user = Auth::user();
        
        // Obtener todos los restaurantes del usuario actual
        $restaurants = Restaurant::where('user_id', $user->id)->get();
        
        // Renderizar la vista con los datos
        return Inertia::render('Restaurant/MisRestaurants', [
            'restaurants' => $restaurants  // Cambia 'restaurant' por 'restaurants'
        ]);
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

    return Redirect::route('misRestaurantes');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         
         $restaurant = Restaurant::findOrFail($id);

         
         $restaurant->delete();
 
         
         return Redirect::route('misRestaurantes');
     }
     
    
}
