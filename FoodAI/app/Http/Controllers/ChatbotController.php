<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LucianoTonet\GroqPHP\Groq;

class ChatbotController extends Controller
{
    public function saveIngredients(Request $request)
    {
        $ingredients = $request->input('ingredients', '');
        session(['ingredients' => explode(',', $ingredients)]); // Store ingredients in session

        return response()->json([
            'message' => 'Bahan-bahan berhasil disimpan.',
            'ingredients' => session('ingredients', [])
        ]);
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