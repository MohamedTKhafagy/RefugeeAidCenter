<?php

require 'vendor/autoload.php'; // Autoload for dependencies, including HTTP_Request2
use Dotenv\Dotenv;


class SMSFacade {
    private $baseUrl;
    private $apiKey;
    private $from;

    public function __construct() {
        // Load environment variables
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        $this->baseUrl = $_ENV['INFOBIP_BASE_URL']; // Your Infobip base URL
        $this->apiKey = $_ENV['INFOBIP_API_KEY'];   // Your Infobip API key
        $this->from = $_ENV['INFOBIP_SENDER'];      // Your sender ID or number
    }

    public function sendSMS($recipient, $message) {
        $request = new HTTP_Request2();
        $request->setUrl($this->baseUrl . '/sms/2/text/advanced');
        $request->setMethod(HTTP_Request2::METHOD_POST);
        $request->setConfig(['follow_redirects' => true]);

        // Set headers
        $request->setHeader([
            'Authorization' => "App {$this->apiKey}",
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ]);

        // Set request body
        $request->setBody(json_encode([
            'messages' => [
                [
                    'destinations' => [['to' => $recipient]],
                    'from' => $this->from,
                    'text' => $message,
                ],
            ],
        ]));

        // Send request and handle response
        try {
            $response = $request->send();
            if ($response->getStatus() == 200) {
                echo "SMS sent successfully to {$recipient}.\n";
                return json_decode($response->getBody(), true);
            } else {
                echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
                    $response->getReasonPhrase() . "\n";
                return null;
            }
        } catch (HTTP_Request2_Exception $e) {
            echo 'Error: ' . $e->getMessage() . "\n";
            return null;
        }
    }
}
