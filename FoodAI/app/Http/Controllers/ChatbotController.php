<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LucianoTonet\GroqPHP\Groq;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class ChatbotController extends Controller
{
    public function saveIngredients(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/signin')->with('error', 'You must be logged in to add ingredients.');
        }

        // Validate the request data
        $validatedData = $request->validate([
            'ingredient_category' => 'required|string',
            'storage_type' => 'required|string',
            'ingredient_name' => 'required|string|max:255',
            'ingredient_quantity' => 'required|integer|min:1',
            'ingredient_production_date' => 'required|date',
            'ingredient_expiry' => 'required|date|after_or_equal:ingredient_production_date',
        ]);

        \Log::info('Validation passed', $validatedData);

        // Use a placeholder image since the Groq API call is removed
        $imageUrl = asset('images/Gambar_pangan_Lokal.jpg'); // Default placeholder image

        try {
            // Save the ingredient to the database with proper data formatting
            DB::table('Bahan_Pengguna')->insert([
                'ID_Pengguna' => auth()->id(), // Associate the ingredient with the authenticated user
                'Nama_Bahan' => $validatedData['ingredient_name'],
                'Kategori_Bahan' => $validatedData['ingredient_category'],
                'Jumlah_Bahan' => $validatedData['ingredient_quantity'],
                'Tipe_Penyimpanan' => substr($validatedData['storage_type'], 0, 50), // Limit the length to avoid truncation
                'Tanggal_Produksi' => $validatedData['ingredient_production_date'],
                'Tanggal_Kadaluarsa' => $validatedData['ingredient_expiry'],
                'Image_Bahan' => $imageUrl, // Save the placeholder image URL
                'Tgl_Pembuatan' => now(),
            ]);

            \Log::info('Ingredient saved successfully', $validatedData);

            return redirect('/storage')->with('success', 'Ingredient added successfully!');
        } catch (\Exception $e) {
            // Log the error with more details for debugging
            \Log::error("Error saving ingredient: " . $e->getMessage());
            \Log::error("Data that caused the error: " . json_encode($validatedData));
            
            return redirect('/storageform')->with('error', 'Failed to save ingredient. Please try again.');
        }
    }

    public function getRecommendation(Request $request)
    {
        $query = $request->input('query', '');
        $temperature = $request->input('temperature', 0.7);

        $groq = new Groq(env('GROQ_API_KEY')); // Use the API key from environment variables

        $ingredientsList = implode(', ', session('ingredients', []));
        $query = "Berdasarkan bahan-bahan ini: $ingredientsList, rekomendasikan sebuah resep.";

        try {
            $apiResponse = $groq->chat()->completions()->create([
                'model' => 'llama3-8b-8192',
                'temperature' => (float) $temperature,
                'messages' => [
                    ['role' => 'user', 'content' => $query]
                ],
            ]);

            $responseContent = $apiResponse['choices'][0]['message']['content'] ?? 'Tidak ada konten respons yang ditemukan.';

            return response()->json([
                'message' => 'Rekomendasi berhasil dibuat.',
                'recommendation' => $responseContent
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function chatbot(Request $request)
    {
        $chatMessage = $request->input('chat_message', '');

        $groq = new Groq(env('GROQ_API_KEY')); // Use the API key from environment variables

        try {
            $apiResponse = $groq->chat()->completions()->create([
                'model' => 'llama3-8b-8192',
                'temperature' => 0.7,
                'messages' => [
                    ['role' => 'user', 'content' => $chatMessage]
                ],
            ]);

            $botResponse = $apiResponse['choices'][0]['message']['content'] ?? 'Tidak ada konten respons yang ditemukan.';

            return response()->json(['response' => $botResponse]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function visionAnalyze(Request $request)
    {
        $groq = new Groq(env('GROQ_API_KEY')); // Use the API key from environment variables

        if ($request->has('image_url')) {
            $imageSource = $request->input('image_url'); // URL of the image
        } elseif ($request->hasFile('image_file')) {
            $imageSource = $request->file('image_file')->getPathname(); // Path to the uploaded image
        } else {
            return response()->json(['error' => 'No image provided.'], 400);
        }

        try {
            $visionResponse = $groq->vision()->analyze($imageSource, 'Describe this image', [
                'model' => 'meta-llama/llama-4-scout-17b-16e-instruct'
            ]);

            $visionDescription = $visionResponse['choices'][0]['message']['content'] ?? 'Tidak ada deskripsi yang ditemukan.';

            return response()->json([
                'message' => 'Analisis gambar berhasil.',
                'description' => $visionDescription
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}