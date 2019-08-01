<?php
// 送られて来たJSONデータを取得
$json_string = file_get_contents('php://input');
$json = json_decode($json_string);
// JSONデータから返信先を取得
$replyToken = $json->events[0]->replyToken;
// JSONデータから送られてきたメッセージを取得

// HTTPヘッダを設定
$channelToken = 'ScsOQvzkti43X3SBf2XcpZvZAVDM/mHaNHrAOJfr+5eu7Gz8BoxQMljmW0y5NHpazyckMfKUETP53ZccURy7OjMcD7cIJNFhjCx4gM+pFGx3Vip4+j436klae2PR9MlQYD4uHuCsunVINo/cg/sa4QdB04t89/1O/w1cDnyilFU=';
$headers = [
	'Authorization: Bearer ' . $channelToken,
	'Content-Type: application/json; charset=utf-8',
];

// POSTデータを設定してJSONにエンコード
$post = [
	'replyToken' => $replyToken,
	'messages' => [
		[
			'type' => 'text',
			'text' => '「」',
		],
	],
];
$post = json_encode($post);

// HTTPリクエストを設定
$ch = curl_init('https://api.line.me/v2/bot/message/reply');
$options = [
	CURLOPT_CUSTOMREQUEST => 'POST',
	CURLOPT_HTTPHEADER => $headers,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_BINARYTRANSFER => true,
	CURLOPT_HEADER => true,
	CURLOPT_POSTFIELDS => $post,
];

// 実行
curl_setopt_array($ch, $options);
