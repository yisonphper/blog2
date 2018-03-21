<?php

namespace app\admin\controller;

use think\Request;

class Link extends Common
{
    protected $db;

    public function _initialize()
    {
        parent::_initialize();
        $this->db = new \app\common\model\Link();
    }

    //友链首页
    public function index()
    {
        $field = $this->db->getAll();
        $this->assign('field',$field);
        return $this->fetch();
    }

    /**
     * 添加友链
     */
    public function add()
    {
        
        if(request()->isPost())
        {
            $res = $this->db->add(input('post.'));
            if($res['valid']){
                $this->success($res['msg'],'admin/link/index');
            }else{
                $this->error($res['msg']);
            }
        }

        $link_id = input('param.link_id');
        if($link_id){
            //说明是编辑
            $oldData = $this->db->find($link_id);
        }else{
            //说明是添加
            $oldData = ['link_name'=>'','link_url'=>'','link_sort'=>100];
        }
        $this->assign('oldData',$oldData);
        return $this->fetch();
    }
    /**
     * 友链删除
     */
    public function del()
    {
        $link_id = input('param.link_id');
        if(\app\common\model\Link::destroy($link_id)){
            $this->success('操作成功','admin/link/index');
        }else{
            $this->error('操作失败');
        }
    }
}