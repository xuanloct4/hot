<?php

require "./PushKit.php";

$pushKit = new PushKit();
//notice: use pushKit token not device token
$pushKit->VoIP('abe51a6666666666666969ff7a2f56f', [
    'title' => 'This is title',
    'text' => 'This is text',
]);