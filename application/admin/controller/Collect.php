<?php
namespace Admin\Controller;

class CollectController extends AdminController {

    private $Collect = null;
    public function _initialize(){
        $this->Collect= D('Collect','Service');
        $this->islogin();
    }
    public function index(){
        $p = I('get.p',1);
        $params['page'] = $p;
        $params['step'] = 5;
        $params['where'] = 'display = 1';
        $dataArr=$this->Collect->GetCollectList($params);
        $page = $dataArr['page'];
        $data = $dataArr['data'];
        $user = D('User','Service');
        $mood = D('Mood','Service');
        foreach($data as $k=>$v){
            $param['id'] = $v['moodid'];
            $param['field'] = 'content';
            $content = $mood->GetFieldByid($param);
            if(!$content){
                unset($data[$k]);
                continue;
            }
            $data[$k]['content'] = $content['content'];
            $param['id'] = $v['uid'];
            $param['field'] = 'username';
            $userinfo = $user->GetFieldByid($param);
            $data[$k]['username'] = $userinfo['username'];
            $model = M();
            $res = $model->table("ch_mood as m,ch_user as u")->field("u.username as owner")->where("m.uid = u.id and m.id = ".$v['moodid'])->find();
            $data[$k]['owner'] = $res['owner'];
        }
        $this->assign('page',$page);// 赋值分页输出
    	$this->assign('title','收藏管理');
        $this->assign('data',$data);
    	$this->display();
    }
    public function DeleteCollect(){
        if(IS_GET){
            $id = I('get.id');
            $res = $this->Collect->DeleteCollectById($id);
            if($res !== true){
                $this->error('操作错误');
            }
            $this->redirect('Collect/index');
        }else{
            $this->error('操作错误');
        }
    }
}