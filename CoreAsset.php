<?php

namespace yii2fullcalendar;

use Yii;
use yii\web\AssetBundle;

/**
 * @link http://www.frenzel.net/
 * @author Philipp Frenzel <philipp@frenzel.net> 
 */

class CoreAsset extends AssetBundle
{
    /**
     * [$sourcePath description]
     * @var string
     */
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins/fullcalendar/';

    /**
     * the language the calender will be displayed in
     * @var string ISO2 code for the wished display language
     */
    public $language = NULL;

    /**
     * [$autoGenerate description]
     * @var boolean
     */
    public $autoGenerate = true;

    /**
     * tell the calendar, if you like to render google calendar events within the view
     * @var boolean
     */
    public $googleCalendar = false;
    
    /**
     * [$css description]
     * @var array
     */
    public $css = [
        'main.min.css',
    ];

    /**
     * [$js description]
     * @var array
     */
    public $js = [
        'main.js',        
        'locales-all.js',
    ];
    
    /**
     * [$depends description]
     * @var array
     */
    public $depends = [
        //'yii\web\YiiAsset',
        //'yii2fullcalendar\PrintAsset'
    ];

    /**
     * @inheritdoc
     */
    public function registerAssetFiles($view)
    {
        $language = $this->language ? $this->language : Yii::$app->language;
        if (strtoupper($language) != 'EN-US') 
        {
            $this->js[] = "locales/{$language}.js";
        }

        if($this->googleCalendar)
        {
            $this->js[] = 'gcal.js';
        }

        parent::registerAssetFiles($view);
    }

}
