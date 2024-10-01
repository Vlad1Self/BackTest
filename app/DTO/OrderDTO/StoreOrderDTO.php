<?php

namespace App\DTO\OrderDTO;

use Spatie\DataTransferObject\DataTransferObject;

class StoreOrderDTO extends DataTransferObject
{
    public int $user_id;
    public array $items;
}
