<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Load the SendGrid library
require_once APPPATH.'third_party/sendgrid/sendgrid-php.php';

if (!function_exists('send_email')) {
    function send_email($to, $subject, $message, $from_email = 'noreply@ivas.homes', $from_name = 'IVAS') {
        $apiKey = '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';
        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom($from_email, $from_name);
        $email->setSubject($subject);
        $email->addTo($to);
        $email->addContent("text/plain", $message);
        $email->addContent("text/html", $message);

        $sendgrid = new \SendGrid($apiKey);
        try {
            $response = $sendgrid->send($email);
            return $response->statusCode();
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
            return false;
        }
    }
}
