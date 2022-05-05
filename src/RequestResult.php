<?php

namespace Finbox\Sdk\Hash;


class RequestResult
{
    public $success;
    public $errorMessage;
    public $errorCode;
    public $errorData;
    public $data;

    public function __construct(
        bool   $success,
        string $errorMessage = null,
        int    $errorCode = null,
               $errorData = null,
        array  $data = null
    )
    {
        $this->success = $success;
        $this->errorMessage = $errorMessage;
        $this->errorCode = $errorCode;
        $this->errorData = $errorData;
        $this->data = $data;
    }
}
