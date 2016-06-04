<?php
namespace XHBBS\Controller;
use Think\Controller;
/**
* 定义公共控制器方法
*/
class CommonController extends Controller
{
	
	
	/* 
* PHP简单利用token防止表单重复提交 
* 此处理方法纯粹是为了给初学者参考 
*/  
public function set_token($userid) {  
   cookie($userid,md5($userid),3600);
  // dump(session());
   //echo session()[$userid];
  // echo $_SESSION[$userid];

   return md5($userid);
}  
  
public static function valid_token($userid,$token) {  
	
	//echo $userid;
    $res = $token === cookie($userid) ? true : false;
   

    return $res;
}  
public function unset_token(){

}
  
}


?>