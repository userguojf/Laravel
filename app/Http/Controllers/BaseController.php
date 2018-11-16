<?php
/**
 * Created by PhpStorm.
 * User: guojianfeng
 * Date: 2018/11/16
 * Time: 下午5:33
 */

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
// added by guojf
use Illuminate\Routing\Controller as BaseBaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
// added by guojf
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BaseController extends BaseBaseController
{
    // added by guojf
    // ValidatesRequests $this->validate();
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // added by guojf
    public function failed(string $msg = 'failed', array $data = [], int $code = 400)
    {
        return $this->success($data, $msg, $code);
    }

    public function success(array $data = [], string $msg = 'success', int $code = 0)
    {
        $responseData = [
            'code' => (Int)$code,
            'msg'  => (String)$msg,
            'data' => (Object)$data
        ];
        return response()->json($responseData);
    }

    protected function throwValidationException(Request $request, $validator)
    {
        $response = [
            'code' => 20001,
            'msg'  => $validator->errors()->first(),
            'data' => []
        ];
        throw new ValidationException($validator, response()->json($response));
    }
}
