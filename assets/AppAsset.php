<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/main/hotlogin.css',
        'css/main/template.css',
        'css/main/showtags.css',
        'css/main/attachments_list.css',
    ];
    public $js = [
        'js/bootstrap.min.js',
        'js/mootools-core.js',
        'js/core.js',

        'js/template.js',
        'js/caption.js',
        'js/html5fallback.js',
        'js/jquery-migrate.min.js',
        'js/jquery-noconflict.js',
        'js/hotlogin.js',
//        'js/punycode.js',
//        'js/validate.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
