<?php

namespace App\Core\Http\Middleware;

use App\Core\Support\CorrelationId;
use Closure;
use Illuminate\Http\Request;

class SetCorrelationId
{
    public function __construct(
        private readonly CorrelationId $correlationId
    ) {}

    public function handle(Request $request, Closure $next)
    {
        $id = $request->header('X-Correlation-ID');
        $this->correlationId->set($id);

        $response = $next($request);

        $response->headers->set('X-Correlation-ID', $this->correlationId->get());

        return $response;
    }
}
