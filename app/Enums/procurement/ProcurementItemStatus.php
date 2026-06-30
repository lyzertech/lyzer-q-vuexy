<?php

namespace App\Enums\procurement;

enum ProcurementItemStatus: string
{
    case REQUESTED = 'requested';
    case ORDERED = 'ordered';
    case PRODUCTION = 'production';
    case SHIPPING = 'shipping';
    case PARTIAL_ARRIVAL = 'partial_arrival';
    case ARRIVAL = 'arrival';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match($this) {
            self::REQUESTED => 'Requested',
            self::ORDERED => 'Ordered',
            self::PRODUCTION => 'In Production',
            self::SHIPPING => 'Shipping',
            self::PARTIAL_ARRIVAL => 'Partial Arrival',
            self::ARRIVAL => 'Arrived',
            self::DELIVERED => 'Delivered',
            self::CANCELLED => 'Cancelled',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::REQUESTED => 'secondary',
            self::ORDERED => 'primary',
            self::PRODUCTION => 'info',
            self::SHIPPING => 'primary',
            self::PARTIAL_ARRIVAL => 'warning',
            self::ARRIVAL => 'info',
            self::DELIVERED => 'success',
            self::CANCELLED => 'danger',
        };
    }

    public function canTransitionTo(self $newStatus): bool
    {
        return match($this) {
            self::REQUESTED => in_array($newStatus, [self::ORDERED, self::CANCELLED]),
            self::ORDERED => in_array($newStatus, [self::PRODUCTION, self::CANCELLED]),
            self::PRODUCTION => in_array($newStatus, [self::SHIPPING, self::CANCELLED]),
            self::SHIPPING => in_array($newStatus, [self::PARTIAL_ARRIVAL, self::ARRIVAL, self::CANCELLED]),
            self::PARTIAL_ARRIVAL => in_array($newStatus, [self::ARRIVAL, self::CANCELLED]),
            self::ARRIVAL => in_array($newStatus, [self::DELIVERED]),
            self::DELIVERED => false,
            self::CANCELLED => false,
        };
    }

    public function getDescription(): string
    {
        return match($this) {
            self::REQUESTED => 'Item has been requested',
            self::ORDERED => 'Purchase order has been created',
            self::PRODUCTION => 'Item is in production',
            self::SHIPPING => 'Item is being shipped',
            self::PARTIAL_ARRIVAL => 'Some quantity has arrived',
            self::ARRIVAL => 'Full quantity has arrived',
            self::DELIVERED => 'Item delivered to customer',
            self::CANCELLED => 'Item request cancelled',
        };
    }

    public function isComplete(): bool
    {
        return in_array($this, [self::DELIVERED, self::CANCELLED]);
    }

    public function isInProgress(): bool
    {
        return in_array($this, [
            self::ORDERED, 
            self::PRODUCTION, 
            self::SHIPPING, 
            self::PARTIAL_ARRIVAL
        ]);
    }

    public static function getSelectOptions(): array
    {
        $options = [];
        foreach (self::cases() as $status) {
            $options[$status->value] = $status->label();
        }
        return $options;
    }
}