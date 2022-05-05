<?php

namespace Finbox\Sdk\Commands;

use Finbox\Sdk\Entities\Entity;

interface Command
{
    public function to_array(): array;

    public function getApiMethod(): string;

    public function getHttpMethod(): string;

    public function buildResult(array $data): Entity;
}
