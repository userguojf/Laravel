<?php

if (!function_exists("generateUUID")) {
    function generateUUID(string $prefix = ''): string
    {
        return $prefix . substr(md5(uniqid()), 8, 16);
    }
}

if (!function_exists('createOrderId')) {
    function createOrderId($prefix='OF'): string
    {
        list($usec, $sec) = explode(" ", microtime());
        $time = date('YmdHis') .substr($usec, 2, 3) . str_pad(mt_rand(0,1000),4,'0', STR_PAD_LEFT);
        return strtoupper(substr($prefix. $time ,0,25));
    }

}

if (!function_exists("parseOrderBy")) {
    function parseOrderBy(): array
    {
        return [
            '1'     => ['column' =>'create_time', 'sort' => 'DESC'],
            '2'     => ['column' =>'accept_time','sort' => 'DESC'],
            '3'     => ['column' =>'pay_time','sort' => 'DESC'],
            '4'     => ['column' =>'delivery_time','sort' => 'DESC'],
            '5'     => ['column' =>'sign_time','sort' => 'DESC'],
            '6'     => ['column' =>'rejected_time','sort' => 'DESC'],
            '7'     => ['column' =>'delivery_failde_time','sort' => 'DESC'],
            '8'     => ['column' =>'refund_time','sort' => 'DESC'],
            '9'     => ['column' =>'cancel_time','sort' => 'DESC'],
            '10'    => ['column' =>'trigger_time','sort' => 'DESC'],
            '11'    => ['column' =>'update_time','sort' => 'DESC'],
        ];
    }
}

if (!function_exists('createSettleOrderId')) {
    function createSettleOrderId($prefix = 'SE'): string
    {
        $time = substr(time(), 1, 9) . str_pad(mt_rand(0,99999), 5, '0', STR_PAD_LEFT);
        return strtoupper(substr($prefix. $time ,0,16));
    }
}

if (!function_exists('createWarehouseOrderId')) {
    function createWarehouseOrderId($prefix = 'WO'): string
    {
        $time = substr(time(), 1, 9) . str_pad(mt_rand(0,99999), 5, '0', STR_PAD_LEFT);
        return strtoupper(substr($prefix. $time ,0,16));
    }
}