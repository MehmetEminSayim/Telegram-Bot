<?php 

class TelegramBot {
    const API_URL = "ttps://api.telegram.org/bot";
    public function setToken($token){
        $this->token = $token;
    }

    public function request($method,$data){
        $ch = curl_init();
        $url = self::API_URL . $this->token. '/' .$method;

        curl_setopt($ch, CURLOPT_URL, url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        
        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
    }

}

$telegram = new TelegramBot();
$telegram->setToken("1757394693:AAFpXxU5XfwQqmMd6kiw20d20kqCHdq9BHY");