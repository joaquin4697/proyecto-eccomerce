<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pendiente = 'pendiente';
    case Pagado = 'pagado';
    case Enviado = 'enviado';
    case Entregado = 'entregado';
    case Cancelado = 'cancelado';

    public function label(): string
    {
        return match ($this) {
            self::Pendiente => 'Pendiente',
            self::Pagado => 'Pagado',
            self::Enviado => 'Enviado',
            self::Entregado => 'Entregado',
            self::Cancelado => 'Cancelado',
        };
    }

    public function canTransitionTo(self $newStatus): bool
    {
        return match ($this) {
            self::Pendiente => in_array($newStatus, [self::Pagado, self::Cancelado]),
            self::Pagado => in_array($newStatus, [self::Enviado, self::Cancelado]),
            self::Enviado => $newStatus === self::Entregado,
            self::Entregado, self::Cancelado => false, // estados finales
        };
    }
}