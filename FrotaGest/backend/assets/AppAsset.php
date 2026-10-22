<?php

declare(strict_types=1);

namespace backend\assets;

use hail812\adminlte3\assets\AdminLteAsset;
use hail812\adminlte3\assets\FontAwesomeAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

/**
 * Asset principal do backend (AdminLTE 3 / Bootstrap 4).
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $depends = [
        YiiAsset::class,
        AdminLteAsset::class,
        FontAwesomeAsset::class,
    ];
}
