<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Live voting results – Ayobo Community Online Voting System" />
  <title>Live Voting Results – Ayobo Community</title>

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
      --gray-400: #94a3b8;
    }

    body {
      font-family: 'Inter', system-ui, -apple-system, sans-serif;
      background: var(--light-bg);
      color: #1e293b;
      min-height: 100vh;
    }

    .navbar {
      background: linear-gradient(to right, var(--primary), var(--primary-dark)) !important;
      padding: 1.25rem 0;
    }

    .result-card {
      border: none;
      border-radius: 14px;
      overflow: hidden;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
      transition: transform 0.2s ease;
    }

    .result-card:hover {
      transform: translateY(-4px);
    }

    .winner-indicator {
      background: rgba(25, 135, 84, 0.1);
      border-left: 5px solid var(--success);
    }

    .progress {
      height: 14px;
      border-radius: 10px;
      background-color: #e2e8f0;
    }

    .progress-bar {
      border-radius: 10px;
      transition: width 1s ease;
      font-weight: 600;
      display: flex;
      align-items: center;
      justify-content: center;
      min-width: 60px;
    }

    .progress-label {
      font-size: 1.1rem;
      font-weight: 700;
      min-width: 80px;
      text-align: right;
    }

    .party-badge {
      font-size: 0.85rem;
      padding: 0.35em 0.9em;
    }

    @media (max-width: 576px) {
      .progress-label {
        font-size: 1rem;
        min-width: 70px;
      }
    }
  </style>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-dark shadow">
    <div class="container">
      <span class="navbar-brand fw-semibold fs-4">Ayobo Voting System</span>
      <a href="voter_dashboard.php" class="btn btn-outline-light d-flex align-items-center">
        <i class="bi bi-arrow-left me-2"></i>
        Back to Dashboard
      </a>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="container py-5">

    <div class="text-center mb-5">
      <i class="bi bi-bar-chart-line-fill text-primary" style="font-size: 3.8rem; opacity: 0.9;"></i>
      <h2 class="fw-bold mt-3 mb-2">Live Voting Results</h2>
      <p class="text-muted mb-1">Chairman Position</p>
      <p class="text-muted small">
        Total Votes Cast: <strong>1,250</strong> • Last updated: Just now
      </p>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-8 col-xl-7">

        <!-- Candidate 1 – Winner example -->
        <div class="card result-card winner-indicator mb-4">
          <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-3">
              <div>
                <h5 class="fw-semibold mb-1">John Adewale</h5>
                <span class="badge bg-success-subtle text-success party-badge">Progressive Party</span>
              </div>
              <div class="progress-label text-success">
                55% <small class="text-muted">(688 votes)</small>
              </div>
            </div>
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">
                55%
              </div>
            </div>
            <div class="text-center mt-2">
              <small class="badge bg-success text-white">Leading Candidate</small>
            </div>
          </div>
        </div>

        <!-- Candidate 2 -->
        <div class="card result-card mb-4">
          <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-3">
              <div>
                <h5 class="fw-semibold mb-1">Samuel Okoro</h5>
                <span class="badge bg-primary-subtle text-primary party-badge">Unity Party</span>
              </div>
              <div class="progress-label text-primary">
                45% <small class="text-muted">(562 votes)</small>
              </div>
            </div>
            <div class="progress">
              <div class="progress-bar bg-primary" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">
                45%
              </div>
            </div>
          </div>
        </div>

        <!-- You can add more candidates here -->

      </div>
    </div>

    <div class="text-center mt-5 pt-4">
      <p class="text-muted small">
        Results are updated in real-time as votes are cast.<br>
        Voting is still open — encourage others to participate!
      </p>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>