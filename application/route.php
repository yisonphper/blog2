<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;

Route::rule('/','index/index');

//admin子域名绑定到admin模块 与下面的“完整域名绑定到admin模块”作用一样
//Route::domain('admin','admin');

// 
//Route::domain('admin.blog2.com','admin');
//没有在Apache配置，访问admin.blog2.com时报404错误

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
    '[c]'	=> [
    	':cate_id' => ['index/lists/index',['method' => 'get'],['id' => '\d+']],
    ],
    '[t]'	=> [
    	':tag_id'  => ['index/lists/index',['method' => 'get'],['id' => '\d+']],
    ],
    '[w]'	=> [
    	':art_id' => ['index/content/index',['method' => 'get'],['id' => '\d+']],
    ],
    
];

