<?php
class Utils {
    public static function generateId(int $length = 32) {
        $length = intval($length / 2);
        $bytes = random_bytes($length);
        return bin2hex($bytes);
    }
    
    public static function request(string $url, string $method = "GET", array $headers = null, $data = null, int $timeout = 5) {
        $options = [
            "http" => [
                "method" => $method,
                "ignore_errors" => true,
                "timeout" => $timeout
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
    
    public static function checkDateFormat($date, string $format = "Y-m-d") {
        $dateTime = DateTime::createFromFormat($format, $date);
        return $dateTime && $dateTime->format($format) === $date;
    }
    
    public static function objectToArray($object) {
        if(is_object($object) || is_array($object)) {
            $array = (array) $object;
            foreach($array as &$item) {
                $item = Utils::objectToArray($item);
            }
            return $array;
        } else {
            return $object;
        }
    }
    
    public static function truncateText($text, int $length, string $suffix = "") {
        if(!$text) {
            return "";
        }
        if(mb_strlen($text) > $length) {
            return mb_substr($text, 0, $length) . $suffix;
        } else {
            return $text;
        }
    }
    
    public static function decodeJSON($json) {
        $array = @json_decode($json, true);
        if(json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }
        return $array;
    }
    
    public static function getIp() {
        $ip = $_SERVER["REMOTE_ADDR"];
        if(!filter_var($ip, FILTER_VALIDATE_IP)) {
            return false;
        }
        return $ip;
    }
    
    public static function getIpLocation($ip) {
        if(!filter_var($ip, FILTER_VALIDATE_IP)) return false;
        $url = "https://ipinfo.io/{$ip}/json?token=" . Configuration::IP_INFO_TOKEN;
        $response = Utils::request($url, "GET");
        if(!$response) return false;
        $data = Utils::decodeJSON($response);
        if(!$data) return false;
        return [
            "hostname" => (isset($data["hostname"]) ? $data["hostname"] : false),
            "city" => (isset($data["city"]) ? $data["city"] : false),
            "postalCode" => (isset($data["postal"]) ? $data["postal"] : false),
            "region" => (isset($data["region"]) ? $data["region"] : false),
            "country" => (isset($data["country"]) ? $data["country"] : false),
            "location" => (isset($data["loc"]) ? array_map("floatval", explode(",", $data["loc"])) : false)
        ];
    }
}