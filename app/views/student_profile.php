<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Cormorant+Garamond:wght@600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; }

        :root {
            --bg: #f8eff0;
            --bg-2: #efd8db;
            --card: rgba(255, 255, 255, 0.84);
            --text: #2b1b1b;
            --muted: #6f4d4d;
            --accent: #7f1d1d;
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
                linear-gradient(180deg, var(--bg), var(--bg-2));
        }

        .page {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 2rem;
        }

        .card {
            width: min(100%, 760px);
            padding: clamp(1.5rem, 4vw, 3rem);
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 28px;
            box-shadow: var(--shadow);
            backdrop-filter: blur(16px);
        }

        .eyebrow {
            display: inline-block;
            margin-bottom: 0.9rem;
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
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2.6rem, 5vw, 4.5rem);
            line-height: 0.95;
            letter-spacing: -0.04em;
        }

        .intro {
            margin: 1rem 0 2rem;
            max-width: 42rem;
            color: var(--muted);
            line-height: 1.7;
        }

        .nav-links {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
            padding: 0.55rem 0.75rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.76);
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

        .details {
            display: grid;
            gap: 1rem;
        }

        .detail {
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 1rem;
            padding: 1rem 1.1rem;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.74);
            border: 1px solid rgba(127, 29, 29, 0.08);
        }

        .label {
            margin: 0;
            color: var(--accent);
            font-size: 0.85rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .value {
            margin: 0;
            font-size: 1.06rem;
            font-weight: 600;
            color: #2b1b1b;
        }

        @media (max-width: 640px) {
            .detail {
                grid-template-columns: 1fr;
                gap: 0.35rem;
            }
        }
    </style>
</head>
<body>
    <main class="page">
        <section class="card" aria-labelledby="student-information-title">
            <span class="eyebrow">Student Profile</span>
            <div class="nav-links" aria-label="Student navigation">
                <a href="<?= site_url('student'); ?>">Home</a>
                <span class="separator">|</span>
                <a href="<?= site_url('student/profile'); ?>">Student Profile</a>
            </div>
            <h1 id="student-information-title">Student Information</h1>
            <p class="intro">The values below are passed from the controller as an associative array and rendered in the view.</p>

            <div class="details">
                <div class="detail">
                    <p class="label">Student ID</p>
                    <p class="value"><?= htmlspecialchars($student_id ?? '') ?></p>
                </div>
                <div class="detail">
                    <p class="label">Student Name</p>
                    <p class="value"><?= htmlspecialchars($name ?? '') ?></p>
                </div>
                <div class="detail">
                    <p class="label">Course</p>
                    <p class="value"><?= htmlspecialchars($course ?? '') ?></p>
                </div>
                <div class="detail">
                    <p class="label">Year Level</p>
                    <p class="value"><?= htmlspecialchars($year ?? '') ?></p>
                </div>
                <div class="detail">
                    <p class="label">Section</p>
                    <p class="value"><?= htmlspecialchars($section ?? '') ?></p>
                </div>
                <div class="detail">
                    <p class="label">Email</p>
                    <p class="value"><?= htmlspecialchars($email ?? '') ?></p>
                </div>
            </div>
        </section>
    </main>
</body>
</html>