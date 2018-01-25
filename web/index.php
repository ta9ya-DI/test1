<!DOCTYPE html>
<html>
<head>
<title>こちらはLINE Messaging APIのデモサイトです。</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
こちらはLINE Messaging APIのデモサイトです。
<?php

$conn = "host=ec2-50-19-83-146.compute-1.amazonaws.com port=5432 dbname=d5u4i943vm9c3c user=yqxzvlhkumweus password=cdca45ddc4c48a77d35a432f3666e013b59279f70c4ff826c4167e9039491d43";
$link = pg_connect($conn);
if (!$link) {
    die('接続失敗です。'.pg_last_error());
}

print('接続に成功しました。<br>');

// PostgreSQLに対する処理

$result = pg_query('SELECT item_code, item_name, item_su FROM public."Item";');
if (!$result) {
    die('クエリーが失敗しました。'.pg_last_error());
}

for ($i = 0 ; $i < pg_num_rows($result) ; $i++){
    $rows = pg_fetch_array($result, NULL, PGSQL_ASSOC);
    print($rows['item_name'].' ');
    print($rows['item_su'].'<br>');
}

$close_flag = pg_close($link);

if ($close_flag){
    print('切断に成功しました。<br>');
}

?>
</body>
</html>