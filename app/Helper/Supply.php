<?php
/**
 * Created by PhpStorm.
 * User: wangliangliang
 * Date: 2018/9/11
 * Time: 16:19
 */
namespace App\Helper;

use App\Models\SupplyLogModel;
use Amqp;

trait SupplyMethods
{
    public static function saveLog(array $orderInfo):bool
    {
        return SupplyLogModel::insert([
            'purchase_no'  => $orderInfo['purchase_no'],
            'trade_status' => $orderInfo['trade_status'],
            'operator'     => $orderInfo['operator_id'],
            'comment'      => $orderInfo['comment']
        ]);
    }

    public static function initializationMessage(int $opType, string $opDesc, array $skuList)
    {
        $message = [
            'op_type' => $opType,
            'op_desc' => $opDesc,
            'sku_list' => $skuList
        ];

        Amqp::publish(
            'Ofashion_queue_warehouseStock',
            json_encode($message),
            ['exchange' => 'amq.topic', 'exchange_type' => 'topic', 'queue' => 'Ofashion_queue_warehouseStock']
        );
    }

}