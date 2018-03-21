<?php

namespace app\admin\validate;

use think\Validate;

class Article extends Validate
{
	protected $rule = [
		'art_title'=>'require',
		'art_author'=>'require',
		'art_sort'=>'require|between:1,9999',
		'cate_id'=>'notIn:0',
		'art_thumb'=>'require',
		'art_digest'=>'require',
		'art_content'=>'require',
		'sendtime'=>'dateFormat:Y-m-d H:i:s',
	];
	protected $message = [
		'art_title.require'=>'请输入文章标题',
		'art_author.require'=>'请输入文章作者',
		'art_sort.require'=>'请输入文章排序',
		'art_sort.between'=>'文章排序需在1-9999之间',
		'cate_id.notIn'=>'请选择文章分类',
		'art_thumb.require'=>'请上传文章图片',
		'art_digest.require'=>'请输入文章摘要',
		'art_content.require'=>'请输入文章内容',
	];
}