<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\ResourceCollection;


trait HttpResponses 
{
    protected function success($data, $code=200)
    {
        if($data instanceof \Illuminate\Http\Resources\Json\ResourceCollection)
        {
            // $data = $this->filterData($data);

            $data = $this->sortData($data);
            // $data = $this->paginate($data);
            $data = $this->cacheResponse($data);
            return response()->json(["data" => $data, "code" => $code], $code);
        }else{
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


    public function filterData(ResourceCollection $collection)
    {   
        foreach(request()->query() as $query => $value){
            $attribute = $collection::originalAttribute($query);

            if(isset($attribute, $value)) {
                $collections = $collection->where($attribute, $value);
            }
        };

        return $collections;
    }

    protected function sortData(ResourceCollection $collection)
    {
        if(request()->has('sort_by')){
            $attribute = $collection::originalAttribute(request()->sort_by);

            $collection = $collection->sortBy($attribute);
        }

        return $collection->values();
    }

    protected function paginate(Collection $collection)
    {
        $page = LengthAwarePaginator::resolveCurrentPage();

        $perPage = 15;

        $results = $collection->slice(($page -1) * $perPage, $perPage)->values();

        $paginated = new LengthAwarePaginator($results, $collection->mount(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);

        $paginated->append(request()->all());

        return $paginated;
    }

    protected function cacheResponse($data)
    {
        $url = request()->url();

        $queryParams = request()->query();

        ksort($queryParams);

        $queryString = http_build_query($queryParams);

        $fullUrl = "{$url}?{$queryString}";

        return Cache::remember($fullUrl, 30, function() use ($data){
            return $data;
        });
    }
}