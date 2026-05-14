<?php
class Session {
    public static function start() {
        if(session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }
    
    public static function get($key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }
    
    public static function has($key) {
        return isset($_SESSION[$key]);
    }
    
    public static function remove($key) {
        unset($_SESSION[$key]);
    }
    
    public static function destroy() {
        $_SESSION = [];
        session_destroy();
    }
    
    public static function setFlash($key, $message) {
        $_SESSION['_flash'][$key] = $message;
    }
    
    public static function getFlash($key, $default = null) {
        $msg = $_SESSION['_flash'][$key] ?? $default;
        unset($_SESSION['_flash'][$key]);
        return $msg;
    }
    
    public static function user() {
        return self::get('user');
    }
    
    public static function isLoggedIn() {
        return self::has('user');
    }
    
    public static function role() {
        $user = self::get('user');
        return $user ? $user['role'] : null;
    }
}

// Start session otomatis
Session::start();