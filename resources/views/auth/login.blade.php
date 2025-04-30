<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    body {
      background: linear-gradient(135deg, #74ebd5, #acb6e5);
      animation: fadeIn 1s ease-in;
    }

    .login-box {
      background-color: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      padding: 40px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      animation: slideDown 1.2s ease-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to   { opacity: 1; }
    }

    @keyframes slideDown {
      from {
        transform: translateY(-50px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .btn-primary {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-primary:hover {
      transform: scale(1.05);
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }

    .logo {
      width: 100px;
      height: 100px;
      object-fit: contain;
      margin-bottom: 20px;
      animation: fadeIn 1.5s ease-in-out;
    }

    .card-header {
      font-size: 1.5rem;
      font-weight: bold;
      text-align: center;
      background: transparent;
      border-bottom: none;
    }
  </style>
</head>
<body>
  <div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="login-box col-md-6">
      <div class="text-center">
        <img src="https://i0.wp.com/iimbx.iimb.ac.in/wp-content/uploads/2025/01/7.gif?resize=300%2C300&ssl=1" alt="Logo" class="logo" />
      </div>
      <div class="card-header">Login</div>
      <div class="card-body">
        <form method="POST" action="{{ route('login') }}">
          @csrf
          <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
            @error('password')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label" for="remember">Remember Me</label>
          </div>
          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
