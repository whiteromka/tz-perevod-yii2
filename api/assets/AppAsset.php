<?php

namespace api\assets;

use yii\web\AssetBundle;

/**
 * Asset bundle для API приложения
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [];
    public $depends = [];
}
