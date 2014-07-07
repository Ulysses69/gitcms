<?php

require_once('Record.php');

class EventsAttraction extends EventsRecord
{
    const TABLE_NAME = 'events_attractions';

    public $id;
    public $name;
    public $email;
    public $phone;
    public $link;
    public $bio;

}
