yii2fullcalendar
================

JQuery Fullcalendar Yii2 Extension

JQuery from:
http://arshaw.com/fullcalendar/

License MIT

JQuery Documentation:
http://arshaw.com/fullcalendar/docs/

Yii2 Extension by <philipp@frenzel.net>

Usage
=====

Quickstart Looks like this:

'''

  $events = array();
  //Testing
  $Event = new \yii2fullcalendar\models\Event();
  $Event->id = 1;
  $Event->title = 'Testing';
  $Event->start = date('Y-m-d\Th:m:s\Z');
  $events[] = $Event;

  $Event = new \yii2fullcalendar\models\Event();
  $Event->id = 2;
  $Event->title = 'Testing';
  $Event->start = date('Y-m-d\Th:m:s\Z',strtotime('tomorrow 6am'));
  $events[] = $Event;

  ?>
  
  <?= yii2fullcalendar\yii2fullcalendar::widget(array(
      'events'=> $events,
  ));
'''

Note, that this will only view the events without any detailed view or option to add a new event.. etc.

AJAX Usage
==========
If you wanna use ajax loader, this could look like this:
'''
<?= yii2fullcalendar\yii2fullcalendar::widget(array(
  'ajaxEvents' => Html::Url(array('/timetrack/default/jsoncalendar')),
  ));
'''

and inside your referenced controller, the action should look like this:

'''
public function actionJsoncalendar($start=NULL,$end=NULL,$_=NULL){
    $times = \app\modules\timetrack\models\Timetable::find()->where(array('category'=>\app\modules\timetrack\models\Timetable::CAT_TIMETRACK))->all();

    $events = array();

    foreach ($times AS $time){
      //Testing
      $Event = new \yii2fullcalendar\models\Event();
      $Event->id = $time->id;
      $Event->title = $time->categoryAsString;
      $Event->start = date('Y-m-d\Th:m:s\Z',strtotime($time->date_start.' '.$time->time_start));
      $Event->end = date('Y-m-d\Th:m:s\Z',strtotime($time->date_start.' '.$time->time_end));
      $events[] = $Event;
    }

    header('Content-type: application/json');
    echo Json::encode($events);
    exit;
  }
'''
