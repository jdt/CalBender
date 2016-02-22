class calendarserver
(
	$auth_basic_enabled		= params_lookup('auth_basic_enabled')
) inherits calendarserver::params
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

	file
	{
		'/etc/caldavd/caldavd.plist':
			ensure  => file,
			content => template('calendarserver/caldavd.plist.erb')
	}

	service 
	{ 
		"calendarserver":
    		ensure => running,
    		subscribe => File["/etc/default/calendarserver", "/etc/caldavd/caldavd.plist"]
	}
}