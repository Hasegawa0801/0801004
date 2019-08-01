<?php

define('DEBUG', './debug.txt');

// 送られて来たJSONデータを取得
$json_string = file_get_contents('php://input');
$json = json_decode($json_string);
// JSONデータから返信先を取得
$replyToken = $json->events[0]->replyToken;
// JSONデータから送られてきたメッセージを取得
$message = $json->events[0]->message->text;

file_put_contents(DEBUG, $replyToken.$message);
