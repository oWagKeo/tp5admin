<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/20
 * Time: 15:21
 */
namespace app\admin\controller;

use think\Controller;
use app\admin\classes\ApiController;
use think\Validate;

class Login extends Controller{

    /**
     * 登录
     */
    public function login(){
        if( $_POST ){
            //校验规则
            $valiparam = [
                'username' => 'require',
                'password' => 'require',
                'code'     => 'require',
            ];
            $validate = new Validate($valiparam);
            if (!$validate->check($_POST)) {
                $this->error($validate->getError(),'login','',1);
            }
            //检测验证码是否真确
            $api = new ApiController();
            if( !$api->check_verify( $_POST['code'] ) ){
                $this->error('验证码错误','login','',1);
            }
            $user = db('admin')->field('username,password,userid,encrypt')->where(['username'=>$_POST['username'],'status'=>1])->find();
            if( !$user ){
                $this->error('用户名或者密码错误！');
            }
            $pas = password($_POST['password'],$user['encrypt']);
            if( $pas != $user['password'] ){
                $this->error('用户名或者密码错误！');
            }
            db('admin_login')->insert(['uid'=>$user['userid'],'time'=>time(),'ip'=>get_client_ip()]);
            session('userinfo',array('username'=>$user['username'],'userid'=>$user['userid']));
            $this->success('登录成功！','Index/index','',1);
        }else{
            $this->view->engine->layout(false);//不加载layout
            return view();
        }
    }

    /**
     * 退出登录
     */
    public function login_out(){
        session('userinfo',null);
        $this->redirect('Login/login');
    }

    /**
     * 验证码
     */
    public function cap_url(){
        $api = new ApiController();
        return $api->verify();
    }

}