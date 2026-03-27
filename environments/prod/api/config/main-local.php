<?php

return [
    'components' => [
        'request' => [
            'cookieValidationKey' => '<cookie-validation-key>',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
];
