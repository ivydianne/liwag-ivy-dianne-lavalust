<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentMiddleware
{
    public function handle(Closure $next)
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['student_access']) || $_SESSION['student_access'] !== true) {
            $baseUrl = rtrim(BASE_URL, '/');
            $redirectTo = $baseUrl !== '' ? $baseUrl . '/student' : '/student';

            header('Content-Type: text/html; charset=utf-8');
            $safeUrl = htmlspecialchars($redirectTo, ENT_QUOTES, 'UTF-8');
            echo '<!doctype html><html><head><meta charset="utf-8">';
            echo '<meta http-equiv="refresh" content="2;url=' . $safeUrl . '">';
            echo '<title>Redirecting</title></head><body style="font-family:Arial,Helvetica,sans-serif;line-height:1.4;">';
            echo '<h1>Access Denied. Redirect!</h1>';
            echo '<p>You will be redirected shortly. If not, <a href="' . $safeUrl . '">click here</a>.</p>';
            echo '</body></html>';
            exit;
        }

        return $next();
    }
}