<?php

namespace app\common\model;

use think\Model;
use think\Request;

class Article extends Model
{
	protected $pk = 'art_id';
	protected $table = 'blog_article';
	//自动写入创建和更新的时间戳字段,并修改默认字段
	protected $autoWriteTimestamp = 'datetime';
	protected $createTime = 'sendtime';
	protected $updateTime = 'updatetime';
	//[数据完成]数据自动完成指在不需要手动赋值的情况下对字段的值进行处理后写入数据库。
	protected $auto = [];
	protected $insert = ['sendtime'];
	protected $update = ['updatetime'];

	//修改器
	// protected function setAdminIdAtrr($value)
	// {
	// 	return session('admin.admin_id');
	// }

	protected function setSendTimeAttr($value)
	{
		return time();
	}
	protected function setUpdateTimeAttr($value)
	{
		return time();
	}

	/**
	 * 获取文章首页数据
	 * @return [type] [description]
	 */
    public function getAll($is_recycle)
    {
    	return db('article')->alias('a')->join('__CATEGORY__ c','a.cate_id=c.cate_id')->where('a.is_recycle',$is_recycle)->field('a.art_id,a.art_title,a.art_author,a.sendtime,c.cate_name,a.art_sort')->order('a.art_sort desc,a.sendtime desc,a.art_id desc')->paginate(5);
    }

    /**
     * 添加文章
     */
    public function add($data)
    {
    	if(!isset($data['tag'])){
    		//说明添加的时候没有选择标签
    		return ['valid'=>0,'msg'=>'请选择标签'];
    	}
    	//验证
    	//添加数据库
        // echo $data['art_thumb'];
        // exit;
    	$result = $this->validate(true)->allowField(true)->save($data);
    	if($result){
    		//文章标签中间表的添加
    		foreach($data['tag'] as $v){
    			$artTagData = [
    				'art_id' => $this->art_id ,
    				'tag_id' => $v ,
    			];
    			(new ArtTag())->save($artTagData);
    		}

    		//执行成功
    		return ['valid'=>1,'msg'=>'操作成功'];
    	}else{
    		return ['valid'=>0,'msg'=>$this->getError()];
    	}
    }

    /**
     * 文章编辑
     */
    public function edit($data)
    {
        // var_dump($_FILES);
        // echo "<br>";
        // //var_dump($data['art_thumb']) ;
        // exit;
    	$res = $this->validate(true)->allowField(true)->save($data,[$this->pk=>$data['art_id']]);
    	if($res){
    		//执行标签处理
    		//首先将原有的标签数据删除
    		(new ArtTag())->where('art_id',$data['art_id'])->delete();
    		//执行添加
    		foreach ($data['tag'] as $v){
    			$artTagData = [
    				'art_id' => $this->art_id,
    				'tag_id' => $v,
    			];
    			(new ArtTag())->save($artTagData);
    		}
    		return ['valid'=>1,'msg'=>'操作成功'];
    	}else{
    		return ['valid'=>0,'msg'=>$this->getError()];
    	}
    }
    /**
     * 修改排序
     */
    public function changeSort($data)
    {
    	$result = $this->validate(
    		['art_sort'=>'require|between:1,9999',],
    		[
    			'art_sort.require'=>'请输入排序',
    			'art_sort.between'=>'排序需要在1-9999之间',
    		]
    	)->save($data,[$this->pk=>$data['art_id']]);
    	if($result){
    		return ['valid'=>1,'msg'=>'操作成功'];
    	}else{
    		return ['valid'=>0,'msg'=>$this->getError()];
    	}
    }

    /**
     * 删除
     */
    public function del($art_id)
    {
    	//删除文章标签中间表
    	$delArtTag = (new \app\common\model\ArtTag())->where('art_id',$art_id)->delete();
    	if(\app\common\model\Article::destroy($art_id)){
    		//说明删除成功
    		return ['valid'=>1,'msg'=>'删除成功'];
    	}else{
    		return ['valid'=>0,'msg'=>'删除失败'];
    	}
    }

}
