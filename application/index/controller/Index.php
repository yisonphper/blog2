<?php
namespace app\index\controller;

use think\Controller;

class Index extends \app\index\controller\Common
{
    public function index()
    {
        $headConf = ['title'=>'博客TWO'];
        $this->assign('headConf',$headConf);
        //获取文章数据
        $articleData = db('article')->alias('a')->join('__CATEGORY__ c','a.cate_id=c.cate_id')->where('a.is_recycle',2)->order('sendtime desc')->paginate(5);
        //获取分页显示
        $page = $articleData->render();
        //halt($page);
        $this->assign('page',$page);
        //paginate()得到是一个对象，通过foreach循环可转换为数组。
        foreach($articleData as $k => $v){
            $newarticleData[$k]=$v;
        }
        //halt($newarticleData);
        foreach($newarticleData as $k => $v)
        {
        	$newarticleData[$k]['tags'] = db('art_tag')->alias('at')->join('__TAG__ t','at.tag_id=t.tag_id')->where('at.art_id',$v['art_id'])->field('t.tag_id,t.tag_name')->select();
        }
        //halt($newarticleData);
        $this->assign('newarticleData',$newarticleData);
        return $this->fetch();
    }
}
