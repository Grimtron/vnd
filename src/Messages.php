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
        if ($result['status'])
        {
            \Drupal::messenger()->addMessage($result['message']);
        }
        else
        {
            \Drupal::messenger()->addError($result['message']);
        }
    }
}
?>