class php {
  package { "php5":
    ensure  => latest,
  }

  package { "libapache2-mod-php5": 
    ensure => latest, 
    notify => Service["apache2"] 
  }

  package { "php5-curl":
    ensure => latest,
    notify => Service["apache2"]
  }

  package { "php5-mcrypt": 
    ensure => latest,
    notify => Service["apache2"]
  }

  package { "php5-intl": 
    ensure => latest,
    notify => Service["apache2"]
  }

  file_line { 'ini timezone apache':
    path  => '/etc/php5/apache2/php.ini',
    line  => 'date.timezone = UTC',
    match => '^;date.timezone ='
  }

  file_line { 'ini timezone cli':
    path  => '/etc/php5/cli/php.ini',
    line  => 'date.timezone = UTC',
    match => '^;date.timezone ='
  }
}