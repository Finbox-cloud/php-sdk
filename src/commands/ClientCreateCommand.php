<?php

namespace Finbox\Sdk\Commands;


use Finbox\Sdk\Entities\ClientEntity;
use Finbox\Sdk\Entities\Entity;
use Finbox\Sdk\Entities\InitialsEntity;
use Finbox\Sdk\Types\HttpMethod;

class ClientCreateCommand implements Command
{
    private $apiMethod = '/clients';
    private $httpMethod = HttpMethod::POST;
    private $data;

    public function __construct(
        string $type,
        array  $initials,
        string $phone
    )
    {
        $this->data = [
            'initials' => $initials,
            'phone' => $phone,
            'type' => $type,
        ];
    }

    public function getApiMethod(): string
    {
        return $this->apiMethod;
    }

    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    public function to_array(): array
    {
        return [
            'initials' => $this->data['initials'],
            'phone' => $this->data['phone'],
            'type' => $this->data['type'],
        ];
    }

    public function buildResult(array $data): Entity
    {
        return new ClientEntity(
            $data['id'],
            new InitialsEntity(
                $data['initials']['name'],
                @$data['initials']['surname'],
                @$data['initials']['patronymic']
            ),
            $data['phone']
        );
    }
}
