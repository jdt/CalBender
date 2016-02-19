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
}