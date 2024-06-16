<?php

namespace App\Enums;

enum TakedownStatus
{
    case PENDING;
    case PROCESSING;
    case ACCEPTED;
    case REJECTED;

    public static function toArray(): array
    {
        return ["PENDING", "PROCESSING", "ACCEPTED", "REJECTED"];
    }

    public function asValue(): string
    {
        return match ($this) {
            TakedownStatus::ACCEPTED => 'ACCEPTED',
            TakedownStatus::PENDING => 'PENDING',
            TakedownStatus::PROCESSING => 'PROCESSING',
            TakedownStatus::REJECTED => 'REJECTED'
        };
    }
}
