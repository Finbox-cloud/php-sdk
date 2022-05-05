<?php

namespace Finbox\Sdk\Commands;


use Finbox\Sdk\Entities\ClientEntity;
use Finbox\Sdk\Entities\Entity;
use Finbox\Sdk\Entities\InitialsEntity;
use Finbox\Sdk\Types\HttpMethod;

class ClientGetCommand implements Command
{
    private $apiMethod = '/clients';
    private $httpMethod = HttpMethod::GET;
    private $clientId;

    public function __construct(
        string $clientId
    )
    {
        $this->clientId = $clientId;
    }

    public function getApiMethod(): string
    {
        return $this->apiMethod . '/' . $this->clientId;
    }

    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    public function to_array(): array
    {
        return [];
    }

    public function buildResult(array $data): Entity
    {
        return new ClientEntity(
            $data['id'],
            new InitialsEntity(
                $data['initials']['name'],
                $data['initials']['surname'],
                $data['initials']['patronymic']
            ),
            $data['phone']
        );
    }
}
