<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Schema;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $e)
    {
        $log = [
            'code' => $e->getCode(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'message' => $e->getMessage(),
            'params' => json_encode(\Request::all()),
            'path' => \Request::path(),
            'trace' => json_encode($e->getTrace()),
        ];
        if (isset($e->data)) {
            $log['data'] = $e->data;
        }

        if ($e->getMessage()) {
            if (Schema::hasTable('applications')) {
                \App\Models\ErrorLog::updateOrCreate(
                    [
                        'code' => $log['code'],
                        'message' => $log['message'],
                        'file' => $log['file'],
                        'line' => $log['line'],
                        'path' => $log['path'],
                    ],
                    [
                        'params' => $log['params'],
                        'trace' => $log['trace'],
                        'data' => $log['data'] ?? null,
                        'count' => \DB::raw('count+1'),
                    ]
                );
            }
        }

        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }
}
