<?php
namespace Drupal\vnd\Model;

class ResultMessage
{
    public const STATUS_ERROR = 'error';
    public const STATUS_OK = 'ok';

    public $Status;
    public $Message;

    public function isOk()
    {
        return $this->Status == self::STATUS_OK;
    }

    public static function createErrorMessage($message)
    {
        $newMessage = new ResultMessage();
        $newMessage->Status = self::STATUS_ERROR;
        $newMessage->Message = $message;

        return $newMessage;
    }

    public static function createSuccessMessage($message)
    {
        $newMessage = new ResultMessage();
        $newMessage->Status = self::STATUS_OK;
        $newMessage->Message = $message;
        return $newMessage;
    }
}
?>