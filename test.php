<?php
require 'vendor/autoload.php';

use LucianoTonet\GroqPHP\Groq;

$responseContent = '';
$errorMessage = '';
$recommendations = [];

session_start();

// Handle ingredient input
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ingredients'])) {
    $ingredients = $_POST['ingredients'] ?? '';
    $_SESSION['ingredients'] = explode(',', $ingredients); // Store ingredients in session
}

// Handle food recommendation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['query'])) {
    $query = $_POST['query'] ?? '';
    $temperature = $_POST['temperature'] ?? 0.7;

    $groq = new Groq('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'); // Pass the API key directly

    try {
        $ingredientsList = implode(', ', $_SESSION['ingredients'] ?? []);
        $query = "Based on these ingredients: $ingredientsList, recommend a recipe.";

        $response = $groq->chat()->completions()->create([
            'model' => 'llama3-8b-8192',
            'temperature' => (float) $temperature,
            'messages' => [
                ['role' => 'user', 'content' => $query]
            ],
        ]);

        $responseContent = $response['choices'][0]['message']['content'] ?? 'No response content found.';
    } catch (\LucianoTonet\GroqPHP\GroqException $e) {
        $errorMessage = 'Error: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Recommendation</title>
</head>
<body>
    <h1>Food Recommendation System</h1>

    <!-- Form to Input Ingredients -->
    <form method="POST">
        <label for="ingredients">Enter ingredients in your fridge (comma-separated):</label><br>
        <input type="text" id="ingredients" name="ingredients" required><br><br>
        <button type="submit">Save Ingredients</button>
    </form>

    <h2>Saved Ingredients:</h2>
    <p><?php echo htmlspecialchars(implode(', ', $_SESSION['ingredients'] ?? [])); ?></p>

    <!-- Form to Get Food Recommendations -->
    <form method="POST">
        <label for="query">Enter your query:</label><br>
        <input type="text" id="query" name="query" value="Recommend a recipe based on my ingredients." required><br><br>

        <label for="temperature">Select Temperature:</label><br>
        <input type="number" id="temperature" name="temperature" step="0.1" min="0" max="1" value="0.7"><br><br>

        <button type="submit">Get Recommendation</button>
    </form>

    <h2>Response:</h2>
    <p><?php echo htmlspecialchars($responseContent); ?></p>

    <?php if ($errorMessage): ?>
        <h3 style="color: red;">Error:</h3>
        <p><?php echo htmlspecialchars($errorMessage); ?></p>
    <?php endif; ?>
</body>
</html>