GitKeySafe ensure
  guess

Composer ensure
  guess

NodeJS install

RunCommand execute
  label "Add the Ondrej PPA"
  command "add-apt-repository ppa:ondrej/php -y"
  guess

RunCommand execute
  label "Update Apt with the Ondrej PPA"
  command "apt-get update"
  guess

PackageManager pkg-ensure
  package-name "{{ loop }}"
  packager Apt
  loop "php7.1,php7.1-cli,php7.1-curl,php7.1-fpm,php7.1-gd,php7.1-json,php7.1-mysql,php7.1-readline,php7.1-xml,php7.1-pdo-sqlite,php7.1-sqlite3,php7.1-xdebug,libapache2-mod-php7.1"

RunCommand execute
  label "Install prequisite packages"
  command "apt-get install -y apache2 libapache2-mod-php7.1 sqlite3 zip unzip"
  guess

RunCommand execute
  label "Enable PHP 7 for FPM"
  command "a2enmod proxy_fcgi setenvif && a2enconf php7.1-fpm"
  guess

RunCommand execute
  label "Set the Apache php module to 7"
  command "a2dismod php5 || true && a2enmod php7.1 || true && service apache2 restart || true && a2enmod proxy_fcgi setenvif"
  guess

VariableGroups dump
  guess

PTSource install
  label "Lets configure Pharaoh Source without installing, as we are using files from the host"
  vhe-url "$$subdomain.{{{ var::domain }}}"
  vhe-ip-port "0.0.0.0:80"
  version latest
  no-clone
  no-permissions
  enable-http
  guess

RunCommand execute
  label "Create a default admin user"
  command "ptsource userprofile create -yg --create_username=admin --create_email=any@pharaohtools.com --update_password=admin --update_password_match=admin"
  guess

VariableGroups dump
  guess

PTBuild install
  label "Lets install Pharaoh Build"
  vhe-url "$$buildsubdomain.{{{ var::domain }}}"
  vhe-ip-port "0.0.0.0:80"
  version latest
  guess

SudoNoPass install
  label "Sudo ability for Pharaoh Build user"
  install-user-name ptbuild
  guess

SudoNoPass install
  label "Sudo ability for PTV user"
  install-user-name ptv
  guess

Logging log
  log-message "Lets copy in our build pipes"
  source Autopilot

RunCommand execute
  label "Get the names of the Build pipes"
  command 'cd /opt/ptbuild/ptbuild/build/ptbuild/pipes/ && ls -1 | paste -sd "," -'
  guess
  register "build_pipe_names"

Logging log
  log-message "build pipe names are {{{ param::build_pipe_names }}}"
  source Autopilot

RunCommand execute
  label "Import the Development Build pipes"
  command "ptbuild importexport import -yg --source=/opt/ptbuild/ptbuild/build/ptbuild/pipes/{{ loop }}"
  loop "{{{ param::build_pipe_names }}}"
  guess

RunCommand execute
  label "Create a default admin user"
  command "ptbuild userprofile create -yg --create_username=admin --create_email=any@pharaohtools.com --update_password=admin --update_password_match=admin"
  guess

Copy put
  label "Import the Pharaoh Build Config"
  source "/opt/ptsource/ptsource/build/ptbuild/ptbuildvars"
  target /opt/ptbuild/ptbuild/ptbuildvars
  recursive

Chown path
  label "Lets ensure ownership of our build pipes to build user"
  path /opt/ptbuild/pipes
  user ptbuild:ptbuild
  recursive

Mkdir path
  label "Make a build user dir to copy shared keys from the host to"
  path /home/ptbuild/.ssh
  recursive

Chgrp path
  label "Lets ensure group ownership of our ssh dir"
  path /home/ptbuild/.ssh
  group ptbuild
  recursive

Chmod path
  label "Lets ensure correct level of private key security"
  path /home/ptbuild/.ssh
  mode 0777
  recursive

RunCommand execute
  label "Enable the Apache Rewrite Module"
  command "a2enmod rewrite"
  guess

StandardTools ensure
  label "Lets ensure some standard tools are installed"

GitTools ensure
  label "Lets ensure some git tools are installed"

RunCommand execute
  label "FS Fixes for web writing to share"
  command "usermod -a -G vboxsf www-data"
  guess

RunCommand execute
  label "FS Fixes for web writing to share in a Virtual Machine"
  command "usermod -a -G vboxsf ptv"
  guess

Service stop
  label "Stop PHP 5 FPM"
  service-name "php5-fpm"
  guess

Service start
  label "Start PHP 7 FPM"
  service-name "php7.4-fpm"
  guess
