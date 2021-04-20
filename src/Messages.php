<?php
namespace Drupal\vnd;

use Drupal\Core\DependencyInjection\ContainerNotInitializedException;
use Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class Messages
{
    /**
     * Zeigt eine Drupal-Message an, basierend auf einem assoziativen Array bestehend aus den Keys 'status' und 'message'.
     * Wenn status true ist, wird die Message als Erfolgsmitteilung gemeldet, sonst als Fehler.
     * 
     * @param mixed $result 
     * @return void 
     * @throws ContainerNotInitializedException 
     * @throws ServiceCircularReferenceException 
     * @throws ServiceNotFoundException 
     */
    public static function showResultMessage($result)
    {
        $messageObject = null;

        if (is_array($result))
        {
            $messageObject = new \Drupal\vnd\Model\ResultMessage();
            $messageObject->Message = $result['message'];
            $messageObject->Status = $result['status'] ? \Drupal\vnd\Model\ResultMessage::STATUS_OK : \Drupal\vnd\Model\ResultMessage::STATUS_ERROR;
        }
        else
        {
            /** @var \Drupal\vnd\Model\ResultMessage $messageObject */
            $messageObject = $result;
        }
        
        if ($messageObject->IsOk())
        {
            \Drupal::messenger()->addMessage($messageObject->Message);
        }
        else
        {
            \Drupal::messenger()->addError($messageObject->Message);
        }
    }

    public static function showErrorMessage($message)
    {
        self::showResultMessage(\Drupal\vnd\Model\ResultMessage::CreateErrorMessage($message));
    }

    public static function showSuccessMessage($message)
    {
        self::showResultMessage(\Drupal\vnd\Model\ResultMessage::CreateSuccessMessage($message));
    }
}
?>