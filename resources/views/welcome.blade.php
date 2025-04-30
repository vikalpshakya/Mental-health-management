<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Welcome</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    body {
      background: linear-gradient(135deg, #74ebd5, #acb6e5);
      animation: fadeIn 1s ease-in;
    }

    .welcome-box {
      background-color: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      padding: 50px;
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

    .btn-lg {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-lg:hover {
      transform: scale(1.05);
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }

    .logo {
      width: 120px;
      height: 120px;
      object-fit: contain;
      margin-bottom: 20px;
      animation: fadeIn 2s ease-in-out;
    }
  </style>
</head>
<body>
  <div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="welcome-box text-center">
      <img src="https://i0.wp.com/iimbx.iimb.ac.in/wp-content/uploads/2025/01/7.gif?resize=300%2C300&ssl=1" alt="Logo" class="logo"/>
      <h1 class="display-4 mb-4">Welcome to Digital Hospital</h1>
      <p class="lead mb-4">Please login or register to continue.</p>
      <div class="d-grid gap-2 d-md-flex justify-content-md-center">
        <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4 me-md-2">Login</a>
        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg px-4">Register</a>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
