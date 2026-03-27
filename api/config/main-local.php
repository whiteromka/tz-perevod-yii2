<?php

return [
    'components' => [
        'request' => [
            // !!! вставьте секретный ключ ниже !!!
            'cookieValidationKey' => '6e8dcd95d4613a8b1db9ce8a9132e7d3b3f1a6c2d3564ee5fe02b3dc04b2df36',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning', 'info', 'trace'],
                ],
            ],
        ],
    ],
];
