<?php

namespace app\index\controller;

use think\Controller;
use think\Request;

class Common extends Controller
{
    public function __construct(Request $request=null)
    {
    	parent::__construct($request);
    	//1.读取配置项
    	$webset = $this->loadWebset();
    	$this->assign('_webset',$webset);
    	//2.获取顶级栏目数据
    	$cateData = $this->loadCateData();
    	$this->assign('_cateData',$cateData);
    	//3.获取全部栏目数据
    	$allCateData = $this->loadAllCateData();
    	$this->assign('_allCateData',$allCateData);
    	//4.获取标签数据
    	$tagData = $this->loadTagData();
    	$this->assign('_tagData',$tagData);
    	//5.最新文章
    	$articleData = $this->loadArticleData();
    	$this->assign('_articleData',$articleData);
    	//6.友情链接
    	$linkData = $this->loadLinkData();
    	$this->assign('_linkData',$linkData);
    }
    /**
     * 获取友链数据
     */
    private function loadLinkData()
    {
    	return db('link')->order('link_sort desc')->select();
    }
    /**
     *  获取最新文章数据
     */
    private function loadArticleData()
    {
    	return db('article')->order('sendtime desc')->limit(2)->field('art_id,art_title,sendtime')->select();
    }
    /**
     * 获取标签数据
     */
    private function loadTagData()
    {
    	return db('tag')->select();
    }
    /**
     * 获取全部栏目数据
     */
    private function loadAllCateData()
    {
    	return db('category')->order('cate_sort desc')->select();
    }
    /**
     * 获取顶级分类数据
     */
    private function loadCateData()
    {
    	return db('category')->where('cate_pid',0)->order('cate_sort desc')->limit(10)->select();
    }
    /**
     * 读取配置项
     */
    private function loadWebset()
    {
    	return db('webset')->select();
    }
}
