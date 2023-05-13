<?php

namespace App\Helpers;


class CURL
{
    public static function sendCurl(array $options)
    {
        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $result = curl_exec($curl);
        if (curl_errno($curl)) {
            return \json_encode($curl);
        }
        curl_close($curl);
        return json_decode($result, \true);
    }
}
