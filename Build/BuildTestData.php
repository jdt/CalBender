<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class TestDataBuilder
{
	private $baseUrl = "http://localhost:8008/calendars/users/test/calendar/";
	private $userpwd = "test:test";	

	private function DoRequest($id, $method, $body)
	{
		$url = $this->baseUrl.$id.".ics";

		$headers = array(
			'Content-Type: text/calendar; charset=utf-8',
			'Expect: '
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, $this->userpwd);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

		if($body != "")
		{
			$headers[] = 'Content-Length: '.strlen($body);
			$headers[] = 'If-None-Match: *';
			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
		}

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$output = curl_exec($ch);
		if($output === false)
		{
		    echo 'Curl error: ' . curl_error($ch).PHP_EOL;
		}

		curl_close($ch);
	}

	public function CreateEvent($id, $description, $from, $to)
	{
		$formattedFrom = $from->format("Ymd\THis");
		$formattedTo = $to->format("Ymd\THis");

		$body = <<<__EOD
BEGIN:VCALENDAR
PRODID:-//Mozilla.org/NONSGML Mozilla Calendar V1.1//EN
VERSION:2.0
BEGIN:VTIMEZONE
TZID:Europe/Paris
BEGIN:DAYLIGHT
TZOFFSETFROM:+0100
TZOFFSETTO:+0200
TZNAME:CEST
DTSTART:19700329T020000
RRULE:FREQ=YEARLY;BYDAY=-1SU;BYMONTH=3
END:DAYLIGHT
END:VTIMEZONE
BEGIN:VEVENT
DTSTAMP:20160306T105816Z
DTSTART;TZID=Europe/Paris:$formattedFrom
DTEND;TZID=Europe/Paris:$formattedTo
UID:$id
SUMMARY:$description
END:VEVENT
END:VCALENDAR
__EOD;

		$this->DoRequest($id, "PUT", $body);
	}

	public function DeleteEvent($id)
	{
		$this->DoRequest($id, "DELETE", "");
	}

	public function DeleteAllEvents()
	{	
		$headers = array(
			'Content-Type: text/calendar; charset=utf-8',
			'Expect: '
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->baseUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, $this->userpwd);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$output = curl_exec($ch);
		curl_close($ch);

		$data = explode(PHP_EOL, $output);

		$uids = array();
		foreach($data as $key => $line)
		{
			if(substr($line, 0, strlen("UID:")) === "UID:")
			{
				$uids[] = substr($line, 4, -1);
			}
		}

		foreach($uids as $id)
		{
			$this->DeleteEvent($id."");
		}
	}
}


$builder = new TestDataBuilder();
$builder->DeleteAllEvents();
$builder->CreateEvent("id1", "Test 1", new DateTime("2016-03-07 10:00:00"), new DateTime("2016-03-07 12:00:00"));
$builder->CreateEvent("id2", "Test 2", new DateTime("2016-03-19 20:00:00"), new DateTime("2016-03-20 02:00:00"));
