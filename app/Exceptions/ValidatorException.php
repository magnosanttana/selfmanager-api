<?php
namespace App\Exceptions;

use Exception;


class ValidatorException  extends Exception
{
    public $httpStatusCode;
    private $messageBag;

    public function __construct($messageBag, $httpCode = 422, $code = 0, Exception $previous = null) {
        $this->httpStatusCode = $httpCode;
        $this->messageBag = $messageBag;
        parent::__construct('Houve um erro de validação', $code, $previous);
    }

    public function getMessageBag()
    {
        return $this->messageBag;
    }
}