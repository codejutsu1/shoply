<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class TransformInputMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $collection): Response
    {
        $transformedInput = [];

        foreach($request->all() as $input => $value){
            $transformedInput[$collection::originalAttribute($input)] = $value;
        }

        $request->replace($transformedInput);

        $response = $next($request);

        if(isset($response->exception) && $response->exception instanceof ValidationException){
            $data = $response->getData();

            $transformedError = [];

            foreach($data->errors as $field => $error){
                $transformedField = $collection::transformedAttribute($field);

                $transformedError[$transformedField] = str_replace($field, $transformedField, $error);
            }

            $data->errors = $transformedError;
            
            $response->setData($data);
        }

        return $response;
    }
}
