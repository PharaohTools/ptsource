#!/usr/bin/env bash

echo "Original command: " + $SSH_ORIGINAL_COMMAND >> /tmp/sshlog ;
echo "ptgit key var: " + $PTGIT_KEY >> /tmp/sshlog ;
echo "ptgit user var: " + $PTGIT_USER >> /tmp/sshlog ;
# echo $SSH_ORIGINAL_COMMAND ;

if [[ $SSH_ORIGINAL_COMMAND == git-upload-pack* ]] || [[ $SSH_ORIGINAL_COMMAND == git-recieve-pack* ]] ; then

    if [[ $SSH_ORIGINAL_COMMAND == */$PTGIT_USER/* ]] ; then
        new_command=`sed "s,/git/$PTGIT_USER,/opt/ptsource/repositories,g" <<<"$SSH_ORIGINAL_COMMAND"`
    elif [[ $SSH_ORIGINAL_COMMAND == */public/* ]] ; then
        new_command=`sed "s,/git/public,/opt/ptsource/repositories,g" <<<"$SSH_ORIGINAL_COMMAND"`
    fi

	new_command=`sed "s, '/, /,g" <<<"$new_command"`
	new_command=`sed "s,',,g" <<<"$new_command"`
	echo "New command: $new_command " >> /tmp/sshlog ;

	repo_only=`sed "s,git-upload-pack ',,g" <<<"$SSH_ORIGINAL_COMMAND"` ;
	echo "repo only: $repo_only " >> /tmp/sshlog ;
	repo_only=`sed "s,',,g" <<<"$repo_only"` ;
	echo "repo only: $repo_only " >> /tmp/sshlog ;

	echo `printenv` >> /tmp/sshlog ;
	auth_script='/home/ptgit/ptsource/openssh_auth.php';
	# TODO the below input is risky for original command
    auth_result="php $auth_script $PTGIT_USER $repo_only " ;
    echo "AR command: $auth_result " >> /tmp/sshlog ;
    is_ok=`$auth_result` ;
    echo "res is: $is_ok " >> /tmp/sshlog ;
	if [ "$is_ok" == "OK" ] ; then
        echo "res is ok" >> /tmp/sshlog ;
        bash -c "$new_command" ;
	    exit 0 ;
	fi
    exit 1 ;
else
	echo "The command you have attempted to run is disabled -"
	echo "Please use only Git commands"
	exit 1
fi
