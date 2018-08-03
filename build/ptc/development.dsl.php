GitKeySafe ensure
  guess

Composer ensure
  guess

NodeJS install

PTBuild install
  label "Lets configure Pharaoh Build without installing, as we are using files from the host"
  vhe-url "$$subdomain.{{{ var::domain }}}"
  vhe-ip-port "0.0.0.0:80"
  version latest
  no-clone
  no-permissions
  guess

SudoNoPass install
  label "Sudo ability for Pharaoh Build user"
  install-user-name ptbuild

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
  source "/opt/ptbuild/ptbuild/build/ptbuild/ptbuildvars"
  target /opt/ptbuild/ptbuild/
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