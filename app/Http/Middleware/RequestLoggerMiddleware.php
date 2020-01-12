<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

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
        //\File::prepend(storage_path('logs' . DIRECTORY_SEPARATOR . $filename), $data. "\n" . str_repeat("=", 80) .
        // "\n\n");getOdd
        if (strpos($request->fullUrl(),'insertRunner')==false and strpos($request->fullUrl(),'getOdd')==false){
            DB::table('api_logs')->insert([
                'ip'=>$request->ip(),'header'=>json_encode($request->headers->all()),'url'=>$request->fullUrl(),
                'method'=>$request->method(),'input'=>$request->getContent(),'output'=>$response->getContent(),
                'time'=>gmdate("F j, Y, g:i a"),'duration'=>number_format($end_time - LARAVEL_START, 3)
            ]);
        }

    }
}
