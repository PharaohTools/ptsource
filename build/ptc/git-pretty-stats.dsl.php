PackageManager pkg-ensure
  package-name "{{ loop }}"
  packager Apt
  loop "php-curl,php-xdebug,python,graphviz"

Mkdir path
  label "Make a dir for XDebug output"
  path "{{ loop }}"
  recursive
  loop "/var/www/xdebug_out,/tmp/xdebug_out"

Templating install
  label "XDebug FPM Configuration"
  source "{{{ Facts::Runtime::factGetConstant::PFILESDIR }}}ptsource/ptsource/build/ptc/Templates/xdebug.ini"
  target "/etc/php/7.0/fpm/conf.d/20-xdebug.ini"
  template_output_dir '/tmp/xdebug_out'
  guess

Templating install
  label "XDebug Apache Configuration"
  source "{{{ Facts::Runtime::factGetConstant::PFILESDIR }}}ptsource/ptsource/build/ptc/Templates/xdebug.ini"
  target "/etc/php/7.0/apache2/conf.d/20-xdebug.ini"
  template_output_dir '/var/www/xdebug_out'
  guess

RunCommand execute
  label "Restart FPM"
  command "service php7.0-fpm restart"
  guess

RunCommand execute
  label "Restart Apache"
  command "service apache2 restart"
  guess

Download file
  label 'Download'
  source "https://github.com/jokkedk/webgrind/archive/v1.5.0.zip"
  target "/opt/ptsource/v1.5.0.zip"
  yes
  guess

RunCommand execute
  label 'Unzip Webgrind'
  command "cd /opt/ptsource/ && unzip -qo v1.5.0.zip"
  guess

RunCommand execute
  label "Rename Webgrind Dir
  command "cd /opt/ptsource/ && rm -rf webgrind && mv webgrind-1.5.0 webgrind"
  guess

Copy put
  label "PHP Info for Webgrind"
  source "{{{ Facts::Runtime::factGetConstant::PFILESDIR }}}ptsource/ptsource/build/ptc/Templates/phpinfo.php"
  target "/opt/ptsource/webgrind/phpinfo.php"
  guess

Chown path
  label "Change webgrind ownership"
  path "/opt/ptsource/webgrind"
  user "ptsource:ptsource"
  recursive true
  guess

Copy put
  label "PHP Info for Track"
  source "{{{ Facts::Runtime::factGetConstant::PFILESDIR }}}ptsource/ptsource/build/ptc/Templates/phpinfo.php"
  target "{{{ Facts::Runtime::factGetConstant::PFILESDIR }}}ptsource/ptsource/src/Modules/PostInput/phpinfo.php"
  guess

Chown path
  label "Change phpinfo ownership"
  path "{{{ Facts::Runtime::factGetConstant::PFILESDIR }}}ptsource/ptsource/src/Modules/PostInput/phpinfo.php"
  user "ptsource:ptsource"
  guess

RunCommand execute
  label "Create Host File Entry"
  command "ptdeploy HostEditor add -yg --host-ip=127.0.0.1 --hostname=webgrind.track.pharaohtools.vm"
  guess

Copy put
  label "Webgrind Apache VHost"
  source "{{{ Facts::Runtime::factGetConstant::PFILESDIR }}}ptsource/ptsource/build/ptc/Templates/webgrind.track.pharaohtools.vm.conf"
  target "/etc/apache2/sites-available/webgrind.track.pharaohtools.vm.conf"
  guess

RunCommand execute
  label "Enable Apache VHost"
  command "a2ensite webgrind.track.pharaohtools.vm"
  guess

Service restart
  label "Restart Services"
  name "{{ loop }}"
  loop "apache2,php7.0-fpm"