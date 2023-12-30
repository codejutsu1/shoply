<?php

namespace App\Traits;

use Illuminate\Http\Resources\Json\ResourceCollection;


trait HttpResponses 
{
    protected function success($data, $code=200)
    {
        if($data instanceof \Illuminate\Http\Resources\Json\ResourceCollection)
        {
            return response()->json(["data" => $this->sortData($data), "code" => $code], $code);
        }else {
            return response()->json(["data" => $data, "code" => $code], $code);
        }
    }

    protected function error($error, $code)
    {
        return response()->json(["error" => $error, "code" => $code], $code);
    }

    protected function message($message, $code=200)
    {
        return response()->json(["message" => $message, "code" => $code], $code);
    }

    protected function sortData(ResourceCollection $collection)
    {
        if(request()->has('sort_by')){
            $attribute = $collection::originalAttribute(request()->sort_by);

            $new_collection = $collection->sortBy($attribute);
        }

        return $new_collection->values()->all();
    }
}