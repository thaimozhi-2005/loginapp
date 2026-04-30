<?php
session_start();

// Already logged in? Redirect to dashboard
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;
}

require_once 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password.";
    } else {
        $sql    = "SELECT id, username, password FROM users WHERE username='$username' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                // Login success — set session
                $_SESSION['user']    = $user['username'];
                $_SESSION['user_id'] = $user['id'];
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Incorrect password. Try again.";
            }
        } else {
            $error = "Username not found.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — LoginApp</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg: #0a0a0f;
            --card: #111118;
            --border: #1e1e2e;
            --accent: #7c3aed;
            --accent2: #a78bfa;
            --text: #e4e4f0;
            --muted: #6b6b80;
            --error: #f87171;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background-image: radial-gradient(ellipse at 80% 50%, rgba(124,58,237,0.12) 0%, transparent 60%),
                              radial-gradient(ellipse at 20% 20%, rgba(167,139,250,0.07) 0%, transparent 50%);
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            animation: slideUp 0.4s ease;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .logo {
            font-family: 'Syne', sans-serif;
            font-size: 1.1rem;
            font-weight: 800;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--accent2);
            margin-bottom: 2rem;
        }

        h1 { font-family: 'Syne', sans-serif; font-size: 1.8rem; font-weight: 700; margin-bottom: 0.4rem; }
        .subtitle { color: var(--muted); font-size: 0.9rem; margin-bottom: 2rem; }

        .field { margin-bottom: 1.2rem; }

        label {
            display: block;
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 0.5rem;
        }

        input {
            width: 100%;
            padding: 0.85rem 1rem;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            transition: border-color 0.2s;
            outline: none;
        }

        input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(124,58,237,0.15);
        }

        .btn {
            width: 100%;
            padding: 0.9rem;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-family: 'Syne', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            margin-top: 0.5rem;
        }

        .btn:hover { background: #6d28d9; }
        .btn:active { transform: scale(0.98); }

        .msg.error {
            padding: 0.85rem 1rem;
            border-radius: 10px;
            font-size: 0.9rem;
            margin-bottom: 1.2rem;
            background: rgba(248,113,113,0.1);
            border: 1px solid rgba(248,113,113,0.3);
            color: var(--error);
        }

        .footer { text-align: center; margin-top: 1.5rem; font-size: 0.88rem; color: var(--muted); }
        .footer a { color: var(--accent2); text-decoration: none; font-weight: 500; }
        .footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>
<div class="card">
    <div class="logo">⬡ LoginApp</div>
    <h1>Welcome Back</h1>
    <p class="subtitle">Login panni continue pannunga 👋</p>

    <?php if ($error): ?>
        <div class="msg error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="field">
            <label>Username</label>
            <input type="text" name="username" placeholder="yourname" required autofocus
                   value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
        </div>
        <div class="field">
            <label>Password</label>
            <input type="password" name="password" placeholder="Your password" required>
        </div>
        <button type="submit" class="btn">Login →</button>
    </form>

    <div class="footer">
        Account illaya? <a href="register.php">Register here</a>
    </div>
</div>
</body>
</html>
