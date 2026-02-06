<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Ayobo Community Online Voting System - Secure, transparent, and easy voting for local community leadership elections." />
  <title>Ayobo Community | Secure Online Voting</title>

  <!-- Bootstrap 5.3 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --primary: #3b82f6;
      --primary-dark: #2563eb;
      --light-bg: #f8fafc;
      --text-muted: #64748b;
    }

    body {
      font-family:
        "Inter",
        system-ui,
        -apple-system,
        sans-serif;
      background-color: var(--light-bg);
      color: #1e293b;
    }

    .left-panel {
      background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
      position: relative;
      overflow: hidden;
    }

    .left-panel::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: radial-gradient(circle at 30% 70%,
          rgba(255, 255, 255, 0.12) 0%,
          transparent 60%);
      pointer-events: none;
    }

    .brand-icon {
      font-size: 3.5rem;
      opacity: 0.9;
    }

    .card-login-option {
      transition: all 0.25s ease;
      border: 1px solid #e2e8f0;
      border-radius: 16px;
      overflow: hidden;
      background: white;
    }

    .card-login-option:hover {
      transform: translateY(-6px);
      box-shadow: 0 20px 40px -12px rgba(59, 130, 246, 0.18);
      border-color: var(--primary);
    }

    .option-link {
      display: flex;
      align-items: center;
      gap: 1.25rem;
      padding: 1.75rem 2rem;
      color: #1e293b;
      text-decoration: none;
      font-size: 1.15rem;
      font-weight: 500;
      transition: all 0.2s;
    }

    .option-link:hover {
      background-color: #f1f5f9;
      color: var(--primary-dark);
    }

    .option-icon {
      font-size: 2rem;
      color: var(--primary);
      width: 60px;
      height: 60px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: rgba(59, 130, 246, 0.08);
      border-radius: 12px;
    }

    .register-link {
      color: var(--primary);
      font-weight: 500;
      text-decoration: none;
    }

    .register-link:hover {
      text-decoration: underline;
      color: var(--primary-dark);
    }

    @media (max-width: 767px) {
      .left-panel {
        min-height: 40vh;
      }

      .option-link {
        padding: 1.5rem;
      }
    }
  </style>
</head>

<body>

  <div class="container-fluid p-0">
    <div class="row g-0 min-vh-100">

      <!-- Left - Branding Section -->
      <div class="col-lg-5 left-panel text-white d-flex align-items-center justify-content-center">
        <div class="text-center px-4 px-md-5 py-5">
          <i class="bi bi-check2-circle brand-icon mb-4"></i>
          <h1 class="display-5 fw-bold mb-3">Ayobo Community</h1>
          <h2 class="fs-4 fw-light mb-4 opacity-75">Online Voting System</h2>
          <p class="lead fs-5 opacity-85 mb-5">
            Secure • Transparent • Accessible<br>
            Your vote shapes the future of our community.
          </p>

          <div class="d-flex flex-wrap justify-content-center gap-4 mt-4">
            <div class="d-flex align-items-center gap-2">
              <i class="bi bi-shield-check fs-4"></i>
              <span>End-to-end encryption</span>
            </div>
            <div class="d-flex align-items-center gap-2">
              <i class="bi bi-fingerprint fs-4"></i>
              <span>Verified voters only</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Right - Login Options -->
      <div class="col-lg-7 d-flex align-items-center justify-content-center py-5">
        <div class="w-100" style="max-width: 480px; padding: 0 1.5rem;">

          <div class="text-center mb-5">
            <h3 class="fw-semibold mb-2">Welcome Back</h3>
            <p class="text-muted">Please select your access level to continue</p>
          </div>

          <div class="card-login-option mb-4">
            <a href="voter_login.php" class="option-link">
              <div class="option-icon">
                <i class="bi bi-person-fill"></i>
              </div>
              <div>
                <div class="fs-5 fw-semibold">Voter Login</div>
                <small class="text-muted">Cast your vote in community elections</small>
              </div>
            </a>
          </div>

          <div class="card-login-option mb-5">
            <a href="admin/admin_login.php" class="option-link">
              <div class="option-icon">
                <i class="bi bi-shield-lock-fill"></i>
              </div>
              <div>
                <div class="fs-5 fw-semibold">Admin / Election Officer</div>
                <small class="text-muted">Manage elections and monitor results</small>
              </div>
            </a>
          </div>

          <div class="text-center">
            <p class="text-muted mb-1">New to the platform?</p>
            <a href="voter_register.php" class="register-link fs-5">
              Create Voter Account →
            </a>
          </div>

        </div>
      </div>

    </div>
  </div>

  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->

</body>

</html>