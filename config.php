<?php
if (!class_exists('config')) {
    class config {
        private static $pdo = null;
        private static $eventPdo = null;

        public static function getConnexion() {
            if (!isset(self::$pdo)) {
                try {
                    self::$pdo = new PDO(
                        'mysql:host=localhost;dbname=hebergement_db',
                        'root',
                        '',
                        [
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                        ]
                    );
                } catch (PDOException $e) {
                    error_log("Database Connection Error: " . $e->getMessage());
                    throw new Exception("Database connection failed. Please try again later.");
                }
            }
            return self::$pdo;
        }

        public static function getEventConnexion() {
            if (!isset(self::$eventPdo)) {
                try {
                    self::$eventPdo = new PDO(
                        'mysql:host=localhost;dbname=event',
                        'root',
                        '',
                        [
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                        ]
                    );
                } catch (PDOException $e) {
                    error_log("Event Database Connection Error: " . $e->getMessage());
                    throw new Exception("Event database connection failed. Please try again later.");
                }
            }
            return self::$eventPdo;
        }

        // Helper method to check if user is logged in
        public static function isLoggedIn() {
            return isset($_SESSION['user_id']);
        }

        // Helper method to get current user ID
        public static function getCurrentUserId() {
            return $_SESSION['user_id'] ?? null;
        }

        // Helper method to get base URL
        public static function getBaseUrl() {
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
            $host = $_SERVER['HTTP_HOST'];
            return $protocol . $host . '/accomodation';
        }
    }
}
?>









