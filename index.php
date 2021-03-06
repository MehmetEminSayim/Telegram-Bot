<?php
class TelegramBot {
    const API_URL = "https://api.telegram.org/bot";
    public $token;
    public $chatId;

    public function setToken($token){
        $this->token = $token;
    }

    public function setWebhook($url){
        return $this->request('setWebhook',[
            'url' => $url
        ]);
    }

    public function sendMessage($message){
        return $this->request('sendMessage',[
            'chat_id' =>$this->chatId,
            'text' =>$message
        ]);

    }

    public function kickUser($chatId,$userId){
        return $this->request('kickChatMember',[
            'chat_id' =>$chatId,
            'user_id' =>$userId,
        ]);
    }

    public function getData (){
        $data = json_decode(file_get_contents('php://input'));
        $this->chatId = $data->message->chat->id;
        return $data->message;
    }

    public function request($method,$data){
        $ch = curl_init();
        $url = self::API_URL . $this->token. '/' .$method;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return $result;
    }

}

$telegram = new TelegramBot();
$telegram->setToken("{token değeriniz}");
/*echo $telegram->setWebhook('{webhook adresini:calıstıgınız url}');*/

$data = $telegram->getData();

if ($data->text == "merhaba"){
    $telegram->sendMessage('merhaba bize katıldığın için teşekkür ederiz');
}


