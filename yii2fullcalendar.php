<?php

/**
 * This class is used to embed FullCalendar JQuery Plugin to my Yii2 Projects
 * @copyright Frenzel GmbH - www.frenzel.net
 * @link http://www.frenzel.net
 * @author Philipp Frenzel <philipp@frenzel.net>
 *
 */

namespace yii2fullcalendar;

use yii\base\Widget as elWidget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\web\View;

class yii2fullcalendar extends elWidget
{

    /**
     * @var array options the HTML attributes (name-value pairs) for the field container tag.
     * The values will be HTML-encoded using [[Html::encode()]].
     * If a value is null, the corresponding attribute will not be rendered.
     */
    public $options = [
        'class' => 'fullcalendar'
    ];

    /**
     * @var bool $theme default is true and will render the jui theme for the calendar
     */
    public $theme = true;

    /**
     * @var the name of the theme how the calendar should be displayed. default bootstrap 3
     * Available Options
     *
     */
    public $themeSystem = 'bootstrap3';

    /**
     * @var array clientOptions the HTML attributes for the widget container tag.
     */
    public $clientOptions = [
        'weekends' => true,
        'editable' => false,
        'aspectRatio' => 1.35
    ];

    /**
     * @var string initialView will define which view renderer will initially be used for displaying calendar events
     */
    public $initialView= 'dayGridMonth';

    /**
     * Holds an array of Event Objects
     * @var array events of yii2fullcalendar\models\Event
     * @todo add the event class and write docs
     **/
    public $events = [];

    /**
     * Add custom buttons to the calendar header
     * @var array customButtons
     */
    public $customButtons = [];

    /**
     * Define the look n feel for the calendar header, known placeholders are left, center, right
     * @var array header format
     */
    public $headerToolbar = [
        'center' => 'title',
        'left' => 'prev,next today',
        'right' => 'GridMonth,GridWeek'
    ];

    /**
     * Will hold an url to json formatted events!
     * replaced by $events pls refer to fullcalendar.io documentation
     * @var url to json service
     */
    public $ajaxEvents = null;

    /**
     * wheather the events will be "sticky" on pagination or not. Uncomment if you are loading events
     * separately from the initial options.
     * @var boolean
     */
    //public $stickyEvents = true;

    /**
     * public string/integer $contentHeight
     */
    public $contentHeight = null;

    /**
     * tell the calendar, if you like to render google calendar events within the view
     * @var boolean
     */
    public $googleCalendar = false;

    /**
     * the text that will be displayed on changing the pages
     * @var string
     */
    public $loading = 'Loading ...';

    /**
     * internal marker for the name of the plugin
     * @var string
     */
    private $_pluginName = 'fullCalendar';

    /**
     * The javascript function to us as en onLoading callback
     * @var string the javascript code that implements the onLoading function
     */
    public $onLoading = "";

    /**
     * The javascript function to us as en eventRender callback
     * @var string the javascript code that implements the eventRender function
     */
    public $eventRender = "";

    /**
     * The javascript function to us as en eventAfterRender callback
     * @var string the javascript code that implements the eventAfterRender function
     */
    public $eventAfterRender = "";

    /**
     * The javascript function to us as en eventAfterAllRender callback
     * @var string the javascript code that implements the eventAfterAllRender function
     */
    public $eventAfterAllRender = "";

    /**
     * The javascript function to us as en eventDrop callback
     * @var string the javascript code that implements the eventDrop function
     */

    public $eventDrop = "";

    /**
     * The javascript function to us as en eventResize callback
     * @var string the javascript code that implements the eventResize function
     */

    public $eventResize = "";

    /**
     * A js callback that triggered when the user clicks an event.
     * @var string the javascript code that implements the eventClick function
     */
    public $eventClick = "";

    /**
     * A js callback that triggered when the user clicks an day.
     * @var string the javascript code that implements the dayClick function
     */
    public $dayClick = "";

    /**
     * A js callback that will fire after a selection is made.
     * @var string the javascript code that implements the select function
     */
    public $select = "";

    public $eventContent="";
    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
        //checks for the element id
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        //checks for the class
        if (!isset($this->options['class'])) {
            $this->options['class'] = 'fullcalendar';
        }

        parent::init();
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->options['data-plugin-name'] = $this->_pluginName;

        if (!isset($this->options['class'])) {
            $this->options['class'] = 'fullcalendar';
        }

