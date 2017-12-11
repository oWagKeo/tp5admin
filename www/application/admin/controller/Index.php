<?php
namespace app\admin\controller;

use app\admin\classes\AdminController;

class Index extends AdminController
{
    /**
     * 后台首页
     */
    public function index(){
        $this->assign('userinfo',session('userinfo'));
        $this->assign('menue_list',$this->menue_list());
        return $this->fetch();
    }

    /**
     * 欢迎页
     */
    public function welcome(){
        return $this->fetch();
    }

}
