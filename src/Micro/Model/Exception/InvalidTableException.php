<?php
namespace Bilan\Micro\Model\Exceptions;

class InvalidTableException extends \Exception
{
    public function __construct($message = 'Table can not be null.')
    {
        parent::__construct();
    }
}