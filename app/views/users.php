<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: linear-gradient(135deg, #f7f1f3 0%, #f0e4e7 100%);
            color: #2d0d17;
        }

        .container {
            max-width: 1100px;
            margin: 60px auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(92, 16, 34, 0.15);
            padding: 30px;
            border: 1px solid #e8d6dc;
        }

        h2 {
            margin: 0 0 20px;
            color: #5c1022;
            font-size: 2rem;
            letter-spacing: 0.5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            overflow: hidden;
            border-radius: 12px;
        }

        th, td {
            border: 1px solid #e8d6dc;
            padding: 12px 14px;
            text-align: left;
        }

        th {
            background: linear-gradient(135deg, #5c1022, #7d1e38);
            color: #fff;
            font-weight: 600;
        }

        tr:nth-child(even) td {
            background: #faf3f5;
        }

        tr:hover td {
            background: #f4e7eb;
        }

        .empty {
            text-align: center;
            color: #5c1022;
            font-weight: bold;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Users</h2>
        <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Username</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id'] ?? '') ?></td>
                        <td><?= htmlspecialchars($user['firstname'] ?? '') ?></td>
                        <td><?= htmlspecialchars($user['lastname'] ?? '') ?></td>
                        <td><?= htmlspecialchars($user['email'] ?? '') ?></td>
                        <td><?= htmlspecialchars($user['username'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="empty">No users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
</body>
</html>
