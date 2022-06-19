<?php

namespace Drupal\vnd;

class Mail
{
    public static function SendMail($module, $messageKey, $recipients, $message)
    {
        $mailManager = \Drupal::service('plugin.manager.mail');
        $params['message'] = $message;
        $params['myParameter'] = "mein wert";
        $params['[myParameter]'] = "mein wert 2";

        $langcode = "en";
        $send = true;

        if (!is_array($recipients))
        {
            $recipients = [$recipients];
        }

        $results = [];
        foreach ($recipients as $recipient)
        {
            $results[$recipient] = $mailManager->mail($module, $messageKey, $recipient, $langcode, $params, NULL, $send);
        }

        return $results;
    }

    public static function SendMailSymfony($template, $recipients, $subject, $mailParameters)
    {
        $factory = \Drupal::service('email_factory');
        $email = $factory->newModuleEmail('wac', 'default');
        $email->setTo($recipients);
        $email->setSubject($subject);
        $email->setBody(['#theme' => $template, "#params" => $mailParameters]);
        return $email->send();
    }
}
