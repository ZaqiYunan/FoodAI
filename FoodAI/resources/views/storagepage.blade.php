<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Your Storage</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&display=swap" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@500&display=swap" />
  <link rel="stylesheet" href="{{ asset('css/storagepage.css') }}" />
</head>

<body>
  <div class="main-container">
    <!-- Navigation Bar -->
    <div class="rectangle">
      <div class="rectangle-1"><span class="logo">logo</span></div>
      <div class="nav-links">
        <span class="home">Home</span>
        <span class="recipes">Recipes</span>
        <span class="services">Services</span>
        <span class="contact-us">Contact us</span>
        <span class="storage">Storage</span>
        @if (auth()->check())
      <!-- Show profile and username for logged-in users -->
      <span class="user">Welcome, {{ auth()->user()->Nama_Pengguna }}</span>
      <form action="{{ route('logout') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit" class="logout-button">Logout</button>
      </form>
    @else
      <!-- Show login button for guests -->
      <a href="{{ route('signin') }}" class="login-button">Login</a>
    @endif
      </div>
    </div>

    <!-- Welcome Header -->
    <span class="welcome-to-storage">WELCOME TO YOUR STORAGE</span>

    <!-- Ingredients Grid -->
    <div class="ingredients-container">
      <!-- Add Ingredient Button -->
      <div class="ingredient-item add-item">
        <a href="/storageform" class="ingredient-link">
          <div class="ingredient-image add-icon">+</div>
          <span class="ingredient-name">Tambah Bahan</span>
        </a>
      </div>

      <!-- Display Ingredients Dynamically -->
      @if (!empty($ingredients) && count($ingredients) > 0)
      @foreach ($ingredients as $ingredient)
      <div class="ingredient-item">
      <div class="ingredient-image">
      <!-- Placeholder for ingredient image -->
      <img src="{{ asset('images/' . strtolower($ingredient) . '.png') }}" alt="{{ $ingredient }}" />
      </div>
      <span class="ingredient-name">{{ $ingredient }}</span>
      </div>
    @endforeach
    @else
      <p>No ingredients saved yet. Add some ingredients to your storage!</p>
    @endif
    </div>
  </div>
</body>

</html>