<?php
session_start();
require_once "classes/Admin.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Admin login  Ayobo Community Online Voting System" />
    <title>Admin Login - Ayobo Community</title>

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

        .admin-header {
            background: var(--danger);
            color: white;
            padding: 2.25rem 1.75rem 1.5rem;
            text-align: center;
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
            border-color: var(--danger);
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.18);
        }

        .btn-admin-login {
            padding: 0.85rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 10px;
            background-color: var(--danger);
            border: none;
            transition: all 0.2s;
        }

        .btn-admin-login:hover {
            background-color: #c82333;
            transform: translateY(-1px);
        }

        .back-link {
            color: var(--gray-500);
            font-weight: 500;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: var(--danger);
            text-decoration: none;
        }

        @media (max-width: 576px) {
            .card-body {
                padding: 1.75rem;
            }

            .admin-header {
                padding: 1.75rem 1.25rem 1.25rem;
            }
        }
    </style>
</head>

<body>

    <div class="login-container">

        <!-- Back link -->
        <a href="../index.php" class="d-inline-flex align-items-center mb-4 back-link text-decoration-none">
            <i class="bi bi-chevron-left me-2"></i>
            Back to Home
        </a>

        <div class="card shadow">

            <div class="admin-header">
                <i class="bi bi-shield-lock-fill" style="font-size: 3.5rem; opacity: 0.95;"></i>
                <h3 class="mt-3 mb-2 fw-semibold">Admin Login</h3>
                <p class="mb-0 opacity-90">Authorized Personnel Only</p>
            </div>

            <div class="card-body p-4 p-md-5">

                <?php require_once "common/alert.php"; ?>

                <form action="process/process_admin_login.php" method="post">

                    <div class="mb-4">
                        <label class="form-label">Username</label>
                        <input
                            type="text"
                            name="username"
                            class="form-control"
                            placeholder="Enter admin username"
                            autocomplete="username"
                            autofocus>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Enter admin password"
                            autocomplete="current-password">
                    </div>

                    <button
                        type="submit"
                        name="btn"
                        class="btn btn-danger btn-lg w-100 btn-admin-login mt-3">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Login as Admin
                    </button>

                </form>

            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>