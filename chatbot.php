<?php
require 'vendor/autoload.php';

use LucianoTonet\GroqPHP\Groq;

header('Content-Type: application/json');

$response = [];
$errorMessage = '';

session_start();

try {
    // Get the JSON input from the request
    $input = json_decode(file_get_contents('php://input'), true);

    // Handle ingredient input
    if (isset($input['ingredients'])) {
        $ingredients = $input['ingredients'] ?? '';
        $_SESSION['ingredients'] = explode(',', $ingredients); // Store ingredients in session
        $response = ['message' => 'Bahan-bahan berhasil disimpan.', 'ingredients' => $_SESSION['ingredients']];
    }

    // Handle food recommendation
    if (isset($input['query'])) {
        $query = $input['query'] ?? '';
        $temperature = $input['temperature'] ?? 0.7;

        $groq = new Groq('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'); // Pass the API key directly

        $ingredientsList = implode(', ', $_SESSION['ingredients'] ?? []);
        $query = "Berdasarkan bahan-bahan ini: $ingredientsList, rekomendasikan sebuah resep.";

        $apiResponse = $groq->chat()->completions()->create([
            'model' => 'llama3-8b-8192',
            'temperature' => (float) $temperature,
            'messages' => [
                ['role' => 'user', 'content' => $query]
            ],
        ]);

        $responseContent = $apiResponse['choices'][0]['message']['content'] ?? 'Tidak ada konten respons yang ditemukan.';
        $response = ['message' => 'Rekomendasi berhasil dibuat.', 'recommendation' => $responseContent];
    }

    // Handle chatbot interaction
    if (isset($input['chat_message'])) {
        $chatMessage = $input['chat_message'] ?? '';

        $groq = new Groq('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'); // Pass the API key directly

        $apiResponse = $groq->chat()->completions()->create([
            'model' => 'llama3-8b-8192',
            'temperature' => 0.7,
            'messages' => [
                ['role' => 'user', 'content' => $chatMessage]
            ],
        ]);

        $botResponse = $apiResponse['choices'][0]['message']['content'] ?? 'Tidak ada konten respons yang ditemukan.';
        $response = ['response' => $botResponse];
    }

    // Handle vision chatbot interaction
    if (isset($input['image_url']) || isset($_FILES['image_file'])) {
        $groq = new Groq('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'); // Pass the API key directly

        if (isset($input['image_url'])) {
            $imageSource = $input['image_url']; // URL of the image
        } elseif (isset($_FILES['image_file'])) {
            // Save the uploaded file temporarily
            $uploadedFile = $_FILES['image_file']['tmp_name'];
            $imageSource = $uploadedFile; // Path to the uploaded image
        }

        try {
            // Specify the new model for vision analysis
            $visionResponse = $groq->vision()->analyze($imageSource, 'Describe this image', [
                'model' => 'meta-llama/llama-4-scout-17b-16e-instruct'
            ]);
            $visionDescription = $visionResponse['choices'][0]['message']['content'] ?? 'Tidak ada deskripsi yang ditemukan.';
            $response = ['message' => 'Analisis gambar berhasil.', 'description' => $visionDescription];
        } catch (\LucianoTonet\GroqPHP\GroqException $e) {
            error_log('Groq API Error: ' . $e->getMessage());
            $response = ['error' => 'Error: ' . $e->getMessage()];
        }
    }
} catch (\LucianoTonet\GroqPHP\GroqException $e) {
    $response = ['error' => 'Error: ' . $e->getMessage()];
} catch (Exception $e) {
    $response = ['error' => 'Terjadi kesalahan yang tidak terduga: ' . $e->getMessage()];
}

// Return the JSON response
echo json_encode($response);