<?php
namespace app\admin\controller;

class Index extends common
{

    /**
     * 后台首页
     */
    public function index()
    {
        return $this->fetch();
    }

}
