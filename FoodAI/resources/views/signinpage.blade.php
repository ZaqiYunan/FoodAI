<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign In</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@500;700&display=swap" />
    <link rel="stylesheet" href="{{ asset('css/signinpage.css') }}" />
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
      
      <form action="{{ route('signin') }}" method="POST">
        @csrf
        <div class="rectangle"></div>
        <span class="sign-in-1">Sign In</span>
        <span class="sign-up">
          Don't have an account? <a href="{{ route('signup') }}">Sign Up</a>
        </span>
        <label for="username" class="username">Username</label>
        <input type="text" id="username" name="username" class="rectangle-2" value="{{ old('username') }}" required />
        <label for="password" class="password">Password</label>
        <input type="password" id="password" name="password" class="rectangle-3" required />
        <button type="submit" class="rectangle-4">
          <span class="sign-in-5">Sign In</span>
        </button>
        <span class="or-sign-in-with">Or sign in with</span>
        <div class="line"></div>
        <div class="line-6"></div>
        <div class="rectangle-7">
          <div class="social-icons"><div class="vector"></div></div>
          <span class="continue-with-google">Continue With Google</span>
        </div>
      </form>
    </div>
  </body>
</html>