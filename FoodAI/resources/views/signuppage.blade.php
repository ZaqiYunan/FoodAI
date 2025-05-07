<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@500;700&display=swap" />
    <link rel="stylesheet" href="{{ asset('css/signuppage.css') }}" />
  </head>
  <body>
    <div class="main-container">
      <!-- Display validation errors if any -->
      @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
      
      <!-- Display success message if any -->
      @if (session('success'))
          <div class="alert alert-success">
              {{ session('success') }}
          </div>
      @endif
      
      <form action="{{ route('signup') }}" method="POST">
        @csrf
        <div class="rectangle"></div>
        <span class="sign-up-1">Sign Up</span>
        <span class="sign-in">
          Already have an account? <a href="{{ route('signin') }}">Sign In</a>
        </span>
        <label for="username" class="username">Username</label>
        <input type="text" id="username" name="username" class="rectangle-2" required />
        <label for="email" class="email">Email</label>
        <input type="email" id="email" name="email" class="rectangle-3" required />
        <label for="password" class="password">Password</label>
        <input type="password" id="password" name="password" class="rectangle-4" required />
        <label for="password_confirmation" class="confirm-password">Confirm Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="rectangle-5" required />
        <button type="submit" class="rectangle-6">
          <span class="sign-up-5">Sign Up</span>
        </button>
      </form>
    </div>
  </body>
</html>