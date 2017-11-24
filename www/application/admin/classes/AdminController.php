<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/20
 * Time: 16:50
 */
namespace app\admin\classes;
use think\Controller;

class AdminController extends Controller{

    protected $auth,$is_submenu,$menu_type;
    public function __construct() {
        parent::__construct();
        if(!$this->check_login()){
            $this->redirect('admin/Login/login');
            exit;
        }
    }
    /**
     * 菜单列表
     */
    public function menue_list(){
        $menue = array(
            'admin'=>[
                'name'=>'管理员管理',
                'icon'=>'&#xe726',
                'sub_menue'=>[
                    'admin_list' => ['name'=>'管理员列表','controller'=>'Administration','fun'=>'admin_list'],
                    'admin_add'  => ['name'=>'添加管理员','controller'=>'Administration','fun'=>'admin_add'],
                    'pre_class'  => ['name'=>'权限分类','controller'=>'Administration','fun'=>'pre_class'],
                    'admin_pre'  => ['name'=>'权限管理','controller'=>'Administration','fun'=>'admin_pre'],
                ]
            ],
            'user'=>[
                'name'=>'用户管理',
                'icon'=>'&#xe6b8',
                'sub_menue'=>[
                    'user_list' => ['name'=>'会员列表','controller'=>'User','fun'=>'user_list'],
                    'user_add'  => ['name'=>'添加会员','controller'=>'User','fun'=>'user_add']
                ]
            ]
        );
        return $menue;
    }
    /*
    * 验证用户是否登陆
    */
    final protected function check_login()
    {
        return session("userinfo")?true:false;
    }
    function my_error($error,$jumpUrl,$waitSecond=3,$type=1)
    {
        require ('Public/tpl/error.htm');
    }
    function my_success($message,$jumpUrl,$waitSecond=3,$close=1)
    {
        require ('Public/tpl/success.htm');
    }
    function tip($info,$waitSecond=3)
    {
        require ('Public/tpl/tip.htm');
    }

}