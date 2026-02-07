<?php
session_start();
require_once 'classes/Voter.php';
require_once 'classes/Candidate.php';

$candidate = new Candidate();
$voter = new Voter();

if (!isset($_SESSION['voter_logged_in'])) {
  header("location: voter_login.php");
  exit;
}

$candidates = $candidate->show_candidates();
if (!$candidates['success']) {
  die('Unable to load candidates');
}

$candidates = $candidates['candidates'];
$status = $voter->getElectionStatus();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Cast your vote in the Ayobo Community election securely and transparently." />
  <title>Cast Your Vote - Ayobo Community</title>

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
      background: linear-gradient(to right, #3b82f6, #2563eb) !important;
      padding: 1.25rem 0;
    }

    .card-candidate {
      transition: all 0.25s ease;
      border: 2px solid transparent;
      border-radius: 16px;
      overflow: hidden;
      cursor: pointer;
      background: white;
      box-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
    }

    .card-candidate:hover {
      transform: translateY(-6px);
      box-shadow: 0 16px 40px rgba(59, 130, 246, 0.15);
    }

    .card-candidate.selected {
      border-color: var(--primary);
      box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.12);
    }

    .candidate-avatar {
      width: 100px;
      height: 100px;
      background: #e2e8f0;
      border-radius: 50%;
      margin: 0 auto 1.25rem;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 3.5rem;
      color: #64748b;
    }

    .party-badge {
      font-size: 0.85rem;
      padding: 0.4em 1em;
    }

    .selection-indicator {
      opacity: 0;
      transform: scale(0.8);
      transition: all 0.25s ease;
    }

    .card-candidate.selected .selection-indicator {
      opacity: 1;
      transform: scale(1);
    }

    .btn-submit {
      padding: 0.9rem 2.5rem;
      font-size: 1.15rem;
      font-weight: 600;
      border-radius: 12px;
      transition: all 0.2s;
    }

    .btn-submit:disabled {
      opacity: 0.6;
      cursor: not-allowed;
    }

    @media (max-width: 576px) {
      .candidate-avatar {
        width: 90px;
        height: 90px;
        font-size: 3rem;
      }
    }
  </style>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-dark shadow">
    <div class="container">
      <span class="navbar-brand fw-semibold fs-4">Ayobo Voting System</span>
      <form action="process/process_logout.php" method="post">
        <button type="submit" class="btn btn-outline-light btn-sm d-flex align-items-center">
          <i class="bi bi-box-arrow-right me-2"></i>
          Logout
        </button>
      </form>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="container py-5">

    <div class="alert <?= $status['is_active'] ? 'alert-success' : 'alert-danger' ?> mb-4 shadow-sm">
      <div class="d-flex align-items-center">
        <i class="bi <?= $status['is_active'] ? 'bi-play-circle-fill' : 'bi-stop-circle-fill' ?> fs-4 me-3"></i>
        <div>
          <strong>Election Status:</strong> <?= htmlspecialchars($status['message']) ?>
          <?php if (!$status['is_active'] && $status['ended_at']): ?>
            <br>
            <small>Ended on <?= date('M d, Y \a\t h:i A', strtotime($status['ended_at'])) ?></small>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <?php require_once("common/alert.php") ?>

    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
      <div>
        <h2 class="fw-bold mb-1">Cast Your Vote</h2>
        <p class="text-muted mb-1">Choose your preferred candidate for Chairman</p>
        <p class="mb-0">Welcome back, <strong><?= $_SESSION['voter_name']; ?></strong></p>
      </div>
      <a href="results.php" class="btn btn-outline-primary d-flex align-items-center">
        <i class="bi bi-bar-chart me-2"></i>
        View Live Results
      </a>
    </div>

    <!-- Candidates -->
    <form action="process/process_vote.php" method="post" id="voteForm">
      <div class="row g-4 mb-5">


        <?php foreach ($candidates as $index => $candidate): ?>
          <div class="col-md-6 col-lg-4">
            <div class="card-candidate h-100 text-center <?= $index === 0 ? 'selected' : '' ?>">
              <div class="card-body p-4">

                <div class="candidate-avatar">🧑‍💼</div>

                <h5 class="fw-semibold mb-1">
                  <?= htmlspecialchars($candidate['name']) ?>
                </h5>

                <p class="text-muted mb-2 small">
                  <?= htmlspecialchars($candidate['position']) ?>
                </p>

                <span class="badge bg-primary-subtle text-primary party-badge">
                  <?= htmlspecialchars($candidate['party']) ?>
                </span>

                <div class="mt-4 selection-indicator">
                  <i class="bi bi-check-circle-fill text-primary fs-3"></i>
                  <p class="fw-medium text-primary mt-2 mb-0">Your Selection</p>
                </div>

                <input
                  type="radio"
                  name="candidate_id"
                  value="<?= $candidate['id'] ?>"
                  class="d-none"
                  <?= $index === 0 ? 'checked' : '' ?>>

              </div>
            </div>
          </div>
        <?php endforeach; ?>

      </div>


      <!-- Submit area -->
      <div class="text-center">
        <p class="text-muted mb-4 small">
          You can change your choice before submitting.<br>
          Once submitted, your vote cannot be changed.
        </p>

        <button
          type="submit"
          name="btn"
          id="submitVoteBtn"
          class="btn btn-primary btn-lg px-5 py-3 btn-submit"
          disabled>
          <i class="bi bi-check2-square me-2"></i>
          Submit My Vote
        </button>
      </div>
    </form>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const cards = document.querySelectorAll('.card-candidate');
      const submitBtn = document.getElementById('submitVoteBtn');

      cards.forEach(card => {
        card.addEventListener('click', () => {
          // Remove selection
          cards.forEach(c => {
            c.classList.remove('selected');
            const r = c.querySelector('input[type="radio"]');
            if (r) r.checked = false;
          });

          // Add selection
          card.classList.add('selected');
          const radio = card.querySelector('input[type="radio"]');
          if (radio) radio.checked = true;

          submitBtn.disabled = false;
        });
      });

      // If one is already checked (page load)
      if (document.querySelector('input[name="candidate_id"]:checked')) {
        submitBtn.disabled = false;
      }
    });
  </script>


</body>

</html>