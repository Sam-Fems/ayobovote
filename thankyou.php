<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Your vote has been successfully recorded - Ayobo Community Online Voting System" />
  <title>Vote Confirmed - Ayobo Community</title>

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
      --primary-dark: #2563eb;
      --success: #198754;
      --light-bg: #f8fafc;
      --gray-600: #475569;
    }

    body {
      font-family: 'Inter', system-ui, -apple-system, sans-serif;
      background: linear-gradient(to bottom, var(--light-bg), #e2e8f0);
      color: #1e293b;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem 1rem;
    }

    .success-container {
      max-width: 540px;
      text-align: center;
    }

    .success-icon {
      font-size: 6.5rem;
      color: var(--success);
      margin-bottom: 1.5rem;
      filter: drop-shadow(0 4px 8px rgba(25, 135, 84, 0.2));
    }

    .btn-primary {
      background-color: var(--primary);
      border-color: var(--primary);
      padding: 0.85rem 2rem;
      font-size: 1.1rem;
      font-weight: 500;
      border-radius: 10px;
      transition: all 0.2s;
    }

    .btn-primary:hover {
      background-color: var(--primary-dark);
      border-color: var(--primary-dark);
      transform: translateY(-1px);
    }

    .btn-outline-secondary {
      padding: 0.85rem 2rem;
      font-size: 1.1rem;
      border-radius: 10px;
    }

    .lead {
      font-size: 1.25rem;
      line-height: 1.6;
    }

    @media (max-width: 576px) {
      .success-icon {
        font-size: 5.5rem;
      }

      .btn {
        width: 100%;
        margin-bottom: 1rem;
      }

      .btn:last-child {
        margin-bottom: 0;
      }
    }
  </style>
</head>

<body>

  <div class="success-container">

    <i class="bi bi-check-circle-fill success-icon"></i>

    <h1 class="display-4 fw-bold text-success mb-3">Thank You!</h1>

    <h4 class="text-dark mb-4 fw-medium">Your vote has been successfully recorded</h4>

    <p class="lead text-muted mb-5">
      Your participation helps shape the future of our Ayobo community.<br>
      Results will be announced after the voting period ends.
    </p>

    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
      <a href="results.php" class="btn btn-primary btn-lg">
        <i class="bi bi-bar-chart me-2"></i>
        View Results
      </a>
      <a href="index.php" class="btn btn-outline-secondary btn-lg">
        <i class="bi bi-door-open me-2"></i>
        Back to Home
      </a>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>