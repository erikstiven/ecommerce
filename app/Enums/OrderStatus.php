<?php

namespace App\Enums;

enum    OrderStatus: int
{
    case Pendiente = 1;            // Pending
    case EsperandoAprobacion = 2;  // PendingApproval (para pagos por transferencia)
    case Procesando = 3;           // Processing
    case Enviado = 4;              // Shipped
    case Completado = 5;           // Completed
    case Cancelado = 6;            // Cancelled
    case Fallido = 7;              // Failed
    case Reembolsado = 8;          // Refunded

}
