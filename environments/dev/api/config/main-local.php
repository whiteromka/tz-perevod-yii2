<?php

return [
    'components' => [
        'request' => [
            'cookieValidationKey' => '<cookie-validation-key>',
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
