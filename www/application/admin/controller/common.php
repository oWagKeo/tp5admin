<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/17
 * Time: 16:22
 */

namespace app\admin\controller;
use think\Controller;

class common extends Controller
{
   public function _initialize()
   {
      if( !session('user_log') ){
         $this->error('请登录！','admin/login/login','',1);
      }
   }

}