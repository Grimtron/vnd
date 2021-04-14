<?php
namespace Drupal\vnd;

class Mail
{
    public static function SendMail($module, $messageKey, $recipients, $message)
    {
        $mailManager = \Drupal::service('plugin.manager.mail');
        $params['message'] = $message;

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
}

?>