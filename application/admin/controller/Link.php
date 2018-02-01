<?php
namespace Admin\Controller;

class Link extends Admin
{

    private $link = null;
    public function _initialize ()
    {
        $this->link= D('Link','Service');
        $this->islogin();
    }
    public function index(){
        $p = I('get.p',1);

        $params['page'] = $p;
        $params['step'] = 5;
//        $params['where'] = 'display = 1';
        $dataArr=$this->link->GetLinkList($params);
        $page = $dataArr['page'];
        $data = $dataArr['data'];

        $this->assign('page',$page);// 赋值分页输出
    	$this->assign('title','链接管理');
        $this->assign('data',$data);
    	$this->display();
    }

    public function AddLink ()
    {
        if(IS_POST){
            $_POST['createtime']=time();
            $res = $this->link->AddLink();
            if($res['flag']!=true){
                $this->error('操作错误！');
            }
            $this->assign('title','新增链接');
            $this->display();
        }else{
            $this->assign('title','新增链接');
            $this->display();
        }

    }
    public function EditLink ()
    {
        if(IS_POST){
            if(empty($_POST['id'])){
                $this->error('操作错误！');
            }
            $res = $this->link->EditLink();
            if($res!=true){
                $this->error('修改失败！');
            }

            $this->redirect('Link/Index');
        } else {
            if(IS_GET){
                $id = I('get.id');
                $res = $this->link->GetLinkById($id);
                $this->assign('data',$res);
                $this->assign('title','修改链接');
                $this->display();
            }else{
                $this->error('操作错误！');
            }

        }

    }
    public function DeleteLink ()
    {
        if(IS_GET){
            $id = I('get.id');
            $res = $this->link->DeleteLinkById($id);
            if($res == true){
                $this->redirect('Link/index');
            }else{
                $this->error("删除失败：".$res);
            }
            exit;
        }else{
            $this->error('操作错误！');
        }
    }
}