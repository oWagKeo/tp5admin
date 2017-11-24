<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/21
 * Time: 11:18
 */
namespace app\admin\classes;

use think\Controller;
use think\captcha\Captcha;

class ApiController extends Controller{

    /**
     * 验证码
     */
    public function verify(){
        $config = [
            'codeSet'  => '2345678abcdefhijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXY',
            'imageH'   => 80,
            'imageW'   => 200,
            'fontttf'  => '5.ttf',
            'length'   => 4
        ];
        $v = new Captcha($config);
        return $v->entry();
    }

    /**
     * @param $code
     * @param string $id
     * @return bool
     * 验证验证码
     */
    public function check_verify($code, $id = ''){
        $captcha = new Captcha();
        return $captcha->check($code, $id);
    }
}