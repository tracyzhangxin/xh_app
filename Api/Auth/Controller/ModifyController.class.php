<?php
namespace Auth\Controller;
use Think\Controller;
/**
* 
*/
class ModifyController extends Controller
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
		self::OPERATION_ERROR => '非法操作',
		self::POST_EMPTY =>'用户名或密码不能为空',
		self::USER_EXIST =>'用户已存在',
		self::OPERATION_INVALID => '非法操作'
		);
	
	public function modifyPwd(){
		//dump(cookie());
		$userid=I('post.userid','');
		$token=I('post.token','');
		$old_pwd=I('post.old_pwd','');
		$new_pwd=I('post.new_pwd','');

		
		$result=R('Common/valid_token',array($userid,$token));
		//dump($result);
		if ($result) {
			if($userid&&$old_pwd&&$new_pwd){
				$user=M('user');
				$user->pwd=md5($new_pwd);
				$res=$user->where('UserID='.$userid)->save();
				$this->ajaxReturn(array(
				'code' => self::SUCCESS,
				'msg'  => self::$REG_MSG[self::SUCCESS],
				'data' => array()
				)
				);
			}
			else{
				$this->ajaxReturn(array(
				'code' => self::POST_EMPTY,
				'msg'  => self::$REG_MSG[self::POST_EMPTY],
				'data' => array()
				)
				);
			}
		}
		else{
			$this->ajaxReturn(array(
				'code' => self::OPERATION_ERROR,
				'msg'  => self::$REG_MSG[self::OPERATION_ERROR],
				'data' => array()
				)
				);
		}
	}

    //username或者imageurl
	public function modifyInfo(){
		$userid=I('post.userid','');
		$map['username']=I('post.username','');
		$map['imageurl']=I('post.imageurl','');
		$map['runtime']=date('Y-m-d h:i:s',time());
		$token=I('post.token','');


		$res=R('Common/valid_token',array($userid,$token));
		if(!$res){
			$this->ajaxReturn(array(
				'code' => self::OPERATION_INVALID,
				'msg'  => self::$REG_MSG[self::OPERATION_INVALID],
				'data' => array()
				)
				);
		}

		if($userid&&$map['imageurl']&&$map['username']){
			$user=M('User');
			$result=$user->where('UserID='.$userid)->save($map);

			if($result){
				$this->ajaxReturn(array(
				'code' => self::SUCCESS,
				'msg'  => self::$REG_MSG[self::SUCCESS],
				'data' => array()
				)
				);
			}
			else{
				$this->ajaxReturn(array(
				'code' => self::OPERATION_ERROR,
				'msg'  => self::$REG_MSG[self::OPERATION_ERROR],
				'data' => array()
				)
				);
			}
		}
		else{
			$this->ajaxReturn(array(
				'code' => self::POST_EMPTY,
				'msg'  => self::$REG_MSG[self::POST_EMPTY],
				'data' => array()
				)
				);
		}

	}
}
?>