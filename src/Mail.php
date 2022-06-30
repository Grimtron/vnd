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
        /** @var \Drupal\symfony_mailer\EmailFactory */
        $factory = \Drupal::service('email_factory');
        $email = $factory->newModuleEmail('wac', 'safety_box_order'); //, ["module" => 'wac']);
        $email->setVariable("myparam", 555);
        //$email->setParam("myparam", 555);
        //$email->setTo($recipients);
        // $email->setSubject($subject);
        //$email->setBody(['#theme' => $template, "#params" => $mailParameters]);
        return $email->send();
    }

    public static function SendSymfony($module, $subType, $variables, $overrides = [])
    {
        /** @var \Drupal\symfony_mailer\EmailFactory */
        $factory = \Drupal::service('email_factory');

        /** @var \Drupal\symfony_mailer\Email */
        $email = $factory->newModuleEmail($module, $subType);

        if ($variables)
        {
            foreach ($variables as $key => $value)
            {
                $email->setVariable($key, $value);
            }
        }

        if (isset($overrides['to']))
        {
            $displayName = null;

            $langcode = isset($overrides['language']) ? $overrides['language'] : null;
            $account = isset($overrides['account']) ? $overrides['account'] : null;

            $symfonyAddress = new \Drupal\symfony_mailer\Address($overrides['to'], $displayName, $langcode, $account);
            $email->setTo($symfonyAddress);
        }

        $mailSend = $email->send();
        return $mailSend;
    }
}
