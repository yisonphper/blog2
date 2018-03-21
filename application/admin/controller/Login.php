<?php

namespace app\admin\controller;

use \think\Controller;

class Login extends Controller
{
    public function index()
    {
    	if(request()->isPost()){
    		$res=model('Admin')->login(input('post.'));
    		if ($res['valid']) {
    			//说明登录成功
    			$this->success($res['msg'],'admin/entry/index');exit;
    		}else{
    			//说明登录失败
    			$this->error($res['msg']);exit();
    		}
    	}
    	//加载登录页面
    	return $this->fetch();
    }
    public function logout()
    {
        if(request()->isGet()){
            session(null);
            $this->success('成功退出','admin/entry/index');
        }
    }
}
