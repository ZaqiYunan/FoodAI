<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Ingredient</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@500&display=swap" />
    <link rel="stylesheet" href="{{ asset('css/storageformpage.css') }}" />
  </head>
  <body>
    <div class="main-container">
      <div class="rectangle">
        <div class="rectangle-1"><span class="logo">logo</span></div>
        <div class="nav-links">
          <span class="home">Home</span>
          <span class="recipes">Recipes</span>
          <span class="services">Services</span>
          <span class="contact-us">Contact us</span>
          <span class="storage">Storage</span>
          <span class="user">User</span>
        </div>
      </div>

      <span class="welcome-to-your-storage">Add a New Ingredient</span>

      <!-- Ingredient Form -->
      <form action="/save-ingredient" method="POST" class="ingredient-form">
        @csrf
        <label for="ingredient-name">Ingredient Name:</label>
        <input type="text" id="ingredient-name" name="ingredient_name" required />

        <label for="ingredient-category">Category:</label>
        <select id="ingredient-category" name="ingredient_category" required>
          <option value="Vegetable">Vegetable</option>
          <option value="Fruit">Fruit</option>
          <option value="Meat">Meat</option>
          <option value="Dairy">Dairy</option>
          <option value="Grain">Grain</option>
          <option value="Other">Other</option>
        </select>

        <label for="ingredient-quantity">Quantity:</label>
        <input type="number" id="ingredient-quantity" name="ingredient_quantity" required />

        <label for="ingredient-unit">Unit:</label>
        <select id="ingredient-unit" name="ingredient_unit" required>
          <option value="kg">kg</option>
          <option value="g">g</option>
          <option value="l">l</option>
          <option value="ml">ml</option>
          <option value="pcs">pcs</option>
        </select>

        <label for="ingredient-expiry">Expiration Date:</label>
        <input type="date" id="ingredient-expiry" name="ingredient_expiry" required />

        <button type="submit" class="btn">Save Ingredient</button>
      </form>
    </div>
  </body>
</html>