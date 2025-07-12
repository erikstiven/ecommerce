<?php

namespace App\Observers;

use App\Models\Cover;

class CoverObserver
{
    //verifica si se creo una nueva portada
    public function creating(Cover $cover){

        $cover-> order = Cover::max('order') + 1;

    }
}
