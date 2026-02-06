<?php
session_start();
require_once 'classes/Voter.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Login to vote securely in the Ayobo Community Online Voting System." />
  <title>Voter Login - Ayobo Community</title>

  <!-- Bootstrap 5.3 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

  <!-- Google Fonts: Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --primary: #3b82f6;
      /* blue from your index page */
      --primary-dark: #2563eb;
      --light-bg: #f8fafc;
      --gray-700: #495057;
      --gray-500: #6c757d;
    }

    body {
      font-family: 'Inter', system-ui, -apple-system, sans-serif;
      background: linear-gradient(to bottom, var(--light-bg), #e9ecef);
      color: #212529;
      min-height: 100vh;
      padding: 2rem 1rem;
    }

    .login-container {
      max-width: 460px;
      margin: 0 auto;
    }

    .card {
      border: none;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
      background: white;
    }

    .form-label {
      font-weight: 500;
      color: var(--gray-700);
      margin-bottom: 0.5rem;
    }

    .form-control,
    .form-control:focus {
      border-radius: 10px;
      padding: 0.75rem 1rem;
      border: 1px solid #ced4da;
      font-size: 1.05rem;
    }

    .form-control:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.18);
    }

    .btn-login {
      padding: 0.85rem;
      font-size: 1.1rem;
      font-weight: 600;
      border-radius: 10px;
      background-color: var(--primary);
      border: none;
      transition: all 0.2s;
    }

    .btn-login:hover {
      background-color: var(--primary-dark);
      transform: translateY(-1px);
    }

    .back-link {
      color: var(--gray-500);
      font-weight: 500;
      transition: color 0.2s;
    }

    .back-link:hover {
      color: var(--primary);
      text-decoration: none;
    }

    .forgot-link {
      color: var(--primary);
      font-weight: 500;
      text-decoration: none;
    }

    .forgot-link:hover {
      text-decoration: underline;
    }

    @media (max-width: 576px) {
      .card-body {
        padding: 1.75rem;
      }
    }
  </style>
</head>

<body>

  <div class="login-container">

    <!-- Back link -->
    <a href="index.php" class="d-inline-flex align-items-center mb-4 back-link text-decoration-none">
      <i class="bi bi-chevron-left me-2"></i>
      Back to Home
    </a>

    <div class="card shadow">

      <div class="card-body p-4 p-md-5">

        <div class="text-center mb-5">
          <i class="bi bi-person-circle" style="font-size: 3.5rem; color: var(--primary); opacity: 0.9;"></i>
          <h3 class="mt-3 mb-2 fw-semibold">Voter Login</h3>
          <p class="text-muted mb-0">Sign in to cast your vote securely</p>
        </div>

        <?php require_once "common/alert.php"; ?>

        <form action="process/process_voter_login.php" method="post">

          <div class="mb-4">
            <label class="form-label">Voter ID</label>
            <input
              type="text"
              name="voter_id"
              class="form-control"
              placeholder="Enter your Voter ID"
              autocomplete="username"
              autofocus>
          </div>

          <div class="mb-4">
            <label class="form-label">Password</label>
            <input
              type="password"
              name="password"
              class="form-control"
              placeholder="Enter your password"
              autocomplete="current-password">
          </div>

          <!-- <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="remember" name="remember">
              <label class="form-check-label text-muted" for="remember">
                Remember me
              </label>
            </div>
             Optional: Add later when you implement password recovery 
            <a href="#" class="forgot-link small">Forgot password?</a> 
          </div> -->

          <button
            type="submit"
            name="btn"
            class="btn btn-primary btn-lg w-100 btn-login">
            <i class="bi bi-box-arrow-in-right me-2"></i>
            Login to Vote
          </button>

        </form>

      </div>
    </div>

    <div class="text-center mt-4">
      <p class="text-muted mb-1">Don't have an account yet?</p>
      <a href="voter_register.php" class="text-primary fw-medium text-decoration-none">
        Register as a voter ->
      </a>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>