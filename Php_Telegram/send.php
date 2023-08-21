<?php
function send($method, $data){
    global $BOT_TOKEN;
    $ch = curl_init("https://api.telegram.org/bot" . $BOT_TOKEN . "/$method?" . http_build_query($data) );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);

    $output = curl_exec($ch);

    curl_close($ch);
}