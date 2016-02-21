class calendarserver 
{
	package 
	{ 
		"calendarserver":
	}

	file
	{
		'/etc/caldavd/accounts.xml':
			ensure  => file,
			content => template('calendarserver/accounts.xml.erb')
	}

	file
	{
		'/etc/caldavd/sudoers.plist':
			ensure  => file,
			content => template('calendarserver/sudoers.plist.erb')
	}

	file
	{
		'/etc/default/calendarserver':
			ensure  => file,
			content => template('calendarserver/calendarserver.erb')
	}

	service 
	{ 
		"calendarserver":
    		ensure => running,
    		subscribe => File["/etc/default/calendarserver"]
	}
}