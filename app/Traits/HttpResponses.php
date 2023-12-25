<?php

namespace App\Traits;

trait HttpResponses 
{
    protected function success($data, $code=200)
    {
        return response()->json(["data" => $data], $code);
    }

    protected function error($data, $code)
    {
        return response()->json(["data" => $data], $code);
    }
}