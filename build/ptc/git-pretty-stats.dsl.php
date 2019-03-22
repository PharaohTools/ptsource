RunCommand execute
  label "Restart FPM"
  command "service php7.0-fpm restart"
  guess

RunCommand execute
  label "Restart Apache"
  command "service apache2 restart"
  guess

RunCommand execute
  label "Remove Git Pretty Stats Directory"
  command "rm -rf /opt/ptsource/git-pretty-stats"
  guess

RunCommand execute
  label "Clone Git Pretty Stats"
  command "cd /opt/ptsource && git clone https://github.com/modess/git-pretty-stats.git gitpretty"
  guess

Chown path
  label "Change git-pretty-stats ownership"
  path "/opt/ptsource/gitpretty"
  user "ptsource:ptsource"
  recursive true
  guess

RunCommand execute
  label "Create Host File Entry"
  command "ptdeploy HostEditor add -yg --host-ip=127.0.0.1 --hostname=gitpretty.source.pharaohtools.vm"
  guess

Copy put
  label "Git Pretty Apache VHost"
  source "{{{ Facts::Runtime::factGetConstant::PFILESDIR }}}ptsource/ptsource/build/ptc/Templates/gitpretty.source.pharaohtools.vm.conf"
  target "/etc/apache2/sites-available/gitpretty.source.pharaohtools.vm.conf"
  guess

RunCommand execute
  label "Enable Apache VHost"
  command "a2ensite gitpretty.source.pharaohtools.vm"
  guess

Service restart
  label "Restart Services"
  name "{{ loop }}"
  loop "apache2,php7.0-fpm"