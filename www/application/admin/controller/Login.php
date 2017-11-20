<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/20
 * Time: 15:21
 */
namespace app\admin\controller;
use think\Controller;

class Login extends Controller{

    /**
     * 登录
     */
    public function login(){
        $this->view->engine->layout(false);//不加载layout
        return view();
    }

    /**
     * 登录提交
     */
    public function login_action(){
        $where = array();
        $where['name'] = $_POST['username'];
        $where['password'] = md5($_POST['password']);
        $info = db('admin')->where( $where )->find();
        if( empty($info) ){
            $this->error('用户名或者密码错误！',null,'',1);
        }else{
            session('user_log',$info['id']);
            $this->success('登录成功!','admin/Index/index','',1);
        }
    }
}