<?php

//$accessToken = 'Line Developers�Ŕ��s�����A�N�Z�X�g�[�N��';
//$accessToken = 'UqtniJOOLghRO23SvswdFEXQaoYKi/ZPlXn9jZZY3DcILNh0rRDxRV2NZCFduMsCb/XkqNdGxqu1K5y+55jkf1TNL+SfRS5vVCy1Rke8Q5JIO5oboKLx2oVOWZvcrHnxKZOROr9qdAoWk9eGfYqHxQdB04t89/1O/w1cDnyilFU=';
$accessToken = getenv('LINE_CHANNEL_ACCESS_TOKEN');

//���[�U�[����̃��b�Z�[�W�擾
$jsonString = file_get_contents('php://input');
$jsonObj = json_decode($jsonString);

$type = $jsonObj->{"events"}[0]->{"message"}->{"type"};
//���b�Z�[�W�擾
$text = $jsonObj->{"events"}[0]->{"message"}->{"text"};
$replyToken = $jsonObj->{"events"}[0]->{"replyToken"};

$userinfo = $jsonObj->{"events"}[0]->{"user"};

// �����Ă������b�Z�[�W�̒��g���烌�X�|���X�̃^�C�v��I��
if ($text == '�m�F') {
    // �m�F�_�C�A���O�^�C�v
    $messageData = [
        'type' => 'template',
        'altText' => '�m�F�_�C�A���O',
        'template' => [
            'type' => 'buttons',
            'text' => '���C�ł����[�H',
            'actions' => [
                [
                    'type' => 'message',
                    'label' => '���C�ł�',
                    'text' => '���C�ł�'
                ],
                [
                    'type' => 'message',
                    'label' => '�܂��܂��ł�',
                    'text' => '�܂��܂��ł�'
                ],
            ]
        ]
    ];
} elseif ($text == '�J���[�Z��') {
    // �J���[�Z���^�C�v
    $messageData = [
        'type' => 'template',
        'altText' => '�J���[�Z��',
        'template' => [
            'type' => 'carousel',
            'columns' => [
                [
                    'title' => '�J���[�Z��1',
                    'text' => '�J���[�Z��1�ł�',
                    'actions' => [
                        [
                            'type' => 'postback',
                            'label' => 'webhook��post���M',
                            'data' => 'value'
                        ],
                        [
                            'type' => 'uri',
                            'label' => '���e�̌��R�~�L�������',
                            'uri' => 'http://clinic.e-kuchikomi.info/'
                        ]
                    ]
                ],
                [
                    'title' => '�J���[�Z��2',
                    'text' => '�J���[�Z��2�ł�',
                    'actions' => [
                        [
                            'type' => 'postback',
                            'label' => 'webhook��post���M',
                            'data' => 'value'
                        ],
                        [
                            'type' => 'uri',
                            'label' => '�����������',
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
    // ����ȊO�͑����Ă����e�L�X�g���I�E���Ԃ�
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
