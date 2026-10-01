<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->library('api');
        $this->call->database();
    }

    public function login()
    {
        $input = $this->api->body();
        $username = trim($input['username'] ?? '');
        $password = $input['password'] ?? '';

        if ($username === '' || $password === '') {
            $this->api->respond_error('Username and password are required.', 422);
        }

        $identifier = strtolower($username);
        $attempt = $this->db->raw(
            'SELECT failed_attempts, locked_until,
                    IF(locked_until IS NOT NULL AND locked_until > NOW(), 1, 0) AS is_locked,
                    GREATEST(1, TIMESTAMPDIFF(SECOND, NOW(), locked_until)) AS lock_seconds
             FROM login_attempts WHERE identifier = ? LIMIT 1',
            [$identifier]
        )->fetch(PDO::FETCH_ASSOC);

        if ($attempt && (int) $attempt['is_locked'] === 1) {
            $this->api->respond_error(
                'Login temporarily locked. Try again in ' . (int) $attempt['lock_seconds'] . ' seconds.',
                429
            );
        }

        if ($attempt && $attempt['locked_until']) {
            $this->db->raw('DELETE FROM login_attempts WHERE identifier = ?', [$identifier]);
        }

        $statement = $this->db->raw(
            'SELECT id, username, email, password, role, is_active, failed_attempts, locked_until,
                    IF(locked_until IS NOT NULL AND locked_until > NOW(), 1, 0) AS is_locked,
                    GREATEST(1, TIMESTAMPDIFF(SECOND, NOW(), locked_until)) AS lock_seconds
             FROM users WHERE username = ? LIMIT 1',
            [$username]
        );
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user && (int) $user['is_locked'] === 1) {
            $remaining = (int) $user['lock_seconds'];
            $this->api->respond_error("Account temporarily locked. Try again in {$remaining} seconds.", 429);
        }

        if ($user && $user['locked_until'] && (int) $user['is_locked'] === 0) {
            $this->db->raw(
                'UPDATE users SET failed_attempts = 0, locked_until = NULL WHERE id = ?',
                [$user['id']]
            );
            $user['failed_attempts'] = 0;
            $user['locked_until'] = null;
        }

        if (!$user || !$user['is_active'] || !password_verify($password, $user['password'])) {
            $failed_attempts = (int) ($attempt['failed_attempts'] ?? 0) + 1;
            if ($failed_attempts >= 5) {
                $this->db->raw(
                    'INSERT INTO login_attempts (identifier, failed_attempts, locked_until)
                     VALUES (?, 0, DATE_ADD(NOW(), INTERVAL 1 MINUTE))
                     ON DUPLICATE KEY UPDATE failed_attempts = 0, locked_until = DATE_ADD(NOW(), INTERVAL 1 MINUTE)',
                    [$identifier]
                );
                if ($user) {
                    $this->db->raw(
                        'UPDATE users SET failed_attempts = 0, locked_until = DATE_ADD(NOW(), INTERVAL 1 MINUTE) WHERE id = ?',
                        [$user['id']]
                    );
                }
                $this->api->respond_error('Login temporarily locked after 5 failed attempts. Try again in 60 seconds.', 429);
            }
            $this->db->raw(
                'INSERT INTO login_attempts (identifier, failed_attempts, locked_until)
                 VALUES (?, ?, NULL)
                 ON DUPLICATE KEY UPDATE failed_attempts = VALUES(failed_attempts), locked_until = NULL',
                [$identifier, $failed_attempts]
            );
            $this->api->respond_error('Invalid username or password.', 401);
        }

        $this->db->raw('DELETE FROM login_attempts WHERE identifier = ?', [$identifier]);
        $this->db->raw(
            'UPDATE users SET failed_attempts = 0, locked_until = NULL WHERE id = ?',
            [$user['id']]
        );
        unset($user['password']);
        unset($user['failed_attempts'], $user['locked_until'], $user['is_locked'], $user['lock_seconds']);
        $this->api->respond([
            'user' => $user,
            'tokens' => $this->api->issue_tokens($user),
        ]);
    }

    public function register()
    {
        $input = $this->api->body();
        $username = trim($input['username'] ?? '');
        $email = trim($input['email'] ?? '');
        $password = $input['password'] ?? '';

        if (!preg_match('/^[A-Za-z0-9_]{3,100}$/', $username)) {
            $this->api->respond_error('Username must be 3 to 100 characters using letters, numbers, or underscores.', 422);
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->api->respond_error('A valid email address is required.', 422);
        }
        if (strlen($password) < 8) {
            $this->api->respond_error('Password must be at least 8 characters.', 422);
        }

        $existing = $this->db->raw(
            'SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1',
            [$username, $email]
        )->fetch(PDO::FETCH_ASSOC);
        if ($existing) {
            $this->api->respond_error('Username or email is already registered.', 409);
        }

        $this->db->raw(
            'INSERT INTO users (username, email, password, role, is_active) VALUES (?, ?, ?, ?, ?)',
            [$username, $email, password_hash($password, PASSWORD_DEFAULT), 'user', 1]
        );

        $this->api->respond(['message' => 'Account created successfully. You can now log in.'], 201);
    }
}