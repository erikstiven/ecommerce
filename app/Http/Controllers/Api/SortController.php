<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cover;

class SortController extends Controller
{
    public function covers(Request $request)
    {

        $ids = $request->get('sorts'); // ['3', '2', '1', ...]

        foreach ($ids as $index => $id) {
            Cover::where('id', $id)->update(['order' => $index + 1]);
        }
    }
}
