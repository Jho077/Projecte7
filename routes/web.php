<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Inertia\Inertia;
use App\Models\Rating;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\CommentController;


//Ruta del welcome
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'loged' => Auth::user(),
        'rating' => Rating::all(),
        'restaurant' => Restaurant::all(),
    ]);
})->name('welcome');
Route::get('/api/restaurants', function (Request $request) {
    
    $rating = $request->query('rating', 0);

    $restaurants = DB::select('
        SELECT rr.*, AVG(r.rating) as average_rating
        FROM restaurants rr
        LEFT JOIN ratings r ON rr.id = r.restaurant_id 
        GROUP BY rr.id
        HAVING average_rating <= ?
    ', [$rating]);

    return response()->json($restaurants);
});
// Rutas para Oauth con Google
Route::get('/google-auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});
 
Route::get('/google-auth/callback', function () {
    $user_google = Socialite::driver('google')->stateless()->user();
    
    $user = User::updateOrCreate(
        ['google_id' => $user_google->id],
        ['name' => $user_google->name,
        'email' => $user_google->email]
    );
    Auth::login($user);

    return redirect()->route('welcome');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Rutas para los restaurants
Route::resource('restaurants', RestaurantController::class);
Route::post('/restaurants/{id}',[RestaurantController::class, 'update'])->name('updateImage');
Route::get('/restaurants/{id}/index',[RestaurantController::class, 'index'])->name('showRestaurant');

// Ruta para crear una valoración
Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store');

// Ruta para crear un comentario
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store'); 
 
Route::put('/comments/{comment}/update', [CommentController::class, 'update'])->name('comments.update');
Route::delete('/comments/{id}/delete', [CommentController::class, 'destroy'])->name('comments.destroy');

Route::get('/misRestaurantes', [RestaurantController::class, 'misRestaurantes'])->name('misRestaurantes');

});















require __DIR__.'/auth.php';
