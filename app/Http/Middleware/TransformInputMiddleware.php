<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;

class TransformInputMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $transformer): Response
    {
        // echo '<pre>';
        // var_dump($request->files->all());
        // echo '</pre>';
        // die;
        
        $transformerInput = [];

        $allFields = $request->all();
        $queryParams = $request->query();

        $transformableFields = array_diff($allFields, $queryParams);

        foreach($transformableFields as $input => $value) {
            $transformerInput[$transformer::originalAttribute($input)] = $value;
        }

        $request->replace($transformerInput);
        $response = $next($request);

        if (isset($response->exception) && $response->exception instanceof ValidationException) {
            $data = $response->getData();
            $transformedErrors = [];
            foreach ($data->error as $field => $error) {
                $transformedField = $transformer::transformedAttribute($field);
                $transformedErrors[$transformedField] = str_replace($field, $transformedField, $error);
            }
            $data->error = $transformedErrors;
            $response->setData($data);
        }
        return $response;
    }
}
