<?php
 
$accessToken = 'piMkvlrypWCQ7BW0w1kK+KmvS/U3qezdKmChtQYgYrJKD12unIu2rbqbQzy8ayQnNaw6U2k8jtt22FVejaDu+KddX2CXmXa7QYyIuCXlGkiX01oLh9OfAWTIdka4aqje/3FFomQR0gTImfEFX1KCrAdB04t89/1O/w1cDnyilFU=';

//ユーザーからのメッセージ取得
$json_string = file_get_contents('php://input');
$json_object = json_decode($json_string);
 
//取得データ
$replyToken = $json_object->{"events"}[0]->{"replyToken"};        //返信用トークン
$message_type = $json_object->{"events"}[0]->{"message"}->{"type"};    //メッセージタイプ
$message_text = $json_object->{"events"}[0]->{"message"}->{"text"};    //メッセージ内容
$message_id = $json_object->{"events"}[0]->{"message"}->{"id"};
 
//メッセージタイプが「text」以外のときは何も返さず終了
// if($message_type != "text") exit;

//画像ファイルのバイナリ取得
$ch = curl_init("https://api.line.me/v2/bot/message/".$message_id."/content");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
 'Content-Type: application/json; charser=UTF-8',
 'Authorization: Bearer ' . $accessToken
 ));
$result = curl_exec($ch);
curl_close($ch);

//画像ファイルの作成  
$fp = fopen('./img/test.jpg', 'wb');

if ($fp){
    if (flock($fp, LOCK_EX)){
        if (fwrite($fp,  $result ) === FALSE){
            print('ファイル書き込みに失敗しました<br>');
        }else{
            print($data.'をファイルに書き込みました<br>');
        }

        flock($fp, LOCK_UN);
    }else{
        print('ファイルロックに失敗しました<br>');
    }
}

fclose($fp);

 
//返信メッセージ
// $return_message_text = $message_text;
 
//返信実行
// sending_messages($accessToken, $replyToken, $message_type, $return_message_text);
?>
<?php
//メッセージの送信
function sending_messages($accessToken, $replyToken, $message_type, $return_message_text){
    //レスポンスフォーマット
    $response_format_text = [
        "type" => $message_type,
        "text" => $return_message_text
    ];
 
    //ポストデータ
    $post_data = [
        "replyToken" => $replyToken,
        "messages" => [$response_format_text]
    ];
 
    //curl実行
    $ch = curl_init("https://api.line.me/v2/bot/message/reply");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charser=UTF-8',
        'Authorization: Bearer ' . $accessToken
    ));
    $result = curl_exec($ch);
    curl_close($ch);
}
?>
