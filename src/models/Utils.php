<?php
class Utils {
    public static function generateId(int $length = 32) {
        $length = intval($length / 2);
        $bytes = random_bytes($length);
        return bin2hex($bytes);
    }
}