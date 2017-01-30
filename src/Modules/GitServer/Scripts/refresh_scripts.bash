#!/usr/bin/env bash

userdel ptgit
rm -rf /home/ptgit
useradd -s /bin/sh -m -d /home/ptgit ptgit
usermod -p `date +%s | sha256sum | base64 | head -c 32 ; echo` ptgit
mkdir -p /Scripts/
mkdir -p /home/ptgit/ptsource/
cp /opt/ptsource/ptsource/src/Modules/GitServer/Scripts/* /Scripts/
cp /opt/ptsource/ptsource/src/Modules/GitServer/Scripts/* /home/ptgit/ptsource/
chown -R root /Scripts/
chmod -R 700 /Scripts/
chmod -R +x /Scripts/
chown -R ptgit /home/ptgit/ptsource/
chmod -R 700 /home/ptgit/ptsource/
chmod -R +x /home/ptgit/ptsource/
service ssh restart
chown -R ptsource:ptgit /opt/ptsource/repositories/*
chmod -R 775 /opt/ptsource/repositories/*