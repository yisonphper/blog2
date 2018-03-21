<?php

namespace app\admin\controller;


class Webset extends Common
{
    //首页
    public function index()
    {
    	$field = db('webset')->select();
    	$this->assign('field',$field);
    	return $this->fetch();
    }
    /**
     * 添加
     */
    public function add()
    { 
         if(request()->isPost())
         {
            $websetId = input('param.webset_id');
            if(!$websetId)
            {
                //说明是新增
                $res = (new \app\common\model\Webset())->add(input('post.'));
                if($res['valid']){
                    $this->success($res['msg'],'admin/webset/index');
                }else{
                    $this->error($res['msg']);
                }            
            }
            else
            {
                //说明是编辑
                $res = (new \app\common\model\Webset())->edit(input('post.'));
                if($res['valid']){
                    $this->success($res['msg'],'admin/webset/index');
                }else{
                    $this->error($res['msg']);
                }
            }
         }

         return $this->fetch();  
    }
    
}
