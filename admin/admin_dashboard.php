<?php
session_start();
require_once 'classes/Admin.php';
require_once "admin_guard.php";

$admin = new Admin;
$isAdmin = isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']);

$voter_count = $admin->getAllVoters();
$votes_count = $admin->fetch_votes();
$candidates_count = $admin->getAllCandidates();
$status = $admin->getElectionStatus();

// echo "<pre>";
// print_r($status);
// echo "</pre>";



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Admin Dashboar2d - Ayobo Community Online Voting System" />
    <title>Admin Dashboard - Ayobo Community</title>

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
            --danger: #dc3545;
            --success: #198754;
            --warning: #ffc107;
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
            background: linear-gradient(to right, var(--danger), #c82333) !important;
            padding: 1.25rem 0;
        }

        .stat-card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.07);
            transition: transform 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
        }

        .icon-box {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
        }

        .bg-primary-soft {
            background: rgba(59, 130, 246, 0.12);
            color: var(--primary);
        }

        .bg-success-soft {
            background: rgba(25, 135, 84, 0.12);
            color: var(--success);
        }

        .bg-warning-soft {
            background: rgba(255, 193, 7, 0.15);
            color: var(--warning);
        }

        .action-btn {
            font-weight: 500;
            padding: 0.9rem;
            border-radius: 10px;
            transition: all 0.2s;
        }

        .action-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        }

        .activity-item {
            padding: 0.75rem 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        @media (max-width: 767px) {
            .stat-card .card-body {
                padding: 1.25rem;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark shadow">
        <div class="container">
            <span class="navbar-brand fw-semibold fs-4">Admin Dashboard</span>
            <form action="process/process_admin_logout.php" method="post">
                <button type="submit" class="btn btn-outline-light d-flex align-items-center">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="container py-5">

        <div class="alert <?= $status['is_active'] ? 'alert-success' : 'alert-danger' ?> mb-4 shadow-sm">
            <div class="d-flex align-items-center">
                <i class="bi <?= $status['is_active'] ? 'bi-play-circle-fill' : 'bi-stop-circle-fill' ?> fs-4 me-3"></i>
                <div>
                    <strong>Current Status:</strong>
                    <?= htmlspecialchars($status['message']) ?>
                    <?php if (!$status['is_active'] && $status['ended_at']): ?>
                        <br>
                        <small class="d-block mt-1">
                            Ended: <?= date('M d, Y \a\t h:i A', strtotime($status['ended_at'])) ?>
                        </small>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php require_once 'common/alert.php' ?>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
            <h2 class="fw-bold mb-0">Dashboard Overview</h2>
            <small class="text-muted">Last updated: just now</small>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card stat-card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-box bg-primary-soft me-3">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small">Total Registered Voters</h6>
                            <h3 class="fw-bold mb-0"><?php echo count($voter_count) ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-box bg-success-soft me-3">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small">Votes Cast</h6>
                            <h3 class="fw-bold mb-0"><?php echo count($votes_count['data']) ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-box bg-warning-soft me-3">
                            <i class="bi bi-person-badge-fill"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small">Active Candidates</h6>
                            <h3 class="fw-bold mb-0"><?php echo count($candidates_count) ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Quick Actions -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 fw-semibold">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-3">

                            <!-- Dropdown for Add Candidate + Register Voter -->
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle action-btn w-100 text-start"
                                    type="button"
                                    id="adminActionsDropdown"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="bi bi-gear me-2"></i> Admin Actions
                                </button>
                                <ul class="dropdown-menu w-100" aria-labelledby="adminActionsDropdown">
                                    <li>
                                        <a class="dropdown-item" href="admin_add_candidate.php">
                                            <i class="bi bi-person-plus me-2 text-primary"></i> Add New Candidate
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="admin_register_voter.php">
                                            <i class="bi bi-person-check me-2 text-success"></i> Register New Voter
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="admin_manage_voters.php">
                                            <i class="bi bi-people me-2 text-info"></i> Manage Voters
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="admin_manage_candidates.php">
                                            <i class="bi bi-person-lines-fill me-2 text-warning"></i> Manage Candidates
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <a href="admin_manage_results.php" class="btn btn-warning text-dark action-btn">
                                <i class="bi bi-bar-chart me-2"></i> View Live Results
                            </a>
                            <?php if (!$status['is_active']): ?>
                                <button class="btn btn-danger action-btn w-100" disabled>
                                    <i class="bi bi-stop-circle me-2"></i>Voting Already Ended
                                </button>
                            <?php else: ?>
                                <button type="button" class="btn btn-danger action-btn w-100"
                                    data-bs-toggle="modal" data-bs-target="#endVotingModal">
                                    <i class="bi bi-stop-circle me-2"></i>End Voting Session
                                </button>
                            <?php endif; ?>
                            <?php if (!$status['is_active']): ?>
                                <button type="button" class="btn btn-success action-btn w-100 mt-3"
                                    data-bs-toggle="modal" data-bs-target="#startVotingModal">
                                    <i class="bi bi-play-circle-fill me-2"></i>Start New Voting Session
                                </button>
                            <?php else: ?>
                                <button class="btn btn-success action-btn w-100 mt-3" disabled>
                                    <i class="bi bi-play-circle-fill me-2"></i>Voting is Already Open
                                </button>
                            <?php endif; ?>

                            <div class="modal fade" id="endVotingModal" tabindex="-1" aria-labelledby="endVotingModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="endVotingModalLabel">End Voting Session?</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="fw-bold text-danger">This action cannot be undone!</p>
                                            <p>Once voting is ended:</p>
                                            <ul>
                                                <li>No more votes can be cast</li>
                                                <li>Results become final</li>
                                                <li>Voters will see a message that voting has closed</li>
                                            </ul>
                                            <p class="mt-3">Are you absolutely sure?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <form action="process/process_end_voting.php" method="POST" style="display: inline;">
                                                <button type="submit" name="end_voting" class="btn btn-danger">
                                                    Yes, End Voting Now
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="startVotingModal" tabindex="-1" aria-labelledby="startVotingModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-success text-white">
                                            <h5 class="modal-title" id="startVotingModalLabel">Start New Voting Session?</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>This will:</p>
                                            <ul>
                                                <li>Re-open voting for all voters</li>
                                                <li>Allow new votes to be cast</li>
                                                <li>Reset the "ended" timestamp</li>
                                            </ul>
                                            <p class="mt-3 fw-bold">Are you sure you want to start a new session?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <form action="process/process_start_voting.php" method="POST" style="display: inline;">
                                                <button type="submit" name="start_voting" class="btn btn-success">
                                                    Yes, Start Voting
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 fw-semibold">Recent Activity</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="activity-item">
                                <small class="text-muted">2 minutes ago</small>
                                <p class="mb-1">New vote cast by Voter #1023</p>
                            </li>
                            <li class="activity-item">
                                <small class="text-muted">15 minutes ago</small>
                                <p class="mb-1">New voter registered: Tunde Bakare</p>
                            </li>
                            <li class="activity-item">
                                <small class="text-muted">1 hour ago</small>
                                <p class="mb-1">Voting session successfully started</p>
                            </li>
                            <!-- You can add more dynamically later -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>