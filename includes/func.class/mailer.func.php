<?php

function sendMail($to, $message, $subject) {
    global $app;
    $mailsetting = unserialize(getSetting("mail"));
    if ($mailsetting != "") {
        $message = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom(array($mailsetting["uname"] => $mailsetting["sender"]))
                ->setTo(array($to))
                ->setBody($message, 'text/html');
        $app['mailer']->send($message);
    }
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

