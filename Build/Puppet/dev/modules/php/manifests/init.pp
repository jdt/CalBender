class php {
  file_line { 'deb wheezy all':
    path  => '/etc/apt/sources.list',
    line  => 'deb http://packages.dotdeb.org wheezy all'
  }
  file_line { 'deb-src wheezy all':
    path  => '/etc/apt/sources.list',
    line  => 'deb-src http://packages.dotdeb.org wheezy all'
  }
  file_line { 'deb wheezy php5 all':
    path  => '/etc/apt/sources.list',
    line  => 'deb http://packages.dotdeb.org wheezy-php56 all'
  }
  file_line { 'deb-src wheezy php5 all':
    path  => '/etc/apt/sources.list',
    line  => 'deb-src http://packages.dotdeb.org wheezy-php56 all'
  }

  exec { 'get gpg':
    command => "wget https://www.dotdeb.org/dotdeb.gpg"
  }

  exec { 'apt-key gpg':
    command => "apt-key add dotdeb.gpg"
  }

  exec { 'update':
    command => "apt-get update"
  }

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

  exec { 'enable php5 module':
    command => "cp /etc/apache2/mods-available/php5.* /etc/apache2/mods-enabled/"
  }
}