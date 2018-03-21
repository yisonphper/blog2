<?php

namespace app\admin\controller;

use think\Model;

/**
 * 栏目管理
 * class Category
 * @package app\admin\controller
 */

class Category extends Common
{
    protected $db;
    protected function _initialize()
    {
        parent::_initialize();
        $this->db = new \app\common\model\Category();
    }

    //首页
    public function index()
    {
        //获取栏目数据
        //$field = db('category')->select();
       // halt($field);
       $field = $this->db->getAll();
       //halt($field);
       $this->assign('field',$field);
       return $this->fetch();
    }
    //添加
    public function add()
    {
        if(request()->isPost())
        {
            //halt(input('post.'));
            $res = $this->db->add(input('post.'));
            if($res['valid'])
            {
                //操作成功
                $this->success($res['msg'],'admin/category/index');exit;
            }else{
                $this->error($res['msg']);exit;
            }
        }
        return $this->fetch();
    }
    /**
     * 添加子集
     */
    public function addSon()
    {
        if(request()->isPost())
        {
            $res = $this->db->add(input('post.'));
            if($res['valid'])
            {
                //操作成功
                $this->success($res['msg'],'admin/category/index');exit;
            }else{
                $this->error($res['msg']);exit;
            }
        }
        $cate_id = input('param.cate_id');
        $data = $this->db->where('cate_id',$cate_id)->find();
        $this->assign('data',$data);
        return $this->fetch();
    }
    /**
     * 编辑栏目
     */
    public function edit()
    {
        if(request()->isPost())
        {
            $res = $this->db->edit(input('post.'));
            if($res['valid'])
            {
                //操作成功
                $this->success($res['msg'],'admin/category/index');exit;
            }else{
                $this->error($res['msg']);exit;
            }
        }
        //接收cate_id
        $cate_id = input('param.cate_id');
        //获取旧数据
        $oldData = $this->db->find($cate_id);
        //dump($oldData);
        $this->assign('oldData',$oldData);
        //处理所属分类【不能包含自己和自己的子集数据】
        $cateData = $this->db->getCateData($cate_id);
        //halt($cateData);
        $this->assign('cateData',$cateData);
       //cate_id   cate_name  cate_pid
        //  1           开源产品     0
        //  4           后盾论坛     1
        //  3           后盾人视频   1 
        return $this->fetch();
    }
    /**
     * 删除栏目
     */
    public function del()
    {
        $res = $this->db->del(input('cate_id'));
        if($res['valid'])
        {
            $this->success($res['msg'],'admin/category/index');exit;
        }else{
            $this->error($res['msg']);exit;
        }
    }
}
