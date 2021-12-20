<?php
namespace Drupal\vnd;

class Mail
{
    public static function SendMail($module, $messageKey, $recipients, $message, $attachment = null)
    {
        $mailManager = \Drupal::service('plugin.manager.mail');
        $params['message'] = $message;

        if ($attachment)
        {
            global $base_url;
            $params['attachments'][] = [
                'filecontent' => file_get_contents($attachment),
                'filename' => basename($attachment),
                'filemime' => mime_content_type($attachment),
            ];
            $params['headers'] = [
                'Cc' => 'ron.nanko@sanaexpert.de'
            ];
        }
        
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