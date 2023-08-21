<?php

require_once("send.php");

$BOT_TOKEN = '6526409569:AAFu2wyjRQ8dbr2__oloGUAbISGY_IXhoIE';

$update = file_get_contents('php://input');
$update = json_decode($update, true);

// get params
$userChatId = $update['message']['from']['id'];
$ChatId = $update['message']['chat']['id'];
$username = $update['message']['from']['first_name'];
$text = $update['message']['text'];

// params to send
$parameters = array(
    "chat_id",
    "text",
    "parse_mode" => 'html'
);

if (isset($userChatId) && isset($ChatId) && isset($username) && isset($text)) {
    if (intval($ChatId) < 0) {
        $parameters['chat_id'] = $ChatId;
        if ($text === '/start') {
            $parameters['text'] = "O, i'm in a group!" . ' Hello,' . $username . '!';
        }
        else{
            $parameters['text'] = "Unknown command: <b>$text</b>";
        }
    }
    if (intval($ChatId) > 0) {
        $parameters['chat_id'] = $ChatId;
        if ($text === '/start') {
            $parameters['text'] = 'Hello,' . $username . '!';
        }
        else{
            $parameters['text'] = "Unknown command: <b>$text</b>";
        }
    }

    // Send the message using the send() function
    send("sendMessage", $parameters);

    // Set up data to be sent to the other server if text === require command
    if ($text === '/start'){
        $data = array(
            'username' => $username,
            'user_chat_id' => $userChatId
        );
        // URL of the other server
        $otherServerUrl = 'http://localhost/sql_for_telegram/sql.php';

        // Create context for HTTP request
        $ch = curl_init($otherServerUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_exec($ch);
        curl_close($ch);
    }
}
?>






