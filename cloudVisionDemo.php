<?php
# 

// APIキー
$api_key = "AIzaSyBH1al8YcGfWHdrVSHGzwxXuIUekMZzPdM" ;

// 画像へのパス
$image_path = 'http://k.yimg.jp/images/top/sp2/cmn/logo-ns-131205.png';

// Feature Type
$feature = LOGO_DETECTION;

// パラメータ設定
$param = array("requests" => array());
$item["image"] = array("content" => base64_encode(file_get_contents($image_path)));
$item["features"] = array(array("type" => $feature, "maxResults" => 3));
$param["requests"][] = $item;

// リクエスト用のJSONを作成
$json = json_encode($param);

// リクエストを実行
$curl = curl_init() ;
curl_setopt($curl, CURLOPT_URL, "https://vision.googleapis.com/v1/images:annotate?key=" . $api_key);
curl_setopt($curl, CURLOPT_HEADER, true);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_TIMEOUT, 15);
curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
$res1 = curl_exec($curl);
$res2 = curl_getinfo($curl);
curl_close($curl);

// 取得したデータ
$json = substr($res1, $res2["header_size"]);
$array = json_decode($json, true);

// 出力
var_dump($array);
