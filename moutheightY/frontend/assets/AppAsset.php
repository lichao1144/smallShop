<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/course.css',
        'css/register-login.css',
        'css/tab.css'
    ];
    public $js = [
        'js/jquery-3.3.1.min.js',
        'js/jquery-1.8.0.min.js',
        'js/jquery.tabs.js',
        'js/mine.js'
    ];

    public $images=[

    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
