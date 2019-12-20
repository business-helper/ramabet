<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class RequestLoggerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    private $startTime;
    public function handle($request, Closure $next)
    {
        $this->startTime = microtime(true);
        return $next($request);
        //return $next($request);
    }
    public function terminate(Request $request, Response $response)
    {
        $end_time = microtime(true);
        $filename = 'api_datalogger_' . date('d-m-y H') . '.log';
        $data = str_repeat("=", 80). "\n";
        $data .= 'Time: ' . gmdate("F j, Y, g:i a") . "\n";
        $data .= 'Duration: ' . number_format($end_time - LARAVEL_START, 3) . "\n";
        if ($request->ip()=='::1')return;
        $data.= 'Header: ' . json_encode($request->headers->all()) . "\n";
        $data.= 'IP Address: ' . $request->ip() . "\n";
        $data.= 'URL: ' . $request->fullUrl() . "\n";
        $data.= 'Method: ' . $request->method() . "\n";
        $data.= 'Input: ' . $request->getContent() . "\n";
        $data.= 'Output: ' . $response->getContent() . "\n";
        \File::prepend(storage_path('logs' . DIRECTORY_SEPARATOR . $filename), $data. "\n" . str_repeat("=", 80) . "\n\n");
    }
}
