<?php

class FeedbackCommand extends Command {
    function execute(CommandContext $context) {
        $msgSystem = Registry::getMessageSystem();
        $email = $contect->get('email');
        $msg = $context->get('msg');
        $topic = $context->get('topic');
        $result = $msgSystem->send($email, $msg, $topic);
        if( ! result) {
            $context->setError($msgSystem->getError());
            return false;
        }
        return true;
    }
}