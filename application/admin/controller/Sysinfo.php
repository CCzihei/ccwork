<?php
namespace Admin\Controller;

class Sysinfo extends Admin {

    private $sysinfo = null;
    private $info = null;
    public function _initialize(){
        $this->sysinfo= D('Sysinfo','Service');
        $this->info = $this->sysinfo->where('display = 1')->order('createtime DESC')->find();
        $this->islogin();
    }
    public function EditName(){
        if(IS_POST){
            $name = I('post.name');
            $result = $this->sysinfo->where("display = 1")->order('createtime DESC')->find();

            if(empty($result)){
                $_POST['createtime']=time();
                $_POST['display']=1;
                $_POST['name']=$name;
               $res = $this->sysinfo->AddSysinfo();
                if($res['flag']==false){
                    $this->error('操作失败');
                }
            }else{
                $_POST['name']=$name;
                $res = $this->sysinfo->where("display = 1")->save($_POST);
                if(!$res){
                    $this->error('操作失败');
                }
            }

            $this->assign('name',$this->info['name']);
            $this->assign('title','网站信息');
            $this->display();
        }else{
            $this->assign('name',$this->info['name']);
            $this->assign('title','网站信息');
            $this->display();
        }

    }

    public function Logo(){
        if(IS_POST){
            if($_FILES['logo']['name']){
                $res = Upload('logo');
            }
            if($res['flag']!=true){
                $this->error('上传失败:'.$res['content']);
            }
            $result = $this->sysinfo->where("display = 1")->order('createtime DESC')->find();
            if(empty($result)){
                $_POST['createtime']=time();
                $_POST['logo']=$res['content'];
                $_POST['display']=1;
                $r = $this->sysinfo->AddSysinfo();
                if($r['flag']==false){
                    $this->error('操作失败');
                }
                session('logo',$res['content']);
            }else{
                $_POST['logo']=$res['content'];
                $r= $this->sysinfo->where("display = 1")->save($_POST);
                if(!$r){
                    $this->error('操作失败');
                }
                session('logo',$res['content']);
            }
            $this->assign('logo',$this->info['logo']);
            $this->assign('title','网站信息');
            $this->display();
        }else{
            $this->assign('logo',$this->info['logo']);
            $this->assign('title','网站信息');
            $this->display();
        }
    }
}