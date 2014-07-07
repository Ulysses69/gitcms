<?php

require_once('Record.php');

class EventsCategory extends EventsRecord
{
    const TABLE_NAME = 'events_categories';

    public $id;
    public $name;

}
