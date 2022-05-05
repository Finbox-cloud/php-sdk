<?php

namespace Finbox\Sdk;

use Finbox\Sdk\Commands\Command;
use Finbox\Sdk\Entities\ClientEntity;
use Finbox\Sdk\Entities\Entity;

class Result
{
    private $result;

    public $success;
    public $errorMessage;
    public $errorCode;
    public $errorData;
    public $command;

    public function __construct(
        Command $command,
        bool    $success,
        string  $errorMessage = null,
        int     $errorCode = null,
                $errorData = null,
        Entity  $entity = null
    )
    {
        $this->success = $success;
        $this->errorMessage = $errorMessage;
        $this->errorCode = $errorCode;
        $this->errorData = $errorData;
        $this->result = $entity;
        $this->command = $command;
    }


    public function getResult(): ClientEntity
    {
        return $this->result;
    }
}
