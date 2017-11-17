<?php
namespace app\admin\controller;

class Index extends common
{
    public function index()
    {
       return $this->fetch();
    }

    /**
     * 登录
     */
    public function login(){

        return $this->fetch('login');
    }
}
