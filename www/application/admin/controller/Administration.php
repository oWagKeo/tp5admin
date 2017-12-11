<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/22
 * Time: 11:43
 */
namespace app\admin\controller;

use app\admin\classes\AdminController;
use think\Db;
use think\Validate;

class Administration extends AdminController{

    /**
     * 管理员列表
     */
    public function admin_list(){
        $condition = array();
        if( !empty($_GET['start']) ){
            $condition['add_time'] = array('>=',strtotime($_GET['start']));
        }
        if( !empty($_GET['end']) ){
            $condition['add_time'] = array('<=',strtotime($_GET['end']));
        }
        if( !empty($_GET['username']) ){
            $condition['username'] = array('like','%'.$_GET['username'].'%');
        }
        $list = Db::name('admin')->where($condition)->paginate(20);
        $this->assign('list',$list);
        return $this->fetch();
    }

    /**
     * 添加管理员
     */
    public function admin_add(){
        if( $_POST ){
            if( $this->check_admin_name($_POST['data']['username']) ){
                exit(json_encode(['msg'=>'用户已存在！','state'=>0]));
            }
            $rule = [
                'username' => 'require|min:3',
                'phone'    => 'require|number|max:11',
                'email'    => 'email',
                'pass'     => 'require|min:6|max:16',
                'repass'   => 'require|min:6|max:16'
            ];
            $validate = new Validate($rule);
            if(!$validate->check($_POST['data'])){
                exit(json_encode(['msg'=>$validate->getError(),'state'=>0]));
            }
            if( $_POST['data']['pass'] != $_POST['data']['repass']){
                exit(json_encode(['msg'=>'密码不一致！','state'=>0]));
            }
            $pwd = password($_POST['data']['pass']);
            $data = array(
                'username'  => $_POST['data']['username'],
                'phone'  => $_POST['data']['phone'],
                'email'  => $_POST['data']['email'],
                'username'  => $_POST['data']['username'],
                'real_name'  => $_POST['data']['relname'],
                'password'  => $pwd['password'],
                'encrypt'  => $pwd['encrypt'],
                'add_time'  => time(),
                'update_time'  => time()
            );
            $re = db('admin')->insert($data);
            if( $re ){
                exit(json_encode(['msg'=>'添加成功！','state'=>1]));
            }else{
                exit(json_encode(['msg'=>'系统错！添加失败','state'=>0]));
            }
        }else{
            return $this->fetch();
        }
    }

    /**
     * 更改用户状态
     */
    public function admin_stop(){
        if( $_POST['id']==1 ){
            exit(json_encode(['msg'=>'该用户不能更改！','state'=>0]));
        }
        $admin = Db::name('admin')->field('userid,username,status')->where('userid',$_POST['id'])->find();
        if( empty($admin) ){
            exit( json_encode(['msg'=>'该用户不存在','state'=>0]) );
        }
        if( $admin['status']==1 ){
            $re = Db::name('admin')->where('userid',$_POST['id'])->update(['status'=>0]);
        }else{
            $re = Db::name('admin')->where('userid',$_POST['id'])->update(['status'=>1]);
        }
        $re?exit(json_encode(['msg'=>'更改成功','state'=>1])):exit(json_encode(['msg'=>'更改失败','state'=>0]));
    }

    /**
     * 检测用户名是否存在
     */
    public function check_admin_name( $name ){
        $user = db('admin')->field('userid,username')->where('username',$name)->find();
        return $user?true:false;
    }

}