<?php

namespace yii2fullcalendar;

use yii\web\AssetBundle;

/**
 * @link http://www.frenzel.net/
 * @author Philipp Frenzel <philipp@frenzel.net> 
 */

class MomentAsset extends AssetBundle
{
    /**
     * [$sourcePath description]
     * @var string
     */
    //public $sourcePath = '@bower/moment';
    public $sourcePath = '@bower/fullcalendar/dist/moment';

    /**
     * [$js description]
     * @var array
     */
    public $js = [
        'main.js'
    ];

}
