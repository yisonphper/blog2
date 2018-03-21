<?php

namespace app\admin\controller;

use think\Request;

class Article extends Common
{
    protected $db;

    public function _initialize()
    {
    	parent::_initialize();
    	$this->db = new \app\common\model\Article();
    }

    //首页
    public function index()
    {
    	$field = $this->db->getAll(2);
    	$this->assign('field',$field);

    	return $this->fetch();

    }

    //添加
    public function add()
    {
    	if(request()->isPost()){
    		$res = $this->db->add(input('post.'));
    		if($res['valid']){
    			$this->success($res['msg'],'index');exit;
    		}else{
    			$this->error($res['msg']);exit;
    		}
    	}
    	//1.获取分类数据
    	$cateData = (new \app\common\model\Category())->getAll();
    	$this->assign('cateData',$cateData);
    	//2.获取标签数据
    	$tagData = db('tag')->select();
    	$this->assign('tagData',$tagData);

    	return $this->fetch();
    }
    /**
     * 编辑
     */
    public function edit()
    {
    	if(request()->isPost()){
    		$res = $this->db->edit(input('post.'));
    		if($res['valid']){
    			$this->success($res['msg'],'index');exit;
    		}else{
    			$this->error($res['msg']);exit;
    		}
    	}
    	$art_id = input('param.art_id');
    	//1.获取分类数据
    	$cateData = (new \app\common\model\Category())->getAll();
    	$this->assign('cateData',$cateData);
    	//2.获取标签数据
    	$tagData = db('tag')->select();
    	$this->assign('tagData',$tagData);
    	//3.获取旧数据
    	$oldData = db('article')->find($art_id);
    	$this->assign('oldData',$oldData);
    	//4.获取当前文章所有标签id
    	$tag_ids = db('art_tag')->where('art_id',$art_id)->column('tag_id');
    	$this->assign('tag_ids',$tag_ids);

    	return $this->fetch();
    }
    /**
     * 修改排序
     */
    public function changeSort()
    {
    	if(request()->isPost())
    	{
    		$res = $this->db->changeSort(input('post.'));
    		if($res['valid']){
    			$this->success($res['msg'],'index');
    		}else{
    			$this->error($res['msg']);
    		}
    	}
    }

    /**
     * 删除到回收站
     */
    public function delToRecycle()
    {
    	$art_id = input('param.art_id');
    	//将数据删除到回收站
    	if($this->db->save(['is_recycle'=>1],['art_id'=>$art_id])){
    		$this->success('操作成功','index');
    	}else{
    		$this->error('操作失败');
    	}
    }

    /**
     * 恢复数据
     */
    public function outToRecycle()
    {
    	$art_id = input('param.art_id');
    	//将数据恢复到回收站
    	if($this->db->save(['is_recycle'=>2],['art_id'=>$art_id])){
    		$this->success('操作成功','index');
    	}else{
    		$this->error('操作失败');
    	}
    }

    /**
     * 回收站管理
     */
    public function recycle()
    {
    	$field = $this->db->getAll(1);
    	$this->assign('field',$field);
    	return $this->fetch();
    }

    /**
     * 回收站真正删除
     */
    public function del()
    {
    	$art_id = input('get.art_id');
    	$res = $this->db->del($art_id);
    	if($res['valid']){
    		$this->success($res['msg'],'index');
    	}else{
    		$this->error($res['msg']);
    	}
    }
    
    /**
     * 文件上传
     * 接收edit/add.html里ajax发来的数据并处理
     */
    public function upload()
    {
        $file = isset($_POST["file"])?$_POST["file"]:"";
        $filepath = isset($_POST["filepath"])?$_POST["filepath"]:"";

        //获取base64 的数据流
        $flarr = explode(',', $file); 
        $data = $flarr[1];

        //生成文件路径
        $fparr = explode('\\', $filepath);
        $filename = $fparr[count($fparr)-1];
        $newfilepath = ROOT_PATH.'public'.DS.'static'.DS.'uploads'.DS.$filename;
        //echo $newfilepath;
        
        //把base64数据格式转成图片
        file_put_contents($newfilepath, base64_decode($data)); 
    }
}
