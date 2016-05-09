<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../Source/vendor/autoload.php');

use Sabre\VObject\Component\VCalendar;

function getClient()
{
	$client = new SimpleCalDAVClient();
	$client->connect("http://localhost:8008/calendars/users/test/calendar/", "test", "test");
	$arrayOfCalendars = $client->findCalendars();
	$client->setCalendar($arrayOfCalendars["calendar"]);
	return $client;
}


$events = getClient()->getEvents("19000101T000000Z", "20991231T235959Z");

while(count($events) > 0)
{
	getClient()->delete($events[0]->getHref(), $events[0]->getEtag());
	$events = getClient()->getEvents("19000101T000000Z", "20991231T235959Z");
}


$test1 = new VCalendar([
    'VEVENT' => [
        'SUMMARY' => 'Test 1',
        'DTSTART' => new \DateTime('2016-03-07 10:00:00'),
        'DTEND'   => new \DateTime('2016-03-07 12:00:00')
    ]
]);

$test2 = new VCalendar([
    'VEVENT' => [
        'SUMMARY' => 'Test 2',
        'DTSTART' => new \DateTime('2016-03-07 12:00:00'),
        'DTEND'   => new \DateTime('2016-03-07 14:00:00')
    ]
]);

$test3 = new VCalendar([
    'VEVENT' => [
        'SUMMARY' => 'Test 3',
        'DTSTART' => new \DateTime('2016-03-07 12:00:00'),
        'DTEND'   => new \DateTime('2016-03-07 15:00:00')
    ]
]);

$test4 = new VCalendar([
    'VEVENT' => [
        'SUMMARY' => 'Test 4',
        'DTSTART' => new \DateTime('2016-03-07 16:00:00'),
        'DTEND'   => new \DateTime('2016-03-07 18:00:00')
    ]
]);

getClient()->create($test1->serialize());
getClient()->create($test2->serialize());
getClient()->create($test3->serialize());
getClient()->create($test4->serialize());