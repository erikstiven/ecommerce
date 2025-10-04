<?php

namespace App\Enums;

enum ShipmentStatus: int
{
    case Pendiente = 1;            // Pending
    case Completado = 2;           // Completed
    case Fallido = 3;              // Failed

}
