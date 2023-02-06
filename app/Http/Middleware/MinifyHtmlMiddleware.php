<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MinifyHtmlMiddleware {
    public function handle(Request $request, Closure $next): mixed {
        $response = $next($request);

        if (Response::HTTP_OK === $response->getStatusCode()) {
            $output = minifyHtml($response->getContent());
            $response->setContent($output);
        }

        return $response;
    }
}
