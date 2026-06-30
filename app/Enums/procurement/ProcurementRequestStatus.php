<?php

namespace App\Enums\procurement;

enum ProcurementRequestStatus: string
{
    case DRAFT = 'draft';
    case WAITING_APPROVAL = 'waiting_approval';
    case APPROVED = 'approved';
    case PURCHASING = 'purchasing';
    case SHIPPING = 'shipping';
    case PARTIAL_ARRIVAL = 'partial_arrival';
    case ARRIVAL = 'arrival';
    case DELIVERED = 'delivered';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match($this) {
            self::DRAFT => 'Draft',
            self::WAITING_APPROVAL => 'Waiting Approval',
            self::APPROVED => 'Approved',
            self::PURCHASING => 'Purchasing',
            self::SHIPPING => 'Shipping',
            self::PARTIAL_ARRIVAL => 'Partial Arrival',
            self::ARRIVAL => 'Arrival',
            self::DELIVERED => 'Delivered',
            self::COMPLETED => 'Completed',
            self::CANCELLED => 'Cancelled',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::DRAFT => 'secondary',
            self::WAITING_APPROVAL => 'warning',
            self::APPROVED => 'info',
            self::PURCHASING => 'primary',
            self::SHIPPING => 'primary',
            self::PARTIAL_ARRIVAL => 'warning',
            self::ARRIVAL => 'info',
            self::DELIVERED => 'success',
            self::COMPLETED => 'success',
            self::CANCELLED => 'danger',
        };
    }

    public function isReadOnly(): bool
    {
        return in_array($this, [self::COMPLETED, self::CANCELLED]);
    }

    public function canTransitionTo(self $newStatus): bool
    {
        return match($this) {
            self::DRAFT => in_array($newStatus, [self::WAITING_APPROVAL, self::CANCELLED]),
            self::WAITING_APPROVAL => in_array($newStatus, [self::APPROVED, self::DRAFT, self::CANCELLED]),
            self::APPROVED => in_array($newStatus, [self::PURCHASING, self::CANCELLED]),
            self::PURCHASING => in_array($newStatus, [self::SHIPPING, self::CANCELLED]),
            self::SHIPPING => in_array($newStatus, [self::PARTIAL_ARRIVAL, self::ARRIVAL, self::CANCELLED]),
            self::PARTIAL_ARRIVAL => in_array($newStatus, [self::ARRIVAL, self::CANCELLED]),
            self::ARRIVAL => in_array($newStatus, [self::DELIVERED]),
            self::DELIVERED => in_array($newStatus, [self::COMPLETED]),
            self::COMPLETED => false,
            self::CANCELLED => false,
        };
    }

    public function getDescription(): string
    {
        return match($this) {
            self::DRAFT => 'Request is being prepared',
            self::WAITING_APPROVAL => 'Waiting for manager approval',
            self::APPROVED => 'Approved and ready for procurement',
            self::PURCHASING => 'Procurement team is processing',
            self::SHIPPING => 'Items are being shipped',
            self::PARTIAL_ARRIVAL => 'Some items have arrived',
            self::ARRIVAL => 'All items have arrived',
            self::DELIVERED => 'Items delivered to customer',
            self::COMPLETED => 'Request completed successfully',
            self::CANCELLED => 'Request has been cancelled',
        };
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