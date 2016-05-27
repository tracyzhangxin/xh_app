<?php
 namespace XHBBS\Controller;
 use Think\Controller;

 /**
 * 
 */
 class EssayController extends Controller
 {
 		//错误码
	const SUCCESS=0;//成功
	const OPERATION_ERROR=100001;//	操作失败

	//错误信息
	private static $REG_MSG=array(
		self::SUCCESS => 'success',
		self::OPERATION_ERROR => '发表失败'
		);

 

 	public function getArticle(){
 		$article=M('article');
 		$comment=M('comment');
 		$data=$article->table('xh_article A')->join('xh_comment B on B.articleID=A.ID','left')->field('A.ID,A.title,A.userid,A.content,A.runtime,B.content comment,B.runtime commenttime')->select();
 		$this->ajaxReturn(array(
    			"code" => self::SUCCESS,
    			"msg"  => self::$REG_MSG[self::SUCCESS],
    			"data" => $data
    			));
 	}
 	
 	public function getDetails(){
 		
 	}

 	public function publish(){
 		$map['userid']=I('post.userid','');
 		$map['content']=I('post.content','');
 		$map['title']=I('post.title','');
 		$map['runtime']=date('y-m-d h:i:s',time());

 		$article=M('article');
 		//$comment=M('comment');
 		$result= $article->data($map)->add();

 		if($result){
 			$this->ajaxReturn(array(
    			"code" => self::SUCCESS,
    			"msg"  => self::$REG_MSG[self::SUCCESS],
    			"data" => array()
    			));
 		}
 		else{
 			$this->ajaxReturn(array(
    			"code" => self::SUCCESS,
    			"msg"  => self::$REG_MSG[self::SUCCESS],
    			"data" => array()
    			));

 		}



 	}
 }
?>