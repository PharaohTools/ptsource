#!/usr/bin/env bash

userdel ptbinary
rm -rf /home/ptbinary
useradd -s /bin/bash -m -d /home/ptbinary ptbinary
usermod -p `date +%s | sha256sum | base64 | head -c 32 ; echo` ptbinary
mkdir -p /Scripts/
mkdir -p /home/ptbinary/ptsource/
cp /opt/ptsource/ptsource/src/Modules/GitServer/Scripts/* /PTSourceScripts/
cp /opt/ptsource/ptsource/src/Modules/GitServer/Scripts/* /home/ptbinary/ptsource/
chown -R root /PTSourceScripts/
chmod -R 755 /PTSourceScripts/
chmod -R +x /PTSourceScripts/
chown -R ptbinary /home/ptbinary/ptsource/
chmod -R 755 /home/ptbinary/ptsource/
chmod -R +x /home/ptbinary/ptsource/
service ssh restart
chown -R ptsource:ptbinary /opt/ptsource/repositories/*
chmod -R 775 /opt/ptsource/repositories/*