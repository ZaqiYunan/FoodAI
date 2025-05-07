<?php
use App\Http\Controllers\ChatbotController;

Route::post('/save-ingredients', [ChatbotController::class, 'saveIngredients']);
Route::post('/get-recommendation', [ChatbotController::class, 'getRecommendation']);
Route::post('/chatbot', [ChatbotController::class, 'chatbot']);
Route::post('/vision-analyze', [ChatbotController::class, 'visionAnalyze']);
Route::get('/', function () {
    return view('landingpage'); 
});
Route::get('/storage', function () {
    $ingredients = session('ingredients', []);
    return view('storagepage', ['ingredients' => $ingredients]);
});