        echo Html::beginTag('div', $this->options) . "\n";
        echo Html::beginTag('div', ['class' => 'fc-loading', 'style' => 'display:none;']);
        echo Html::encode($this->loading);
        echo Html::endTag('div') . "\n";
        echo Html::endTag('div') . "\n";
        $this->registerPlugin();
    }

    /**
     * Registers the FullCalendar javascript assets and builds the requiered js  for the widget and the related events
     */
    protected function registerPlugin()
    {
        $id = $this->options['id'];
        $view = $this->getView();

        /** @var \yii\web\AssetBundle $assetClass */
        $assets = CoreAsset::register($view);

        //by default we load the jui theme, but if you like you can set the theme to false and nothing gets loaded....
        if ($this->theme == true) {
            ThemeAsset::register($view);
        }

        if (array_key_exists(
                'initialView',
                $this->clientOptions
            ) && ($this->clientOptions['initialView'] == 'timeGridDay' || $this->clientOptions['initialView'] == 'timeGridWeek' || $this->clientOptions['initialView'] == 'dayGridMonth' || $this->clientOptions['initialView'] == 'GridDay')) {
            SchedulerAsset::register($view);
        }

        if (isset($this->options['lang'])) {
            $assets->language = $this->options['lang'];
        }

        if ($this->googleCalendar) {
            $assets->googleCalendar = $this->googleCalendar;
        }

        $js = array();

        if ($this->ajaxEvents != null) {
            $this->clientOptions['events'] = $this->ajaxEvents;
        }

        if (!is_null($this->contentHeight) && !isset($this->clientOptions['contentHeight'])) {
            $this->clientOptions['contentHeight'] = $this->contentHeight;
        }

        if (isset($this->customButtons) && !isset($this->clientOptions['customButtons'])) {
            $this->clientOptions['customButtons'] = $this->customButtons;
        }

        if (is_array($this->headerToolbar) && isset($this->clientOptions['headerToolbar'])) {
            $this->clientOptions['headerToolbar'] = array_merge($this->headerToolbar, $this->clientOptions['headerToolbar']);
        } else {
            $this->clientOptions['headerToolbar'] = $this->headerToolbar;
        }

        if (isset($this->initialView) && !isset($this->clientOptions['initialView'])) {
            $this->clientOptions['initialView'] = $this->initialView;
        }


        // clear existing calendar display before rendering new fullcalendar instance
        // this step is important when using the fullcalendar widget with pjax
        //$js[] = "var loading_container = jQuery('#$id .fc-loading');"; // take backup of loading container
        //$js[] = "jQuery('#$id').empty().append(loading_container);"; // remove/empty the calendar container and append loading container bakup

        $cleanOptions = $this->getClientOptions();
        $js[] = "new FullCalendar.Calendar($id,$cleanOptions).render();";

        /**
         * Loads events separately from the calendar creation. Uncomment if you need this functionality.
         *
         * lets check if we have an event for the calendar...
         * if(is_array($this->events))
         * {
         *    foreach($this->events AS $event)
         *    {
         *        $jsonEvent = Json::encode($event);
         *        $isSticky = $this->stickyEvents;
         *        $js[] = "jQuery('#$id').fullCalendar('renderEvent',$jsonEvent,$isSticky);";
         *    }
         * }
         */

        $view->registerJs(implode("\n", $js), View::POS_READY);
    }

    /**
     * @return array the options for the text field
     */
    protected function getClientOptions()
    {
        $id = $this->options['id'];

        if ($this->onLoading) {
            $options['loading'] = new JsExpression($this->onLoading);
        } else {
            $options['loading'] = new JsExpression(
                "function(isLoading, view ) {
	    }"
            );
        }

        //add new theme information for the calendar                                       
        $options['themeSystem'] = $this->themeSystem;

        if ($this->eventRender) {
            $options['eventRender'] = new JsExpression($this->eventRender);
        }
        if ($this->eventAfterRender) {
            $options['eventAfterRender'] = new JsExpression($this->eventAfterRender);
        }
        if ($this->eventAfterAllRender) {
            $options['eventAfterAllRender'] = new JsExpression($this->eventAfterAllRender);
        }

        if ($this->eventDrop) {
            $options['eventDrop'] = new JsExpression($this->eventDrop);
        }

        if ($this->eventResize) {
            $options['eventResize'] = new JsExpression($this->eventResize);
        }

        if ($this->select) {
            $options['select'] = new JsExpression($this->select);
        }

        if ($this->eventClick) {
            $options['eventClick'] = new JsExpression($this->eventClick);
        }
        if ($this->eventContent) {
            $options['eventContent'] = new JsExpression($this->eventContent);
        }
        if ($this->dayClick) {
            $options['dayClick'] = new JsExpression($this->dayClick);
        }

        if (is_array($this->events) || is_string($this->events)) {
            $options['events'] = $this->events;
        }

        $options = array_merge($options, $this->clientOptions);
        return Json::encode($options);
    }

}


