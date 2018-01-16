<?php

//$accessToken = 'Line Developers�Ŕ��s�����A�N�Z�X�g�[�N��';
$accessToken = 'UqtniJOOLghRO23SvswdFEXQaoYKi/ZPlXn9jZZY3DcILNh0rRDxRV2NZCFduMsCb/XkqNdGxqu1K5y+55jkf1TNL+SfRS5vVCy1Rke8Q5JIO5oboKLx2oVOWZvcrHnxKZOROr9qdAoWk9eGfYqHxQdB04t89/1O/w1cDnyilFU=';

$jsonString = file_get_contents('php://input');
error_log($jsonString);
$jsonObj = json_decode($jsonString);

$message = $jsonObj->{"events"}[0]->{"message"};
$replyToken = $jsonObj->{"events"}[0]->{"replyToken"};

$userinfo = $jsonObj->{"events"}[0]->{"user"};

// �����Ă������b�Z�[�W�̒��g���烌�X�|���X�̃^�C�v��I��
if ($message->{"text"} == '�m�F') {
    // �m�F�_�C�A���O�^�C�v
    $messageData = [
        'type' => 'template',
        'altText' => '�m�F�_�C�A���O',
        'template' => [
            'type' => 'confirm',
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
} elseif ($message->{"text"} == 'button') {
    // �{�^���^�C�v
    $messageData = [
        'type' => 'template',
        'altText' => '�{�^��',
        'template' => [
            'type' => 'buttons',
            'title' => '�^�C�g���ł�',
            'text' => '�I�����Ă�',
            'actions' => [
                [
                    'type' => 'postback',
                    'label' => 'webhook��post���M',
                    'data' => 'value'
                ],
                [
                    'type' => 'uri',
                    'label' => 'google�ֈړ�',
                    'uri' => 'https://google.com'
                ]
            ]
        ]
    ];
} elseif ($message->{"text"} == '�J���[�Z��') {
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
} elseif ($message->{"text"} == 'google') {
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
} elseif ($message->{"text"} == 'img1') {
	$messageData = [
		'type' => 'image',
		'originalContentUrl' => 'test1 / image / �N�[�|��.jpg ',
		'previewImageUrl' => 'test1 / image / �N�[�|��.jpg '
	];
}elseif ($message->{"text"} == 'abu') {
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
error_log(json_encode($response));

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
