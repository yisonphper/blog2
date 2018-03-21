<?php

namespace app\index\controller;

use think\Controller;

class Lists extends \app\index\controller\Common
{
    //首页
    public function index()
    {
    	$headConf = ['title'=>'博客TWO'];
    	$this->assign('headConf',$headConf);
    	//获取左侧第一部分数据
    	$cate_id = input('param.cate_id');
    	$tag_id = input('param.tag_id');
        $newarticleData = array();
    	if($cate_id)
    	{
    		//当前分类所有子集分类id
    		$cids = (new \app\common\model\Category())->getSon(db('category')->select(),$cate_id);
    		$cids[] = $cate_id;//把自己追加进去
    		$headData = [
    			'title'=>'分类',
    			'name'=>db('category')->where('cate_id',$cate_id)->value('cate_name'),
    			'total'=>db('article')->whereIn('cate_id',$cids)->count(),
    		];
    		//获取文章数据
    		$articleData = db('article')->alias('a')->join('__CATEGORY__ c','a.cate_id=c.cate_id')->where('a.is_recycle',2)->whereIn('a.cate_id',$cids)->paginate(5);

            $page = $articleData->render();
            //对象转化为数组
            foreach($articleData as $k=>$v){
                $newarticleData[$k] = $v;
            }
            
            //halt($newarticleData);
    	}
    	if($tag_id)
    	{
    		$headData = [
    			'title'=>'标签',
    			'name'=>db('tag')->where('tag_id',$tag_id)->value('tag_name'),
    			'total'=>db('art_tag')->where('tag_id',$tag_id)->count(),
    		];
    		//获取文章数据
    		$articleData = db('article')->alias('a')->join('__ART_TAG__ at','a.art_id=at.art_id')->join('__CATEGORY__ c','a.cate_id=c.cate_id')
    			->where('a.is_recycle',2)->where('at.tag_id',$tag_id)->paginate(5);
            $page = $articleData->render();
            //对象转化为数组
            foreach($articleData as $k=>$v){
                $newarticleData[$k] = $v;
            }
    	}
       
    	foreach($newarticleData as $k=>$v)
    	{
    		$newarticleData[$k]['tags'] = db('art_tag')->alias('at')->join('__TAG__ t','at.tag_id=t.tag_id')->where('at.art_id',$v['art_id'])->field('t.tag_id,t.tag_name')->select();
    	}
        
        $this->assign('page',$page);
    	$this->assign('headData',$headData);
    	$this->assign('newarticleData',$newarticleData);
    	return $this->fetch();      
    }
}
