package 'apache2'

template '/etc/apache2/sites-enabled/000-default' do
  source '000-default.erb'
end

template '/etc/apt/sources.list' do
  source 'sources.list.erb'
end

package 'php5' do
	version '5.6.18-1~dotdeb+7.1'
end