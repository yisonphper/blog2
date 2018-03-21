<?php

namespace app\index\controller;

use think\Controller;

class Content extends \app\index\controller\Common
{
    //首页
    public function index()
    {
    	//获取文章数据
    	$art_id = input('param.art_id');
    	//文章点击次数+1
    	db('article')->where('art_id',$art_id)->setInc('art_click');
    	$articleData = db('article')->field('art_id,art_title,art_author,art_content,sendtime')->find($art_id);
    	$headConf = ['title'=>"博客--{$articleData['art_title']}"];
    	$this->assign('headConf',$headConf);
    	//当前文章标签
    	$articleData['tags'] = db('art_tag')->alias('at')->join('__TAG__ t','at.tag_id=t.tag_id')->where('at.art_id',$articleData['art_id'])->field('t.tag_id,t.tag_name')->select();

    	$this->assign('articleData',$articleData);
    	return $this->fetch();
    }
}
