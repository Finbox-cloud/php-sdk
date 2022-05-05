<?php

namespace Finbox\Sdk;

use Finbox\Sdk\Commands\Command;
use Finbox\Sdk\Request\Request;


class Finbox
{
    private $request;
    private $apiUrl = 'https://api.fnbox.ru';

    function __construct(string $token, string $secret, string $apiUrl = null)
    {
        if ($apiUrl) {
            $this->apiUrl = $apiUrl;
        }

        $this->request = new Request(
            $this->apiUrl,
            $token,
            $secret
        );
    }

    public function send(Command $command): Result
    {
        $response = $this->request->make($command);
        return new Result(
            $command,
            $response->success,
            $response->errorMessage,
            $response->errorCode,
            $response->errorData,
            $response->success ? $command->buildResult($response->data) : null
        );
    }
}
