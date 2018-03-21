<?php

namespace app\common\model;

use think\Model;

class Webset extends Model
{
    protected $pk = 'webset_id';
    protected $table ='blog_webset';

    /**
     * 添加
     */
    public function add($data)
    {
        $res = $this->validate([
            'website_name'=>'require',
        ],
        [
            'website_name.require'=>'请输入网站名称',
        ])->save($data);
        if($res)
        {
            return ['valid'=>1,'msg'=>'设置成功'];
        }
        else
        {
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }
    /**
     * 执行编辑
     */
    public function edit($data)
    {
    	$res = $this->validate([
    		'website_name'=>'require',
    	],
    	[
    		'website_name.require'=>'请输入网站名称',
    	])->save($data,[$this->pk=>$data['webset_id']]);
    	if($res){
    		return ['valid'=>1,'msg'=>'操作成功'];
    	}else{
    		return ['valid'=>0,'msg'=>$this->getError()];
    	}
    }
}
