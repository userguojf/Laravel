<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Log\Log;

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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        $context = [
            'requestUrl'    => $request->getHttpHost() . $request->getRequestUri(),
            'method'        => $request->getMethod(),
            'postParameter' => $request->request->all(),
            'exception'     => $e
        ];
        $response = [
            'msg'  => getenv('APP_ENV') == 'production' ?
                "Internal system error" :
                $e->getMessage(),
            'code' => (empty($code = $e->getCode()) || $code == 0) ?
                10001 :
                $code,
            "data" => getenv('APP_ENV') == 'production' ?
                (object)[] :
                ['file' => $e->getFile(), 'line' => $e->getLine()]
        ];

        if ($this->shouldntReport($e)) {
            return response()->json($response);
        }

//      验参错误
        if ($e instanceof ValidationException) {
            $response['msg'] = $e->getResponse()['msg'];
            return response()->json($response);
        }

//      业务逻辑错误时抛出的异常
        if ($e instanceof ApiException) {
            Log::warning($e->getMessage(), $context, 'api_exception_log');
            $response['msg'] = $e->getMessage();
//            $response['data'] = array_merge((array)$response['data'], (array)$e->getExtra());
            return response()->json($response);
        }

//      服务端逻辑错误时抛出的异常（服务返回的code != 0）
        if ($e instanceof ServiceException) {
            Log::warning($e->getMessage(), $context, 'service_logic_error_log');
            $response['msg'] = $e->getMessage();
            return response()->json($response);
        }

//      请求服务超时抛出的异常（默认连接5s，请求30s）
        if ($e instanceof ConnectException) {
            Log::error($e->getMessage(), $context, 'connect_timeout_log');
            return response()->json($response);
        }

//      请求服务失败抛出的异常
        if ($e instanceof RequestException) {
            Log::error($e->getMessage(), $context, 'request_exception_log');
            return response()->json($response);
        }

//      其他的都是代码有bug导致程序崩溃抛出的异常
        Log::critical(get_class($e), $context, 'default_exception_log');
        return env('APP_DEBUG', false) ? parent::render($request, $e) : response()->json($response);

//        return parent::render($request, $exception);
    }
}
