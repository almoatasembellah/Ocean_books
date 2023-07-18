<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OwnCors
{

    public function handle(Request $request, Closure $next): Response
    {
//        header("Access-Control-Allow-Origin: *");

        $headers = [
            "Access-Control-Allow-Origin" => "*",
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers' => 'Content-Type, X-Auth-Token, Origin, Authorization'
        ];
        if ($request->getMethod() == "OPTIONS") {
            return response('OK')
                ->withHeaders($headers);
        }

        $response = $next($request);
        foreach ($headers as $key => $value)
            $response->header($key, $value);
        return $response;
    }
    }

