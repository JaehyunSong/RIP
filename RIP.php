<?php
// ==================================================
// RIP: Generating "Random ImagePath" in the current folder
// Author: Jaehyun Song (Kansai University)
// Contact: song@kansai-u.ac.jp | https://www.jaysong.net
// ==================================================

$N   = $_GET["N"];   // 抽出する画像の枚数
$Ext = $_GET["Ext"]; // 拡張子

// スクリプトが保存されているURLの取得 (http/https対応)
$CurrentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]".dirname($_SERVER[REQUEST_URI]);

if (mb_substr($CurrentURL, -1) == "/") {
	$CurrentURL = mb_substr($CurrentURL, 0, -1);
}

$dir = './'; // このスクリプトのあるフォルダー
$files = scandir($dir, 0); // 上記のフォルダーからファイルリスト取得

$filearray   = array(); // 空の配列作成
$returnarray = array(); // 結果の配列

$i = 0; // 配列アドレス用のインデックス

// 指定した拡張子 ($Ext)が含まれているファイルのみ配列の保存
foreach ($files as $file) {
  if (strpos($file, $Ext) !== FALSE) {
        $filearray[$i] = $file;
        $i++;
    }
}

shuffle($filearray); // 配列をまぜまぜ

// 最初のN個だけ取得し、結果配列へ保存
for ($j = 1; $j <= $N; $j++) { 
  $returnarray["Path{$j}"] = "{$CurrentURL}/{$filearray[$j-1]}";
}

// json形式にし、結果を返す
print  json_encode($returnarray);
?>
