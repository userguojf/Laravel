<?php
/**
 * Created by PhpStorm.
 * User: wangliangliang
 * Date: 2018/3/7
 * Time: 下午3:59
 */

namespace App\Log;


use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Log
{
    protected static $logInstance;

    protected static $requestId;

    public static function getLogInstance()
    {
        if (null === static::$logInstance) {
            static::$logInstance = new Logger('supply_trade_center');
        }

        return static::$logInstance;
    }

    public static function getRequestId()
    {
        if (null == static::$requestId) {
            static::setRequestId();
        }

        return static::$requestId;
    }

    public static function setRequestId(string $requestId = null)
    {
        static::$requestId = $requestId ?? generateUUID();

    }

    public static function __callStatic($method, $args)
    {
        $logInstance = static::getLogInstance();
        $requestID = static::getRequestId();
        $message = $args[0];
        $context = $args[1] ?? [];
        $path = 'logs/' . ($args[2] ?? 'default') . '/';
        $handler = new StreamHandler(storage_path($path) . date('Y-m-d') . '.log');
        $formatter = "{\"datetime\":\"%datetime%\", \"level_name\":\"%level_name%\", \"request_id\":\"$requestID\", \"message\":\"%message%\", \"context\":%context%, \"extra\":\"%extra%\"}\n";
        $handler->setFormatter(new LineFormatter($formatter, null, true, true));
        $logInstance->pushHandler($handler);
        $logInstance->$method($message, $context);
    }
}