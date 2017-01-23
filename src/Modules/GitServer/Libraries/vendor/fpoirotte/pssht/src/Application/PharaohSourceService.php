<?php
/*
* This file is part of pssht.
*
* (c) François Poirotte <clicky@erebot.net>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace fpoirotte\Pssht\Application;

/**
 * A sample application that acts like an echo server,
 * sending back whatever message it is fed with.
 */
class PharaohSourceService implements \fpoirotte\Pssht\Handlers\HandlerInterface
{
    public function __construct(
        \fpoirotte\Pssht\Transport $transport,
        \fpoirotte\Pssht\Connection $connection,
        \fpoirotte\Pssht\Messages\MessageInterface $message
    ) {
        $transport->setHandler(\fpoirotte\Pssht\Messages\CHANNEL\DATA::getMessageId(), $this);
    }

    // SSH_MSG_CHANNEL_DATA = 94
    public function handle(
        $msgType,
        \fpoirotte\Pssht\Wire\Decoder $decoder,
        \fpoirotte\Pssht\Transport $transport,
        array &$context
    ) {
        $message    = \fpoirotte\Pssht\Messages\CHANNEL\DATA::unserialize($decoder);
        $channel    = $message->getChannel();
        $data = $message->getData() ;

        $logging = \Plop\Plop::getInstance();

        $command = $message->getData() ;
        $logging->info("Original command is: $command") ;
        $command = str_replace('/git/public/', '/opt/ptsource/repositories/', $command) ;
        $logging->info("new command is: $command") ;

        $fl = '/tmp/filey' ;
        touch($fl) OR DIE("FUCK SAKES 1") ;
        chmod($fl, 0777) OR DIE("FUCK SAKES 2") ;
        file_put_contents($fl, $data, FILE_APPEND) OR DIE("FUCK SAKES 3") ;
        $response   = new \fpoirotte\Pssht\Messages\CHANNEL\DATA($channel, $data);



//        $gsf = new \Model\GitServer();
//        $gs = $gsf->getModel($this->params, "ServerFunctions") ;
//        $gs->serveGit() ;



        $transport->writeMessage($response);
        return true;
    }
}
