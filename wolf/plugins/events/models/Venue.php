<?php

require_once('Record.php');

class EventsVenue extends EventsRecord
{
    const TABLE_NAME = 'events_venues';

    public $id;
    public $name;
    public $street;
    public $suburb;
    public $state;
    public $postcode;
	public $country;
	public $link;
	public $phone;
	public $contact_name;
	public $contact_email;
	public $description;

}
