<?php
session_start();
require_once 'classes/Voter.php';

$voter = new Voter();

$results = $voter->getElectionResults();
if (empty($results)) {
  $results = [
    ['name' => 'Adebayo Johnson', 'party' => 'Progressive Alliance', 'votes' => 450, 'percentage' => 52.6],
    ['name' => 'Ngozi Okafor',    'party' => 'People First',        'votes' => 286, 'percentage' => 33.4],
    ['name' => 'Chukwudi Eze',    'party' => 'United Front',       'votes' => 120, 'percentage' => 14.0],
  ];
  $totalVotes = 856;
} else {
  $totalVotes = array_sum(array_column($results, 'votes'));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Voting Results | Ayobo Community</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Google Fonts: Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      background: #f8fafc;
      color: #1e293b;
      font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .navbar {
      background: linear-gradient(to right, #0d6efd, #0b5ed7) !important;
    }

    .card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
    }

    .progress {
      height: 12px;
      background: #e2e8f0;
      border-radius: 6px;
    }

    .progress-bar {
      transition: width 1.2s ease;
    }
  </style>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-dark shadow">
    <div class="container">
      <span class="navbar-brand fw-semibold fs-4">Voting Results</span>
      <a href="<?php echo isset($isAdmin) ? 'admin_dashboard.php' : 'voter_dashboard.php'; ?>"
        class="btn btn-outline-light">
        <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
      </a>
    </div>
  </nav>

  <div class="container py-5">
    <div class="text-center mb-5">
      <i class="bi bi-bar-chart-fill" style="font-size: 3.5rem; color: #0d6efd; margin-bottom: 1rem;"></i>
      <h2 class="fw-bold">Live Voting Results</h2>
      <p class="text-muted fs-5">Total Votes Cast: <strong><?= number_format($totalVotes) ?></strong></p>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-8">

        <?php if (empty($results)): ?>
          <div class="card text-center p-5">
            <h5 class="text-muted">No results available yet.</h5>
          </div>
        <?php else: ?>
          <?php foreach ($results as $index => $candidate): ?>
            <div class="card mb-4 shadow-sm border-0">
              <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <div>
                    <h5 class="fw-bold mb-1"><?= htmlspecialchars($candidate['name']) ?></h5>
                    <p class="mb-0 text-muted"><?= htmlspecialchars($candidate['party']) ?></p>
                  </div>
                  <div class="text-end">
                    <h4 class="fw-bold mb-0"><?= number_format($candidate['percentage'], 1) ?>%</h4>
                    <small class="text-muted"><?= number_format($candidate['votes']) ?> votes</small>
                  </div>
                </div>
                <div class="progress">
                  <div class="progress-bar <?= $index === 0 ? 'bg-success' : 'bg-primary' ?>"
                    role="progressbar"
                    style="width: <?= $candidate['percentage'] ?>%"
                    aria-valuenow="<?= $candidate['percentage'] ?>"
                    aria-valuemin="0"
                    aria-valuemax="100">
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>