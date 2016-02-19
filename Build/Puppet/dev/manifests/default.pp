Exec 
{ 
	path => [ "/bin/", "/sbin/" , "/usr/bin/", "/usr/sbin/" ] 
}
  
exec
{
	'apt-get update': command => 'apt-get update'
}

$sysPackages = [ "build-essential" ]
package 
{ 
	$sysPackages: ensure => "installed",
	require => Exec['apt-get update'],
}

class 
{ 
	'apache': 
}

apache::vhost 
{ 'default':
  priority => '',
  docroot => '/vagrant/Source'
}