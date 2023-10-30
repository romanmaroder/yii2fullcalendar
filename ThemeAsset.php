<?php

namespace yii2fullcalendar;

use Yii;
use yii\web\AssetBundle;

/**
 * @link http://www.frenzel.net/
 * @author Philipp Frenzel <philipp@frenzel.net> 
 */

class ThemeAsset extends AssetBundle
{   
     public $sourcePath = '@bower/jquery.ui/dist';
    public $js = [
        'jquery-ui.js',
    ];
    public $css = [
        'themes/smoothness/jquery-ui.css',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
