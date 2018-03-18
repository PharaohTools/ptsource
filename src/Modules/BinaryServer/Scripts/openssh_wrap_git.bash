#!/usr/bin/env bash

#echo "Original command: $SSH_ORIGINAL_COMMAND" >> /tmp/sshlog ;
#echo "ptbinary key var: $PTGIT_KEY" >> /tmp/sshlog ;
#echo "ptbinary user var: $PTGIT_USER" >> /tmp/sshlog ;
## echo $SSH_ORIGINAL_COMMAND ;

if [[ $SSH_ORIGINAL_COMMAND == binary-upload-pack* ]] || [[ $SSH_ORIGINAL_COMMAND == binary-receive-pack* ]] ; then

    if [[ $SSH_ORIGINAL_COMMAND == */$PTGIT_USER/* ]] ; then
        new_command=`sed "s,/binary/$PTGIT_USER,/opt/ptsource/repositories,g" <<<"$SSH_ORIGINAL_COMMAND"`
    elif [[ $SSH_ORIGINAL_COMMAND == */public/* ]] ; then
        new_command=`sed "s,/binary/public,/opt/ptsource/repositories,g" <<<"$SSH_ORIGINAL_COMMAND"`
    fi

	new_command=`sed "s, '/, /,g" <<<"$new_command"`
	new_command=`sed "s,',,g" <<<"$new_command"`
	# echo "New command: $new_command " >> /tmp/sshlog ;

	path_only=`sed "s,binary-upload-pack ',,g" <<<"$SSH_ORIGINAL_COMMAND"` ;
	# echo "repo only: $path_only " >> /tmp/sshlog ;
	path_only=`sed "s,',,g" <<<"$path_only"` ;
	# echo "repo only: $path_only " >> /tmp/sshlog ;

	# echo `printenv` >> /tmp/sshlog ;
	auth_script='/home/ptbinary/ptsource/openssh_auth.php';
	# TODO the below input is risky for original command
    auth_result="php $auth_script $PTGIT_USER $path_only " ;
    # echo "AR command: $auth_result " >> /tmp/sshlog ;
    is_ok=`$auth_result` ;
    # echo "res is: $is_ok " >> /tmp/sshlog ;
	if [ "$is_ok" == "OK" ] ; then
        # echo "res is ok" >> /tmp/sshlog ;
        bash -c "$new_command" ;
        if [[ $SSH_ORIGINAL_COMMAND == binary-receive-pack* ]] ; then
            repo_only=${path_only##*/} ;
            chmod -R 775 /opt/ptsource/repositories/$repo_only ;
            # chown -R ptbinary:ptsource /opt/ptsource/repositories/$repo_only ;
        fi
	    exit 0 ;
	fi
    exit 1 ;
else
	echo "The command you have attempted to run is disabled -"
	echo "Please use only Binary commands"
	exit 1
fi
