#!/bin/sh
echo "dave" >> /tmp/userx_log
# [ "$PAM_TYPE" = "open_session" ] || exit 0
echo "User: $PAM_USER" >> /tmp/pamlog
echo "Ruser: $PAM_RUSER" >> /tmp/pamlog
echo "Rhost: $PAM_RHOST" >> /tmp/pamlog
echo "Service: $PAM_SERVICE" >> /tmp/pamlog
echo "TTY: $PAM_TTY" >> /tmp/pamlog
echo "Date: `date`" >> /tmp/pamlog
echo "Server: `uname -a`" >> /tmp/pamlog