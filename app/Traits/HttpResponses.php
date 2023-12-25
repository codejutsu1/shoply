<?php

namespace App\Traits;

trait HttpResponses 
{
    protected function success($data, $code=200)
    {
        return response()->json(["data" => $data, "code" => $code], $code);
    }

    protected function error($error, $code)
    {
        return response()->json(["error" => $error, "code" => $code], $code);
    }
}