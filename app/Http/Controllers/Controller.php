<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function success($data = '')
    {
        if (is_a($data, 'Illuminate\Database\Eloquent\Collection')) {
            return response()->json(['success' => true, 'data' => $data]);
        } else {
            return response()->json(['success' => true, 'data' => $data]);
        }
    }

    public function error($msg = '')
    {
        return response()->json(['success' => false, 'message' => $msg], 400);
    }
}
