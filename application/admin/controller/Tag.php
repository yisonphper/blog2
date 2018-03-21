<?php

namespace app\admin\controller;



class Tag extends Common
{
    protected $db;
    public function _initialize()
    {
    	parent::_initialize();
    	$this->db = new \app\common\model\Tag();
    }

    public function index()
    {
    	//获取首页数据
    	//$list = Db::name('tag')->where('status',1)->paginate(10);//查询标签所有数据 并且每页显示10条数据
    	$field = db('tag')->paginate(10);
    	// 获取分页显示
		$page = $field->render();
		// 模板变量赋值
		$this->assign('field',$field);
    	$this->assign('page', $page);
    	return $this->fetch();
    }
    /**
     * 添加标签
     */
    public function add()
    {
    	//接受用户的输入
    	$tag_id = input('param.tag_id');
    	if(request()->isPost())
    	{
    		$res = $this->db->add(input('post.'));
    		if($res['valid'])
    		{
    			$this->success($res['msg'],'admin/tag/index');exit;
    		}else{
    			$this->error($res['msg']);exit;
    		}
    	}
    	if($tag_id)
    	{
    		//说明是编辑请求
    		$oldData = $this->db->find($tag_id);
    	}else{
    		//添加
    		$oldData = ['tag_name'=>''];
    	}
    	$this->assign('oldData',$oldData);
    	//渲染输出
    	return $this->fetch();
    }
    /**
     * 删除标签
     * @return [type] [description]
     */
    public function del()
    {
    	//1.接受用户的输入
    	$tag_id = input('tag_id');
    	//2.调用model的del方法
    	$resd = $this->db->del($tag_id);
    	if($resd){
    		$this->success($resd['msg'],'admin/tag/index');exit;
    	}else{
    		$this->error($resd['msg']);exit;
    	}
    }
}
