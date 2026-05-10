<?php

namespace App\Services;

use Twilio\Rest\Client;

class WhatsAppService
{
    private $client;

    public function __construct()
    {
        $this->client = new Client(
            env('TWILIO_SID'),
            env('TWILIO_TOKEN')
        );
    }

    public function sendTemplate($to, $contentSid, $variables = [])
{
    return $this->client->messages->create(
        "whatsapp:$to",
        [
            "from" => env('TWILIO_WHATSAPP_FROM'),
            "contentSid" => $contentSid,
            "contentVariables" => json_encode($variables, JSON_UNESCAPED_UNICODE),
        ]
    );
}
}