<?php
class Response {
    public static function send($status, $body) {
        http_response_code($status);
        echo json_encode($body);
        exit;
    }
}
?>

