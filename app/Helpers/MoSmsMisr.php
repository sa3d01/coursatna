<?php
/**
 * Created by MoWagdy
 * Date: 2019-08-21
 * Time: 11:52 PM
 */

namespace App\Helpers;

use GuzzleHttp\Client;

class MoSmsMisr
{
    private $phoneNumbers = '';

    private $SMSMISR_USERNAME;
    private $SMSMISR_PASSWORD;
    private $SMSMISR_SENDER;

    public function __construct($phoneNumbers) // array
    {
        foreach ($phoneNumbers as $number) {
            $this->phoneNumbers .= $number . ',';
        }
        substr_replace($this->phoneNumbers, "", -1);

        $this->configurations();
    }

    private function configurations()
    {
        $this->SMSMISR_USERNAME = 'xWyczcDu';
        $this->SMSMISR_PASSWORD = 'PgXWG6oEjO';
        $this->SMSMISR_SENDER = 'pracon';
    }

    public function send($message)
    {
        $client = $this->buildHttpClient();
        $response = $client->request('POST', 'webapi', [
            'query' => [
                'username' => $this->SMSMISR_USERNAME,
                'password' => $this->SMSMISR_PASSWORD,
                'sender' => $this->SMSMISR_SENDER,
                'language' => 1,
                'message' => $message,
                'mobile' => $this->phoneNumbers,
                'DelayUntil' => null,
            ]
        ]);
        $array = json_decode($response->getBody(), true);
        return $array;
    }

    protected function buildHttpClient()
    {
        $endpoint = 'https://smsmisr.com/api/';
        return new Client([
            'base_uri' => $endpoint,
        ]);
    }
}
