<?php
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\AuthController;

// Default route to redirect to the landing page
Route::get('/landingpage', function () {
    return view('landingpage'); // Render the landing page as the default view
})->name('landingpage');

// Routes for Authentication
Route::get('/signin', function () {
    return view('signinpage');
})->name('signin');
Route::post('/signin', [AuthController::class, 'signin'])->name('signin');

Route::get('/signup', function () {
    return view('signuppage');
})->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes for ChatbotController
Route::post('/save-ingredients', [ChatbotController::class, 'saveIngredients'])->name('save.ingredients');
Route::post('/get-recommendation', [ChatbotController::class, 'getRecommendation'])->name('get.recommendation');
Route::post('/chatbot', [ChatbotController::class, 'chatbot'])->name('chatbot');
Route::post('/vision-analyze', [ChatbotController::class, 'visionAnalyze'])->name('vision.analyze');

// Storage Page Route
Route::get('/storage', function () {
    // if (!auth()->check()) {
    //     return redirect('/signin')->with('error', 'You must be logged in to view storage.');
    // }

    $ingredients = \App\Models\BahanPengguna::where('ID_Pengguna', auth()->id())->get();

    return view('storagepage', [
        'ingredients' => $ingredients,
    ]);
})->name('storagepage');
// Storage Form Route
Route::get('/storageform', function () {
    return view('storageform');
})->name('storageform');
Route::get('/set-session', function () {
    session(['user' => [
        'id' => 1, // Replace with the ID of the test user
        'name' => 'TestUser',
        'email' => 'testuser@example.com',
        'role' => 'User',
    ]]);

    return redirect('/storage')->with('success', 'Session set successfully!');
});