<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Home</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; }

        :root {
            --bg: #f8eff0;
            --bg2: #f0dfe1;
            --card: rgba(255, 255, 255, 0.86);
            --text: #2b1b1b;
            --muted: #6f4d4d;
            --accent: #7f1d1d;
            --accent-soft: #9f3a3a;
            --border: rgba(127, 29, 29, 0.14);
            --shadow: 0 24px 70px rgba(95, 24, 24, 0.14);
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(127, 29, 29, 0.14), transparent 30%),
                radial-gradient(circle at bottom right, rgba(159, 58, 58, 0.14), transparent 28%),
                linear-gradient(180deg, var(--bg), var(--bg2));
        }

        .page {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 2rem;
        }

        .card {
            width: min(100%, 760px);
            padding: clamp(1.6rem, 4vw, 3rem);
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 28px;
            box-shadow: var(--shadow);
            backdrop-filter: blur(16px);
        }

        .eyebrow {
            display: inline-block;
            margin-bottom: 1rem;
            padding: 0.4rem 0.75rem;
            border-radius: 999px;
            background: rgba(127, 29, 29, 0.1);
            color: var(--accent);
            font-size: 0.76rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.12em;
        }

        h1 {
            margin: 0;
            font-family: 'DM Serif Display', serif;
            font-size: clamp(2.7rem, 5vw, 4.8rem);
            line-height: 0.95;
            letter-spacing: -0.04em;
        }

        p {
            margin: 1rem 0 0;
            color: var(--muted);
            font-size: 1rem;
            line-height: 1.7;
            max-width: 42rem;
        }

        .links {
            margin-top: 1.8rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .nav-links {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            margin-top: 1.8rem;
            padding: 0.55rem 0.75rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.74);
            border: 1px solid rgba(127, 29, 29, 0.08);
        }

        .nav-links a {
            color: var(--text);
            text-decoration: none;
            font-weight: 700;
            font-size: 0.95rem;
        }

        .nav-links a:hover {
            color: var(--accent);
        }

        .nav-links .separator {
            color: rgba(31, 41, 55, 0.35);
        }

        a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.8rem 1.2rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
        }

        .primary {
            background: var(--accent);
            color: #fff;
        }

        .secondary {
            background: rgba(255, 255, 255, 0.92);
            color: var(--text);
            border: 1px solid rgba(127, 29, 29, 0.12);
        }

        .primary:hover,
        .secondary:hover,
        .nav-links a:hover {
            color: #5c1212;
        }
    </style>
</head>
<body>
    <main class="page">
        <section class="card">
            <span class="eyebrow">Student Home</span>
            <h1>Student Portal</h1>
            <p>This is the student home page. Use the profile route to view the full student information page.</p>
            <div class="nav-links" aria-label="Student navigation">
                <a href="<?= site_url('student'); ?>">Home</a>
                <span class="separator">|</span>
                <a href="<?= site_url('student/profile'); ?>">Student Profile</a>
            </div>
            <div class="links">
                <a class="primary" href="<?= site_url('student/profile'); ?>">Open Profile</a>
                <a class="secondary" href="/">Back to Welcome</a>
            </div>
        </section>
    </main>
</body>
</html>