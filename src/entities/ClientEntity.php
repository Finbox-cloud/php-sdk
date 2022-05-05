<?php

namespace Finbox\Sdk\Entities;

class ClientEntity implements Entity
{
    public $id;
    public $initials;
    public $phone;

    public function __construct(
        $id,
        $initials,
        $phone
    )
    {
        $this->id = $id;
        $this->initials = $initials;
        $this->phone = $phone;
    }
}
