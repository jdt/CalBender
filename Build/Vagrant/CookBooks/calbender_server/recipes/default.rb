package 'apache2'

service 'apache2' do
  action [:enable, :start]
end