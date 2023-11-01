<?php

namespace yii2fullcalendar\models;

use yii\base\Model;

class Event extends Model
{

    /**
     * Detailed description off all fields can be found here
     * @url http://arshaw.com/fullcalendar/docs/event_data/Event_Object/
     */

    /**
     * String or Integer. Will uniquely identify your event. Useful for getEventById.
     * @var integer
     */
    public $id;

    /**
     * String or Integer. Events that share a groupId will be dragged and resized together automatically.
     * @var string
     */
    public $groupId;

    /**
     * Boolean (true or false). Determines if the event is shown in the “all-day” section of the view, if applicable.
     * Determines if time text is displayed in the event.
     * If this value is not specified, it will be inferred by the start and end properties. See notes below.
     * Do not put quotes around this value. That would make it a string, not a boolean.
     * @var boolean
     */
    public $allDay;

    /**
     * Something  https://fullcalendar.io/docs/v5/date-parsing
     * When your event begins. If your event is explicitly allDay, hour, minutes, seconds and milliseconds will be ignored.
     * @var datetime
     */
    public $start;

    /**
     * Something  https://fullcalendar.io/docs/v5/date-parsing
     * When your event ends. If your event is explicitly allDay, hour, minutes, seconds and milliseconds will be ignored.
     * If omitted, your events will appear to have the default duration. See https://fullcalendar.io/docs/v5/defaultAllDayEventDuration
     * https://fullcalendar.io/docs/v5/defaultTimedEventDuration and https://fullcalendar.io/docs/v5/forceEventDuration for more info.
     * Note: This value is exclusive. For example, if you have an all-day event that has an end of 2018-09-03,
     * then it will span through 2018-09-02 and end before the start of 2018-09-03.
     * @var datetime
     */
    public $end;

    /**
     * An ISO8601 string representation of the start date. If the event is all-day, there will not be a time part.
     */
    public $startStr;

    /**
     * An ISO8601 string representation of the end date. If the event is all-day, there will not be a time part.
     */
    public $endStr;

    /**
     * String. The text that will appear on an event.
     * @var string
     */
    public $title;

    /**
     * String. A URL that will be visited when this event is clicked by the user. For more information on controlling
     * this behavior, see the https://fullcalendar.io/docs/v5/eventClick callback.
     * @var string
     */
    public $url;

    /**
     * An array of strings like [ 'myclass1', myclass2' ].
     * Determines which HTML classNames will be attached to the rendered event.
     * @var array
     */
    public $classNames;

    /**
     * Boolean (true or false). Overrides the master editable option for this single event.
     * https://fullcalendar.io/docs/v5/editable
     * @var boolean
     */
    public $editable;

    /**
     * Boolean (true or false). Overrides the master eventStartEditable option for this single event.
     * https://fullcalendar.io/docs/v5/eventStartEditable
     * @var [type]
     */
    public $startEditable;

    /**
     * Boolean (true or false). Overrides the master eventDurationEditable option for this single event.
     * https://fullcalendar.io/docs/v5/eventDurationEditable
     * @var [type]
     */
    public $durationEditable;

    /**
     * Boolean (true or false). Overrides the master eventResourceEditable option for this single event.
     * Requires one of the resource plugins.
     * https://fullcalendar.io/docs/v5/eventResourceEditable
     * https://fullcalendar.io/pricing
     * @var boolean
     */
    public $resourceEditable;

    /**
     * The rendering type of this event. Can be 'auto', 'block', 'list-item', 'background', 'inverse-background', or 'none'.
     * See eventDisplay.
     * https://fullcalendar.io/docs/v5/eventDisplay
     */
    public $display;

    /**
     * The value overriding the eventOverlap setting for this specific event.
     * If false, prevents this event from being dragged/resized over other events.
     * Also prevents other events from being dragged/resized over this event. Does not accept a function.
     * https://fullcalendar.io/docs/v5/eventOverlap
     * @var bool
     */
    public $overlap;

    /**
     * The eventConstraint override for this specific event.
     * https://fullcalendar.io/docs/v5/eventConstraint
     * @var [type]
     */
    public $constraint;

    /**
     * The eventBackgroundColor override for this specific event.
     * https://fullcalendar.io/docs/v5/eventBackgroundColor
     * @var [type]
     */
    public $backgroundColor;

    /**
     * The eventBorderColor override for this specific event.
     * https://fullcalendar.io/docs/v5/eventBorderColor
     * @var [type]
     */
    public $borderColor;

    /**
     * The eventTextColor override for this specific event.
     * https://fullcalendar.io/docs/v5/eventTextColor
     * @var [type]
     */
    public $textColor;

    /**
     * A plain object holding miscellaneous other properties specified during parsing.
     * Receives properties in the explicitly given extendedProps hash as well as other non-standard properties.
     */
    public $extendedProps;

    /**
     * A reference to the Event Source this event came from.
     * If the event was added dynamically via addEvent, and the source parameter was not specified, this value will be null.
     * https://fullcalendar.io/docs/v5/event-source-object
     * https://fullcalendar.io/docs/v5/Calendar-addEvent
     * @var [type]
     */
    public $source;

    /**
     * Sets an event's non-standard fields. FullCalendar will not modify or delete
     * these fields. For example, developers often include a description field for
     * use in callbacks such as eventRender.
     *
     * @since 2017.01.18
     * @author @markebjones
     * @see https://fullcalendar.io/docs/event_data/Event_Object/
     */
    public $nonstandard;

    public function rules()
    {
        return [
            [['id', 'resourceId'], 'integer'],
            [
                'title, allDay, start, end, url, className, rendering, constraint, source, color, backgroundColor, borderColor, textColor, nonstandard, extendedProps',
                'safe'
            ],
            ['editable, startEditable, durationEditable, resourceEditable, overlap', 'boolean'],
        ];
    }

}
