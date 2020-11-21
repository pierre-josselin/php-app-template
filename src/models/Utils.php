<?php
class Utils {
    public static function generateId(int $length = 32) {
        $length = intval($length / 2);
        $bytes = random_bytes($length);
        return bin2hex($bytes);
    }
    
    public static function request(string $url, string $method = "GET", array $headers = null, $data = null) {
        $options = [
            "http" => [
                "method" => $method,
                "ignore_errors" => true
            ]
        ];
        if(!is_null($headers)) {
            $options["http"]["header"] = "";
            foreach($headers as $key => $value) {
                $options["http"]["header"] .= "{$key}: {$value}\r\n";
            }
        }
        if(!is_null($data)) {
            $options["http"]["content"] = $data;
        }
        $context = stream_context_create($options);
        return @file_get_contents($url, false, $context);
    }
}