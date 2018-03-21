<?php

namespace app\common\model;

use think\Model;
use think\Validate;

class Tag extends Model
{
    protected $pk = 'tag_id';
    protected $table = 'blog_tag';
    /**
     * 添加标签
     */
    public function add($data)
    {
    	//1.验证
    	$validate = new validate(
    		[
				'tag_name'=>'require',
			],
			[
				'tag_name.require'=>'请输入标签名称',
			]);

		if(!$validate->check($data)){
			return ['valid'=>0,'msg'=>$validate->getError()];
		}

    	//2.执行添加
    	$result = $this->save($data);
    	if($result)
    	{
    		return ['valid'=>0,'msg'=>'操作成功'];
    	}else{
    		return ['valid'=>1,'msg'=>$this->getError()];
    	}
    }
    /**
     * 删除标签
     * @return [type] [description]
     */
    public function del($tag_id)
    {
    	//1.从数据库取到要删除的$tag_id数据并执行删除
    	$result = $this->where('tag_id',$tag_id)->delete();
    	//删除判断
    	if($result)
    	{
    		return ['valid'=>1,'msg'=>'删除成功'];
    	}else{
    		return ['valid'=>0,'msg'=>'删除失败'];
    	}
    }
}
