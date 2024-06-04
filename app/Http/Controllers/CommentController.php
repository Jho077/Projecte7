<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CommentController extends Controller
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

    $comment = new Comment;
    $comment->user_id = $request->user()->id;
    $comment->restaurant_id = $request->restaurant_id;
    $comment->comment = $request->comment;
    $comment->save();

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
    public function update(Request $request, Comment $comment)
{
    // Verificar si el usuario actual es el propietario del comentario
    if ($comment->user_id !== $request->user()->id) {
        return redirect()->back()->with('error', 'No tienes permiso para editar este comentario');
    }

    $comment->comment = $request->comment;
    $comment->save();

    return Inertia::location(route('showRestaurant', ['id' => $request->restaurant_id]));
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    // Buscar el comentario por su ID
    $comment = Comment::findOrFail($id);

    // Verificar si el usuario actual es el propietario del comentario
    if ($comment->user_id !== auth()->id()) {
        return redirect()->back()->with('error', 'No tienes permiso para eliminar este comentario');
    }

    // Almacenar el ID del restaurante antes de eliminar el comentario
    $restaurantId = $comment->restaurant_id;

    // Eliminar el comentario
    $comment->delete();

    // Redirigir al usuario a la página del restaurante
    return Inertia::location(route('showRestaurant', ['id' => $restaurantId]));
}
}
