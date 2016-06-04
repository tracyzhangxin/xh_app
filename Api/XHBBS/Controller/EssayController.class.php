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
    const POST_EMPTY=100002; //用户名或者密码为空
    const USER_EXIST=100003;//用户已存在
    const OPERATION_INVALID=100004;//非法造作
    const NO_ESSAY=100005;//非法造作

	//错误信息
	private static $REG_MSG=array(
		self::SUCCESS => 'success',
		self::OPERATION_ERROR => '发表失败',
        self::OPERATION_INVALID => '非法操作',
        self::NO_ESSAY => '文章不存在'
		);

 

 	public function getArticle(){
        if(I('post.userid','')){
            $map['A.userid']=I('post.userid','');
        }
 		$article=M('article');
 		$comment=M('comment');
 		$data=$article->table('xh_article A')->join('xh_comment B on B.articleID=A.ID','left')->field('A.ID,A.title,A.userid,A.content,A.runtime,B.content comment,B.runtime commenttime')->where($map)->select();
 		$this->ajaxReturn(array(
    			"code" => self::SUCCESS,
    			"msg"  => self::$REG_MSG[self::SUCCESS],
    			"data" => $data
    			));
 	}
 	
 	public function getDetails(){
 		$map['A.id']=I('post.Id',0);
        if(I('post.userid','')){
            $map['A.userid']=I('post.userid','');
        }
        $article=M('article');
        $comment=M('comment');
        $data=$article->table('xh_article A')->join('xh_comment B on B.articleID=A.ID','left')->field('A.ID,A.title,A.userid,A.content,A.runtime,B.content comment,B.runtime commenttime')->where($map)->select();
        if($data){
        $this->ajaxReturn(array(
                "code" => self::SUCCESS,
                "msg"  => self::$REG_MSG[self::SUCCESS],
                "data" => $data
                ));
         }
         else{
             $this->ajaxReturn(array(
                "code" => self::OPERATION_ERROR,
                "msg"  => self::$REG_MSG[self::OPERATION_ERROR],
                "data" => $data
                ));
         }
 }

 	public function publish(){
 		$map['userid']=I('post.userid','');
 		$map['content']=I('post.content','');
 		$map['title']=I('post.title','');
        $token=I('post.token','');
 		$map['runtime']=date('y-m-d h:i:s',time());

        //检验toekn
        $result=R('Common/valid_token',array($map['userid'],$token));
        if(!$result){
            $this->ajaxReturn(array(
                "code" => self::OPERATION_INVALID,
                "msg"  => self::$REG_MSG[self::OPERATION_INVALID],
                "data" => array()
                ));
        }


 		$article=M('article');
 		//$comment=M('comment');
 		$result= $article->data($map)->add();

        //读取对应数据ID等信息 以便客户端查询
        if($result)
          $data=$article->where($map)->find();

 		if($result){
 			$this->ajaxReturn(array(
    			"code" => self::SUCCESS,
    			"msg"  => self::$REG_MSG[self::SUCCESS],
    			"data" => $data
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

    public function comment(){        
        $map['articleID']=I('post.articleID','');
        $map['userid']=I('post.userid','');
        $map['content']=I('post.content','');
        $map['runtime']=date('Y-m-d h:i:s',time());
        $token=I('post.token','');

        $res=R('Common/valid_token',array($map['userid'],$token));
        if(!$res){
            $this->ajaxReturn(array(
                "code" => self::OPERATION_INVALID,
                "msg"  => self::$REG_MSG[self::OPERATION_INVALID],
                "data" => array()
                ));
        }

        if($map['articleID']&&$map['userid']&&$map['content']){

            $comment=M('comment');
            $result=$comment->data($map)->add();

            if($result){
            $this->ajaxReturn(array(
                "code" => self::SUCCESS,
                "msg"  => self::$REG_MSG[self::SUCCESS],
                "data" => array()
                ));
           }
           else{
            $this->ajaxReturn(array(
                "code" => self::OPERATION_ERROR,
                "msg"  => self::$REG_MSG[self::OPERATION_ERROR],
                "data" => array()
                ));
           }
        }
        else{
            $this->ajaxReturn(array(
                "code" => self::POST_EMPTY,
                "msg"  => self::$REG_MSG[self::POST_EMPTY],
                "data" => array()
                ));
        }

    }

    public function getComment(){
        $map['articleID']=I('post.articleID','');
        if($map['articleID']){
            $comment=M('comment');
            $result=$comment->where($map)->select();
            if($result){
             $this->ajaxReturn(array(
                "code" => self::SUCCESS,
                "msg"  => self::$REG_MSG[self::SUCCESS],
                "data" => $result
                ));
            }
            else{
                 $this->ajaxReturn(array(
                "code" => self::NO_ESSAY,
                "msg"  => self::$REG_MSG[self::NO_ESSAY],
                "data" => array()
                ));
            }
        }
        else{
              $this->ajaxReturn(array(
                "code" => self::POST_EMPTY,
                "msg"  => self::$REG_MSG[self::POST_EMPTY],
                "data" => array()
                ));
        }
    }
 }
?>