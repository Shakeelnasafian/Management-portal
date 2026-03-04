<?php

namespace App\Libraries;

use Twilio\Rest\Client;

class Twilio
{
    protected string $sid;
    protected string $token;
    protected string $from;

    public function __construct()
    {
        $this->sid = (string) env('TWILIO_SID');
        $this->token = (string) env('TWILIO_TOKEN');
        $this->from = (string) env('TWILIO_FROM');
    }

    public function send_message(string $to, string $body): void
    {
        $client = new Client($this->sid, $this->token);
        $client->messages->create($to, ['from' => $this->from, 'body' => $body]);
    }
}
