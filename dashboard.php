<?php
session_start();

// Protect this page — only logged-in users
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$username = htmlspecialchars($_SESSION['user']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — LoginApp</title>
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
            --success: #4ade80;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            padding: 2rem;
            background-image: radial-gradient(ellipse at 50% 0%, rgba(124,58,237,0.15) 0%, transparent 60%);
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 800px;
            margin: 0 auto 3rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border);
        }

        .logo {
            font-family: 'Syne', sans-serif;
            font-size: 1.1rem;
            font-weight: 800;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--accent2);
        }

        .logout-btn {
            padding: 0.5rem 1.2rem;
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--muted);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.88rem;
            cursor: pointer;
            text-decoration: none;
            transition: border-color 0.2s, color 0.2s;
        }

        .logout-btn:hover { border-color: var(--accent2); color: var(--accent2); }

        .main {
            max-width: 800px;
            margin: 0 auto;
            animation: slideUp 0.4s ease;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .welcome {
            margin-bottom: 2.5rem;
        }

        .welcome p { color: var(--muted); margin-top: 0.4rem; }

        h1 {
            font-family: 'Syne', sans-serif;
            font-size: 2.2rem;
            font-weight: 800;
        }

        .badge {
            display: inline-block;
            background: rgba(74,222,128,0.12);
            border: 1px solid rgba(74,222,128,0.25);
            color: var(--success);
            font-size: 0.8rem;
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
            margin-bottom: 1rem;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .stat-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.5rem;
        }

        .stat-card .label { font-size: 0.82rem; color: var(--muted); text-transform: uppercase; letter-spacing: 0.06em; }
        .stat-card .value { font-family: 'Syne', sans-serif; font-size: 1.6rem; font-weight: 700; margin-top: 0.5rem; }
        .stat-card .sub   { font-size: 0.82rem; color: var(--muted); margin-top: 0.25rem; }

        .info-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.5rem 2rem;
            margin-top: 1.5rem;
        }

        .info-card h3 { font-family: 'Syne', sans-serif; margin-bottom: 0.8rem; font-size: 1rem; }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.7rem 0;
            border-bottom: 1px solid var(--border);
            font-size: 0.9rem;
        }

        .info-row:last-child { border-bottom: none; }
        .info-row .key { color: var(--muted); }
        .info-row .val { font-weight: 500; }
        .info-row .chip {
            background: rgba(124,58,237,0.15);
            color: var(--accent2);
            padding: 0.2rem 0.7rem;
            border-radius: 999px;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>

<nav>
    <div class="logo">⬡ LoginApp</div>
    <a href="logout.php" class="logout-btn">Logout</a>
</nav>

<div class="main">
    <div class="welcome">
        <div class="badge">✓ Authenticated</div>
        <h1>Hello, <?= $username ?>! 👋</h1>
        <p>Login successful — welcome to your dashboard.</p>
    </div>

    <div class="grid">
        <div class="stat-card">
            <div class="label">Status</div>
            <div class="value" style="color: var(--success);">Active</div>
            <div class="sub">Session running</div>
        </div>
        <div class="stat-card">
            <div class="label">Session ID</div>
            <div class="value" style="font-size:1rem; word-break:break-all;"><?= substr(session_id(), 0, 12) ?>...</div>
            <div class="sub">PHP Session</div>
        </div>
        <div class="stat-card">
            <div class="label">Login Time</div>
            <div class="value" style="font-size:1rem;"><?= date('H:i:s') ?></div>
            <div class="sub"><?= date('d M Y') ?></div>
        </div>
    </div>

    <div class="info-card">
        <h3>Account Info</h3>
        <div class="info-row">
            <span class="key">Username</span>
            <span class="val"><?= $username ?></span>
        </div>
        <div class="info-row">
            <span class="key">Auth Method</span>
            <span class="chip">password_verify()</span>
        </div>
        <div class="info-row">
            <span class="key">Password Storage</span>
            <span class="chip">bcrypt hash</span>
        </div>
        <div class="info-row">
            <span class="key">Session Protection</span>
            <span class="val" style="color: var(--success);">✓ Enabled</span>
        </div>
    </div>
</div>

</body>
</html>
