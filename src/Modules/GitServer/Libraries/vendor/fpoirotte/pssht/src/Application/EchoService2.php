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
class EchoService2 implements \fpoirotte\Pssht\Handlers\HandlerInterface
{
    public function __construct(
        \fpoirotte\Pssht\Transport $transport,
        \fpoirotte\Pssht\Connection $connection,
        \fpoirotte\Pssht\Messages\MessageInterface $message
    )
    {
//         $transport->setHandler(\fpoirotte\Pssht\Messages\CHANNEL\DATA::getMessageId(), $this);

//        $message    = \fpoirotte\Pssht\Messages\CHANNEL\DATA::unserialize($decoder);
        $channel    = $message->getChannel();
//        $data = $message->getData() ;
//        $command = $data ;
//
//        $logging = \Plop\Plop::getInstance();
//
//        if (method_exists($message, 'unserialize')) {
//
//            ob_start() ;
//            var_dump($message);
//            $outy = ob_get_clean() ;
//
//            $logging->info("Original command is:  $command, out $outy");
//            $command = str_replace('/git/public/', '/opt/ptsource/repositories/', $command);
//            $logging->info("new command is: $command");
//
//            $cur_git_out = shell_exec($command);
//            //        exec($command, $lines) ;
//            $fl = '/tmp/filey';
//
//            file_put_contents($fl, $cur_git_out, FILE_APPEND) OR DIE("FUCK SAKES 3");
//    //        for ($i=0; $i < count($lines) ; $i++) {
//    //            file_put_contents($fl, $lines[$i], FILE_APPEND) OR DIE("FUCK SAKES 3") ;
//    //        }
//
//            $logging->info("Current Git Output is: " . $cur_git_out);
//
//            $lines = explode(PHP_EOL, $cur_git_out);
//
//            $str = "";
//            for ($i = 0; $i < count($lines) - 1; $i++) {
//    //        for ($i=0; $i < 1 ; $i++) {
//
//                $encLine = $this->pktLineEncode($lines[$i]);
//                $logging->debug("el $i: $encLine ");
//
//    //            $fl = '/tmp/filey' ;
//    //            file_put_contents($fl, $encLine.PHP_EOL, FILE_APPEND) OR DIE("FUCK SAKES 3") ;
//                $str .= $encLine . PHP_EOL;
//
//            }
//            $response = new \fpoirotte\Pssht\Messages\CHANNEL\DATA(
//                $message->getChannel(),
//                $str
//            );
//
//            $transport->writeMessage($response);
//
//            $response = new \fpoirotte\Pssht\Messages\CHANNEL\DATA(
//                $message->getChannel(),
//                '0000' . PHP_EOL
//            );
//
//            file_put_contents($fl, '0000' . PHP_EOL, FILE_APPEND) OR DIE("FUCK SAKES 3");
//            $transport->writeMessage($response);
//
//        }
//
//
//        $logging->info("Sending EOF message");
//        $response   = new \fpoirotte\Pssht\Messages\CHANNEL\EOF(
//            $message->getChannel()
//        );
//        $transport->writeMessage($response);
//
//        /// @FIXME: We shouldn't need to pass values
//        //          for the "type" & "want-replay" fields.
//        $logging->info("Sending EOW message");
//        $response   = new \fpoirotte\Pssht\Messages\CHANNEL\REQUEST\OpensshCom\Eow(
//            $message->getChannel(),
//            "eow@openssh.com",
//            false
//        );
//        $transport->writeMessage($response);

//        $logging->info("Closing the channel");
//        $response   = new \fpoirotte\Pssht\Messages\CHANNEL\CLOSE(
//            $message->getChannel()
//        );
//        $transport->writeMessage($response) ;

//        $logging->info("Sending number back (%s)", array($command));

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
        $response   = new \fpoirotte\Pssht\Messages\CHANNEL\DATA($channel, $message->getData());

////        $message    = \fpoirotte\Pssht\Messages\CHANNEL\DATA::unserialize($decoder);
//        $channel    = $message->getChannel();
//        $data = $message->getData() ;
//        $command = $data ;
//
//        $logging = \Plop\Plop::getInstance();
//
//        if (method_exists($message, 'unserialize')) {
//
//            ob_start() ;
//            var_dump($message);
//            $outy = ob_get_clean() ;
//
//            $logging->info("Original command is:  $command, out $outy");
//            $command = str_replace('/git/public/', '/opt/ptsource/repositories/', $command);
//            $logging->info("new command is: $command");
//
//            $cur_git_out = shell_exec($command);
//            //        exec($command, $lines) ;
//            $fl = '/tmp/filey';
//
//            file_put_contents($fl, $cur_git_out, FILE_APPEND) OR DIE("FUCK SAKES 3");
//            //        for ($i=0; $i < count($lines) ; $i++) {
//            //            file_put_contents($fl, $lines[$i], FILE_APPEND) OR DIE("FUCK SAKES 3") ;
//            //        }
//
//            $logging->info("Current Git Output is: " . $cur_git_out);
//
//            $lines = explode(PHP_EOL, $cur_git_out);
//
//            $str = "";
//            for ($i = 0; $i < count($lines) - 1; $i++) {
//                //        for ($i=0; $i < 1 ; $i++) {
//
//                $encLine = $this->pktLineEncode($lines[$i]);
//                $logging->debug("el $i: $encLine ");
//
//                //            $fl = '/tmp/filey' ;
//                //            file_put_contents($fl, $encLine.PHP_EOL, FILE_APPEND) OR DIE("FUCK SAKES 3") ;
//                $str .= $encLine . PHP_EOL;
//
//            }
//            $response = new \fpoirotte\Pssht\Messages\CHANNEL\DATA(
//                $message->getChannel(),
//                $str
//            );
//
//            $transport->writeMessage($response);
//
//            $response = new \fpoirotte\Pssht\Messages\CHANNEL\DATA(
//                $message->getChannel(),
//                '0000' . PHP_EOL
//            );
//
//            file_put_contents($fl, '0000' . PHP_EOL, FILE_APPEND) OR DIE("FUCK SAKES 3");
//            $transport->writeMessage($response);
//
//        }
//
//
//        $logging->info("Sending EOF message");
//        $response   = new \fpoirotte\Pssht\Messages\CHANNEL\EOF(
//            $message->getChannel()
//        );
//        $transport->writeMessage($response);
//
//        /// @FIXME: We shouldn't need to pass values
//        //          for the "type" & "want-replay" fields.
//        $logging->info("Sending EOW message");
//        $response   = new \fpoirotte\Pssht\Messages\CHANNEL\REQUEST\OpensshCom\Eow(
//            $message->getChannel(),
//            "eow@openssh.com",
//            false
//        );
        $transport->writeMessage($response);
        return true ;
    }


    public function pktLineEncode($string)
    {
        $num = strlen($string) + 4;
        return dechex($num) .' '. $string;
//        return $this->leadingZeroes($num, 4) .' '. $string;
    }

    public function pktLineDecode($string)
    {//        /// @FIXME: We shouldn't need to pass values
//        //          for the "type" & "want-replay" fields.
//        $logging->info("Sending EOW message");
//        $response   = new \fpoirotte\Pssht\Messages\CHANNEL\REQUEST\OpensshCom\Eow(
//            $message->getChannel(),
//            "eow@openssh.com",
//            false
//        );
//        $transport->writeMessage($response);
//
        $length = hexdec(substr($string, 0, 3));
        $pktLineContent = substr($string, 4);

        if ($length - 4 === strlen($pktLineContent))
        {
            return $pktLineContent;
        }
        else
        {
            return false;
        }
    }

    private function leadingZeroes($num, $numlength = 3) {
        // @todo put this numlength in the application configuration of the Client module
        $pref = "" ;
        if (strlen($num) <= $numlength) {
            $diff = $numlength - strlen($num)  ;
            for ($i=0; $i<$diff; $i++) {
                $pref .= "0" ; } }
        $endNum = $pref.$num;
        return $endNum ;
    }

}
