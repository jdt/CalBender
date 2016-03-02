#define where to look for executed commands
Exec 
{ 
	path => [ "/bin/", "/sbin/" , "/usr/bin/", "/usr/sbin/" ] 
}
  
#run apt-get update
exec 
{ 'system-update':
	command => 'sudo apt-get update'
}

#and always run apt-get update prior to package installation
Exec['system-update'] -> Package <| |>

class 
{ 
	'apache': 
}

apache::vhost 
{ 'default':
  priority => '',
  docroot => '/vagrant/Source/web'
}

class
{
	'php':
}

class 
{ 
	'composer':
}

class 
{ 
	'phpunit':
}

class
{
	'calendarserver':
		auth_basic_enabled => 'true'
}