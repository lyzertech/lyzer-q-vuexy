<?php

namespace App\Enums\procurement;

enum PurchaseOrderStatus: string
{
    case DRAFT = 'draft';
    case SENT = 'sent';
    case ACKNOWLEDGED = 'acknowledged';
    case PARTIAL_RECEIVED = 'partial_received';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match($this) {
            self::DRAFT => 'Draft',
            self::SENT => 'Sent to Supplier',
            self::ACKNOWLEDGED => 'Acknowledged',
            self::PARTIAL_RECEIVED => 'Partial Received',
            self::COMPLETED => 'Completed',
            self::CANCELLED => 'Cancelled',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::DRAFT => 'secondary',
            self::SENT => 'primary',
            self::ACKNOWLEDGED => 'info',
            self::PARTIAL_RECEIVED => 'warning',
            self::COMPLETED => 'success',
            self::CANCELLED => 'danger',
        };
    }

    public function canTransitionTo(self $newStatus): bool
    {
        return match($this) {
            self::DRAFT => in_array($newStatus, [self::SENT, self::CANCELLED]),
            self::SENT => in_array($newStatus, [self::ACKNOWLEDGED, self::CANCELLED]),
            self::ACKNOWLEDGED => in_array($newStatus, [self::PARTIAL_RECEIVED, self::COMPLETED, self::CANCELLED]),
            self::PARTIAL_RECEIVED => in_array($newStatus, [self::COMPLETED, self::CANCELLED]),
            self::COMPLETED => false,
            self::CANCELLED => false,
        };
    }

    public function getDescription(): string
    {
        return match($this) {
            self::DRAFT => 'PO is being prepared',
            self::SENT => 'PO has been sent to supplier',
            self::ACKNOWLEDGED => 'Supplier has acknowledged the PO',
            self::PARTIAL_RECEIVED => 'Some items have been received',
            self::COMPLETED => 'All items received and PO is complete',
            self::CANCELLED => 'PO has been cancelled',
        };
    }

    public function isReadOnly(): bool
    {
        return in_array($this, [self::COMPLETED, self::CANCELLED]);
    }

    public function isActive(): bool
    {
        return !$this->isReadOnly();
    }

    public function getIcon(): string
    {
        return match($this) {
            self::DRAFT => 'bx-edit',
            self::SENT => 'bx-send',
            self::ACKNOWLEDGED => 'bx-check',
            self::PARTIAL_RECEIVED => 'bx-package',
            self::COMPLETED => 'bx-check-circle',
            self::CANCELLED => 'bx-x-circle',
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

    public static function getActiveStatuses(): array
    {
        return [
            self::DRAFT,
            self::SENT,
            self::ACKNOWLEDGED,
            self::PARTIAL_RECEIVED
        ];
    }
}