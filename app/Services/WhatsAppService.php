<?php

namespace App\Services;

use Twilio\Rest\Client;

class WhatsAppService
{
    private $client;

    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
    }

    public function sendTemplate($to, $contentSid, $variables = [])
{
    return $this->client->messages->create(
        "whatsapp:$to",
        [
            "from" => config('services.twilio.from'),
            "contentSid" => $contentSid,
            "contentVariables" => json_encode($variables, JSON_UNESCAPED_UNICODE),
        ]
    );
}
}