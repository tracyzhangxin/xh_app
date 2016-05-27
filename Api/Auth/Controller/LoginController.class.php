<?php
namespace Auth\Controller;
use Think\Controller;
class LoginController extends Controller {

	//错误码
	const SUCCESS=0;//成功
	const OPERATION_ERROR=100001;//	操作失败

	//错误信息
	private static $REG_MSG=array(
		self::SUCCESS => 'success',
		self::OPERATION_ERROR => '登陆失败'
		);
    public function index(){
        dump(session());
      echo "这是登陆接口";
    }
    //登陆
    public function checkLogin(){

    	//获取登陆post参数
    	$username=I('post.userid','');
    	$password=I('post.password','');
    	$isremember=I('post.isRemember',0);
  	
   //session('[destroy]');
    	//验证登陆信息
    	$user=M('user');
    	$result=$user->where("userid='%s' and pwd='%s'",$username,md5($password))->select();

    	//认证成功并且需要记住,添加token
    	if ($isremember) {
    		
    	}
    	
    	if($result){
            //dump(session());
            $token=R('Common/set_token',array($username));
            $result['token']=$token;
            //dump(session());
    		$this->ajaxReturn(array(
    			"code" => self::SUCCESS,
    			"msg"  => self::$REG_MSG[self::SUCCESS],
    			"data" => $result
    			));
    	}
    	else{
    		$this->ajaxReturn(array(
    			"code" => self::OPERATION_ERROR,
    			"msg"  => self::$REG_MSG[self::OPERATION_ERROR],
    			"data" => $result
    			));
    	}
    }

    public function get(){
        dump(cookie());
    }
}