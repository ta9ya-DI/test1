<?php
$accessToken = getenv('LINE_CHANNEL_ACCESS_TOKEN');


//ユーザーからのメッセージ取得
$json_string = file_get_contents('php://input');
$jsonObj = json_decode($json_string);

$type = $jsonObj->{"events"}[0]->{"message"}->{"type"};
//メッセージ取得
$text = $jsonObj->{"events"}[0]->{"message"}->{"text"};
//ReplyToken取得
$replyToken = $jsonObj->{"events"}[0]->{"replyToken"};

//メッセージ以外のときは何も返さず終了
if($type != "text"){
	exit;
}

//返信データ作成
if ($text == 'はい') {
  $response_format_text = [
    "type" => "template",
    "altText" => "取り置き予約",
    "template" => [
      "type" => "buttons",
      "title" => "予約完了",
      "text" => "取り置き予約が完了しました",
      "actions" => [
          [
            "type" => "message",
            "label" => "他の商品を探す",
            "text" => "本日の入荷商品を見る"
          ]
      ]
    ]
  ];
} else if ($text == 'いいえ') {
  exit;
  
  
} else if ($text == '本日の入荷商品を見る') {

// DB接続
// $conn = "host=ec2-50-19-83-146.compute-1.amazonaws.com port=5432 dbname=d5u4i943vm9c3c user=yqxzvlhkumweus password=cdca45ddc4c48a77d35a432f3666e013b59279f70c4ff826c4167e9039491d43";
$conn = "hostec2-107-20-224-137.compute-1.amazonaws.com port=5432 dbname=d2jvnrr9579qk8 user=vabegndeuuyzrx password=f186ff76623a593ecbee65a96f4aa41f168d1f7b5fc5a60ff1c7e36ed1aa6641";
$link = pg_connect($conn);
if (!$link) {
    die('接続失敗です。'.pg_last_error());
}

// PostgreSQLに対する処理

$result = pg_query('SELECT item_code, item_name, item_su FROM public."Item";');
if (!$result) {
    die('クエリーが失敗しました。'.pg_last_error());
}

//for ($i = 0 ; $i < pg_num_rows($result) ; $i++){
    $rows = pg_fetch_array($result, NULL, PGSQL_ASSOC);
    $rows1 = pg_fetch_array($result, NULL, PGSQL_ASSOC);
    $rows2 = pg_fetch_array($result, NULL, PGSQL_ASSOC);
    $rows3 = pg_fetch_array($result, NULL, PGSQL_ASSOC);
    $rows4 = pg_fetch_array($result, NULL, PGSQL_ASSOC);
//}

  $response_format_text = [
    "type" => "template",
    "altText" => "本日の商品をご案内しています。",
    "template" => [
      "type" => "carousel",
      "columns" => [
          [
          "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/" . $rows['item_name'] . ".png",
            "title" => $rows['item_name'],
            "text" => "現在" . $rows['item_su'] . "個",
            "actions" => [
              [
                  "type" => "message",
                  "label" => "取り置き予約する",
                  "text" => "取り置き予約する"
              ],
              [
                  "type" => "uri",
                  "label" => "詳しく見る（ブラウザ起動）",
                  "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
              ]
            ]
          ],
          [
          "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/" . $rows1['item_name'] . ".png",
            "title" => $rows1['item_name'],
            "text" => "現在" . $rows1['item_su'] . "個",
            "actions" => [
              [
                  "type" => "message",
                  "label" => "取り置き予約する",
                  "text" => "取り置き予約する"
              ],
              [
                  "type" => "uri",
                  "label" => "詳しく見る（ブラウザ起動）",
                  "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
              ]
            ]
          ],
          [
          "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/" . $rows2['item_name'] . ".png",
            "title" => $rows2['item_name'],
            "text" => "現在" . $rows2['item_su'] . "個",
            "actions" => [
              [
                  "type" => "message",
                  "label" => "取り置き予約する",
                  "text" => "取り置き予約する"
              ],
              [
                  "type" => "uri",
                  "label" => "詳しく見る（ブラウザ起動）",
                  "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
              ]
            ]
          ],
          [
          "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/" . $rows3['item_name'] . ".png",
            "title" => $rows3['item_name'],
            "text" => "現在" . $rows3['item_su'] . "個",
            "actions" => [
              [
                  "type" => "message",
                  "label" => "取り置き予約する",
                  "text" => "取り置き予約する"
              ],
              [
                  "type" => "uri",
                  "label" => "詳しく見る（ブラウザ起動）",
                  "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
              ]
            ]
          ],
          [
          "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/" . $rows4['item_name'] . ".png",
            "title" => $rows4['item_name'],
            "text" => "現在" . $rows4['item_su'] . "個",
            "actions" => [
              [
                  "type" => "message",
                  "label" => "取り置き予約する",
                  "text" => "取り置き予約する"
              ],
              [
                  "type" => "uri",
                  "label" => "詳しく見る（ブラウザ起動）",
                  "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
              ]
            ]
          ]
      ]
    ]
  ];
  $close_flag = pg_close($link);
  
} else if ($text == '生産者情報を見る') {
  $response_format_text = [
    "type" => "template",
    "altText" => "生産者情報をご案内しています。",
    "template" => [
      "type" => "carousel",
      "columns" => [
          [
          "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/農家１.jpg",
            "title" => "農家１さん",
            "text" => "安心に食べていただくため、手間をかけて大事に育てています",
            "actions" => [
              [
                  "type" => "uri",
                  "label" => "詳しく見る（ブラウザ起動）",
                  "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
              ]
            ]
          ],
          [
          "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/農家２.jpg",
            "title" => "農家２さん",
            "text" => "うちのブドウは最高です！",
            "actions" => [
              [
                  "type" => "uri",
                  "label" => "詳しく見る（ブラウザ起動）",
                  "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
              ]
            ]
          ],
          [
          "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/農家３.jpg",
            "title" => "農家３さん",
            "text" => "本当のお米の味を知ってもらいたい",
            "actions" => [
              [
                  "type" => "uri",
                  "label" => "詳しく見る（ブラウザ起動）",
                  "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
              ]
            ]
          ]
      ]
    ]
  ];
  
} else if ($text == 'おすすめレシピを見る') {
  $response_format_text = [
    "type" => "template",
    "altText" => "おすすめレシピをご案内しています。",
    "template" => [
      "type" => "carousel",
      "columns" => [
          [
          "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/hw007.jpg",
            "title" => "ロールキャベツ",
            "text" => "こちらにしますか？",
            "actions" => [
              [
                  "type" => "uri",
                  "label" => "詳しく見る（ブラウザ起動）",
                  "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
              ]
            ]
          ],
          [
          "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/hw010.jpg",
            "title" => "筑前煮",
            "text" => "こちらにしますか？",
            "actions" => [
              [
                  "type" => "uri",
                  "label" => "詳しく見る（ブラウザ起動）",
                  "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
              ]
            ]
          ],
          [
          "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/em004.jpg",
            "title" => "肉じゃが",
            "text" => "こちらにしますか？",
            "actions" => [
              [
                  "type" => "uri",
                  "label" => "詳しく見る（ブラウザ起動）",
                  "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
              ]
            ]
          ]
      ]
    ]
  ];
  
} else if ($text == '取り置き予約する') {
  $response_format_text = [
    "type" => "template",
    "altText" => "○○を取り置き予約しますか？（はい／いいえ）",
    "template" => [
        "type" => "confirm",
        "text" => "○○を取り置き予約しますか？",
        "actions" => [
            [
              "type" => "message",
              "label" => "はい",
              "text" => "はい"
            ],
            [
              "type" => "message",
              "label" => "いいえ",
              "text" => "いいえ"
            ]
        ]
    ]
  ];
} else {
  $response_format_text = [
    "type" => "template",
    "altText" => "こんにちは。何をお探しですか？",
    "template" => [
      "type" => "buttons",
      "text" => "こんにちは。何をお探しですか？",
      "actions" => [
          [
            "type" => "message",
            "label" => "本日の入荷商品を見る",
            "text" => "本日の入荷商品を見る"
          ],
          [
            "type" => "message",
            "label" => "生産者情報を見る",
            "text" => "生産者情報を見る"
          ],
          [
            "type" => "message",
            "label" => "おすすめレシピを見る",
            "text" => "おすすめレシピを見る"
          ]
      ]
    ]
  ];
}

$post_data = [
	"replyToken" => $replyToken,
	"messages" => [$response_format_text]
	];

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
