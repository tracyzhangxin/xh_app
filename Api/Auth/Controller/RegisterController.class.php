<?php
namespace  Auth\Controller;
use Think\Controller;


class RegisterController extends Controller
{
	//错误码
	const SUCCESS=0;//成功
	const OPERATION_ERROR=100001;//	操作失败
	const POST_EMPTY=100002; //用户名或者密码为空
	const USER_EXIST=100003;//用户已存在
	const OPERATION_INVALID=100004;//非法造作

	//错误信息
	private static $REG_MSG=array(
		self::SUCCESS => 'success',
		self::OPERATION_ERROR => '注册失败',
		self::POST_EMPTY =>'用户名或密码不能为空',
		self::USER_EXIST =>'用户已存在',
		self::OPERATION_INVALID => '非法操作'
		);


	public function index(){
		echo "这是注册接口";
	}
    
    //完成注册
	public function DoRegister(){
		//获取注册参数
		$map['UserID']=I('post.userid','');
		$map['username']=I('post.username','');
		$map['pwd']=md5(I('post.password',''));
		$map['runtime']=date('y-m-d h:i:s',time());
		$map['imageurl']=I('post.imageurl','http://placehold.it/100x100');

		print_r($map);

		//当用户名和密码不为空
		if($map['UserID']&&$map['pwd']){
			$user=M('user');
			if($user->where('UserID='.$map['UserID'])->select()){
				$this->ajaxReturn(array(
				'code' => self::USER_EXIST,
				'msg'  => self::$REG_MSG[self::USER_EXIST],
				'data' => array()

				));
			}

			else{
			$result=$user->data($map)->add();
			if($result){
				//echo '注册陈宫';
				$this->ajaxReturn(array(
				'code' => self::SUCCESS,
				'msg'  => self::$REG_MSG[self::SUCCESS],
				'data' => array()

				));
			}
			else{
			$this->ajaxReturn(array(
				'code' => self::OPERATION_ERROR,
				'msg'  => self::$REG_MSG[self::OPERATION_ERROR],
				'data' => array()

				));
		       }
		   }
		}
		else{
			$this->ajaxReturn(array(
				'code' => self::OPERATION_ERROR,
				'msg'  => self::$REG_MSG[self::POST_EMPTY],
				'data' => array()

				));
		}
	}

}

?>