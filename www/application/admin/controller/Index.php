<?php
namespace app\admin\controller;

class Index extends common
{
    public function index()
    {
       print_r($_POST);
    }

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
    }
}
