<?php
if (!class_exists('config')) {
    class config {
        private static $pdo = null;

        public static function getConnexion() {
            if (!isset(self::$pdo)) {
                try {
                    self::$pdo = new PDO(
                        'mysql:host=localhost;dbname=hebergement_db',
                        'root',
                        '',
                        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                    );
                } catch (Exception $e) {
                    die('Error: ' . $e->getMessage());
                }
            }
            return self::$pdo;
        }
    }
}
?>









