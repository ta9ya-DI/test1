<?php

//$accessToken = 'Line Developersで発行したアクセストークン';
//$accessToken = 'UqtniJOOLghRO23SvswdFEXQaoYKi/ZPlXn9jZZY3DcILNh0rRDxRV2NZCFduMsCb/XkqNdGxqu1K5y+55jkf1TNL+SfRS5vVCy1Rke8Q5JIO5oboKLx2oVOWZvcrHnxKZOROr9qdAoWk9eGfYqHxQdB04t89/1O/w1cDnyilFU=';
$accessToken = getenv('LINE_CHANNEL_ACCESS_TOKEN');

//ユーザーからのメッセージ取得
$jsonString = file_get_contents('php://input');
$jsonObj = json_decode($jsonString);

$type = $jsonObj->{"events"}[0]->{"message"}->{"type"};
//メッセージ取得
$text = $jsonObj->{"events"}[0]->{"message"}->{"text"};
$replyToken = $jsonObj->{"events"}[0]->{"replyToken"};

$userinfo = $jsonObj->{"events"}[0]->{"user"};

// 送られてきたメッセージの中身からレスポンスのタイプを選択
if ($text == '確認') {
    // 確認ダイアログタイプ
    $messageData = [
        'type' => 'template',
        'altText' => '確認ダイアログ',
        'template' => [
            'type' => 'buttons',
            'text' => '元気ですかー？',
            'actions' => [
                [
                    'type' => 'message',
                    'label' => '元気です',
                    'text' => '元気です'
                ],
                [
                    'type' => 'message',
                    'label' => 'まあまあです',
                    'text' => 'まあまあです'
                ],
            ]
        ]
    ];
} elseif ($text == 'カルーセル') {
    // カルーセルタイプ
    $messageData = [
        'type' => 'template',
        'altText' => 'カルーセル',
        'template' => [
            'type' => 'carousel',
            'columns' => [
                [
                    'title' => 'カルーセル1',
                    'text' => 'カルーセル1です',
                    'actions' => [
                        [
                            'type' => 'postback',
                            'label' => 'webhookにpost送信',
                            'data' => 'value'
                        ],
                        [
                            'type' => 'uri',
                            'label' => '美容の口コミ広場を見る',
                            'uri' => 'http://clinic.e-kuchikomi.info/'
                        ]
                    ]
                ],
                [
                    'title' => 'カルーセル2',
                    'text' => 'カルーセル2です',
                    'actions' => [
                        [
                            'type' => 'postback',
                            'label' => 'webhookにpost送信',
                            'data' => 'value'
                        ],
                        [
                            'type' => 'uri',
                            'label' => '女美会を見る',
                            'uri' => 'https://jobikai.com/'
                        ]
                    ]
                ],
            ]
        ]
    ];
} elseif ($text == 'google') {
	$messageData = [
		'type'=>'uri',
		'linkUri'=>'https://google.com',
		'area'=>[
			'x'=>0,
			'y'=>0,
			'wigth'=>520,
			'height'=>1040
		]
	];
} elseif ($text == 'img1') {
	$messageData = [
		'type' => 'image',
		'originalContentUrl' => 'https://github.com/ta9ya-DI/test1/tree/master/image/coupon.jpg',
		'previewImageUrl' => 'https://github.com/ta9ya-DI/test1/tree/master/image/coupon.jpg'
	];
}elseif ($text == 'abu') {
	$messageData = [
		'type'=>'text',
		'text'=>'ABU'
	];
} else {
    // それ以外は送られてきたテキストをオウム返し
    $messageData = [
        'type' => 'text',
        'text' => $message->{"text"}
    ];
}

$response = [
    'replyToken' => $replyToken,
    'messages' => [$messageData]
];

$ch = curl_init('https://api.line.me/v2/bot/message/reply');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json; charser=UTF-8',
    'Authorization: Bearer ' . $accessToken
));
$result = curl_exec($ch);
error_log($result);
curl_close($ch);
