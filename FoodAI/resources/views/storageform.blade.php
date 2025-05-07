<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add Ingredient</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&display=swap" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@500&display=swap" />
  <link rel="stylesheet" href="{{ asset('css/storageform.css') }}" />
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
    <span class="welcome-to-your-storage">WELCOME TO YOUR STORAGE</span>

    <!-- Ingredient Form -->
    <form action="{{ route('save.ingredients') }}" method="POST" class="ingredient-form">
      @csrf
      <div class="form-row">
        <div class="form-group">
          <label for="ingredient-category" class="form-label">Jenis Bahan:</label>
          <select id="ingredient-category" name="ingredient_category" required>
            <option value="" disabled selected>Pilih</option>
            <option value="Vegetable">Vegetable</option>
            <option value="Fruit">Fruit</option>
            <option value="Meat">Meat</option>
            <option value="Dairy">Dairy</option>
            <option value="Grain">Grain</option>
            <option value="Other">Other</option>
          </select>
        </div>
        <div class="form-group">
          <label for="storage-type" class="form-label">Kulkas/Suhu Ruang:</label>
          <select id="storage-type" name="storage_type" required>
            <option value="" disabled selected>Pilih</option>
            <option value="Kulkas">Kulkas</option>
            <option value="Suhu Ruang">Suhu Ruang</option>
          </select>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="ingredient-name" class="form-label">Nama Bahan:</label>
          <input type="text" id="ingredient-name" name="ingredient_name" placeholder="Masukkan nama bahan" required />
        </div>
        <div class="form-group">
          <label for="ingredient-quantity" class="form-label">Total Item:</label>
          <input type="number" id="ingredient-quantity" name="ingredient_quantity" placeholder="Masukkan jumlah item"
            required />
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="ingredient-production-date" class="form-label">Tanggal Produksi:</label>
          <input type="date" id="ingredient-production-date" name="ingredient_production_date" required />
        </div>
        <div class="form-group">
          <label for="ingredient-expiry" class="form-label">Tanggal Expire:</label>
          <input type="date" id="ingredient-expiry" name="ingredient_expiry" required />
        </div>
      </div>

      <button type="submit" class="btn simpan">Simpan</button>
    </form>
  </div>
</body>

</html>