<?php

namespace MoemenPhpDev\BitlyShortner;

class Bitly
{
//    private const token = '188e3a1191b56925d2088011321a10e005707645';

    public function __construct($long_link)
    {
        $this->token = '188e3a1191b56925d2088011321a10e005707645';
    }

    public static function shorten($long_link = '')
    {
        if(empty($long_link))
        {
            throw new \Exception("Please provide long link");

        }

        if(is_null($token = getBitlyToken())){
            throw new \Exception('please Provide token in bitlyconfig.php config file');
        }

        $curl = curl_init();

        $requestBody = json_encode([
            "domain"=> "bit.ly",
            "long_url"=> $long_link
        ]);

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api-ssl.bitly.com/v4/shorten',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$requestBody,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);

        return $response->link ?? '';
    }
}
