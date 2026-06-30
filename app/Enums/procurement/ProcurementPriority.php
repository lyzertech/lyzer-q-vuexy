<?php

namespace App\Enums\procurement;

enum ProcurementPriority: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
    case URGENT = 'urgent';

    public function label(): string
    {
        return match($this) {
            self::LOW => 'Low',
            self::MEDIUM => 'Medium',
            self::HIGH => 'High',
            self::URGENT => 'Urgent',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::LOW => 'success',
            self::MEDIUM => 'info',
            self::HIGH => 'warning',
            self::URGENT => 'danger',
        };
    }

    public function getDescription(): string
    {
        return match($this) {
            self::LOW => 'Standard processing time',
            self::MEDIUM => 'Normal priority request',
            self::HIGH => 'Expedited processing required',
            self::URGENT => 'Critical - immediate attention required',
        };
    }

    public function getSortOrder(): int
    {
        return match($this) {
            self::URGENT => 1,
            self::HIGH => 2,
            self::MEDIUM => 3,
            self::LOW => 4,
        };
    }

    public function getIcon(): string
    {
        return match($this) {
            self::LOW => 'bx-down-arrow-alt',
            self::MEDIUM => 'bx-minus',
            self::HIGH => 'bx-up-arrow-alt',
            self::URGENT => 'bx-error-circle',
        };
    }

    public static function getSelectOptions(): array
    {
        $options = [];
        foreach (self::cases() as $priority) {
            $options[$priority->value] = $priority->label();
        }
        return $options;
    }

    public static function getHighPriorities(): array
    {
        return [self::HIGH, self::URGENT];
    }

    public static function sortByPriority($items, $column = 'priority')
    {
        return $items->sortBy(function ($item) use ($column) {
            return self::from($item->$column)->getSortOrder();
        });
    }
}