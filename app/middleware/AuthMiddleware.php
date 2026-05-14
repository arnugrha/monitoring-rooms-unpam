<?php
class AuthMiddleware {
    public static function handle() {
        if (!Session::isLoggedIn()) {
            header('Location: ' . BASEURL . 'auth');
            exit;
        }
    }
}

class RoleMiddleware {
    public static function handle($role) {
        AuthMiddleware::handle();
        if (Session::user()['role'] !== $role) {
            // Tidak punya akses
            die('403 Forbidden - Anda tidak memiliki akses');
        }
    }
}