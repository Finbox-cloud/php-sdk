<?php

namespace Finbox\Sdk\Entities;

class InitialsEntity implements Entity
{
    public $name;
    public $surname;
    public $patronymic;

    public function __construct(
        $name,
        $surname,
        $patronymic
    )
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->patronymic = $patronymic;
    }
}
