<?php

namespace App\Enums;

enum TypeOfDocuments: int
{
    case CEDULA = 1;
    case RUC = 2;
    case PASAPORTE = 3;
    case VISA = 4;
    case OTRO = 5;

}
