<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/22
 * Time: 11:43
 */
namespace app\admin\controller;

use app\admin\classes\AdminController;
use think\Validate;

class Administration extends AdminController{

    /**
     * 管理员列表
     */
    public function admin_list(){
       return $this->fetch();
    }

    /**
     * 添加管理员
     */
    public function admin_add(){
        if( $_POST ){
            $rule = [
                'username' => 'require',
                'phone'    => 'mobile',
                'email'    => 'email',
                'pass'     => 'require|min:6|max:16',
                'repass'   => 'require|min:6|max:16'
            ];
            $validate = new Validate($rule);
            if(!$validate->check($_POST['data'])){
                exit(json_decode(['msg'=>$validate->getError(),'state'=>0]));
            }
            if( $_POST['data']['pass'] != $_POST['data']['repass']){
                exit(json_decode(['msg'=>'密码不一致！','state'=>0]));
            }

        }else{
            return $this->fetch();
        }
    }

}