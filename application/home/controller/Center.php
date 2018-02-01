<?php
namespace Home\Controller;
use Think\Controller;

class Center extends Home
{
    private $userinfo = null;
    public function _initialize(){
        $this->userinfo = session('home.userInfo');
    }
    public function  index(){
        $this->islogin();
        if(IS_GET){
            $active = I('get.active','info');
            $uid = $this->userinfo['id'];
            switch($active){
                case 'info':
                    $user = D('User','Service');
                    $params = array('field'=>'id,username,sex,age,department','id'=>$uid);
                    $info = $user->GetFieldByid($params);
                    $this->assign('info',$info);
                    $this->assign('department',$this->DEPARTMENTS);
                    break;
                case 'mymood':
                    $mood = D('Mood','Service');
                    $params['where'] = " uid = $uid" ;
                    $params['order'] = " createtime DESC";
                    $res = $mood->GetMoodList($params);
                    $this->assign('mood',$res['data']);
                    break;
                case 'addfriend':
                    $friend = D('Friend','Service');

                    $res = $friend->GetFriendListdByFId($this->userinfo['id']);
                    $data = $res['content'];
                    $user = D('User','Service');
                    foreach($data as $k=>$v){
                        $param['id'] = $v['uid'];
                        $param['field'] = 'username';
                        $r = $user->GetFieldById($param);
                        $data[$k]['username'] = $r['username'];
                    }
                    $this->assign('addfriend',$data);
                    break;
                case 'collect':
                    $collect = D('Collect','Service');
                    $params['where'] = " uid = $uid and display = 1" ;
                    $params['order'] = " createtime DESC";
                    $result = $collect->GetCollectList($params);
                    $result = $result['data'];
                    $mood = D('Mood','Service');
                    $user = D('User','Service');
                    $comment = D('Comment','Service');
                    $data=null;
                    foreach($result as $k=>$v){
                        $data[$k]['createtime'] = $v['createtime'];
                        $data[$k]['id'] = $v['id'];
                        $param['id']=$v['moodid'];
                        $param['field'] = 'content,uid';
                        $res = $mood->GetFieldByid($param);
                        $data[$k]['content'] = $res['content'];
                        $param['id'] = $res['uid'];
                        $param['field'] = 'username';
                        $username = $user->GetFieldByid($param);
                        $data[$k]['username'] = $username['username'];

                        $comres = $comment->field('uid,content')->where("moodID =".$v['moodid'])->select();
                        if(!empty($comres)){
                            foreach($comres as $key=>$val){
                                $param['id'] = $val['uid'];
                                $param['field'] = 'username';
                                $usernames = $user->GetFieldByid($param);

                                if(!empty($usernames)){
                                    $comres[$key]['username']=$usernames['username'];
                                }
                            }
                            $data[$k]['comment'] = $comres;
                        }

                    }
                    $this->assign('collect',$data);
                    break;
                case 'friendlist':
                    $friend = D('Friend','Service');
                    $uid = $this->userinfo['id'];
                    $params['where'] = 'uid = '.$uid.' and status = 2 and fid <>'.$uid;
                    $res = $friend->GetFriendList($params);
                    $data = $res['data'];
                    $page = $res['page'];
                    $user = D('User','Service');
                    foreach($data as $k=>$v){
                        $uid = $v['fid'];
                        $param['id'] = $uid;
                        $param['field'] = 'username';
                        $username = $user->GetFieldByid($param);
                        $data[$k]['username'] = $username['username'];
                    }
                    $this->assign('friendlist',$data);
                    $this->assign('page',$page);
                    break;
                case 'icon':
                    $this->assign('icon',$this->userinfo['icon']);
                    break;
                case 'favorite':
                    $favorite = D('Favorite','Service');
                    $params['where'] = " uid = $uid and display = 1" ;
                    $params['order'] = " createtime DESC";
                    $result = $favorite->GetFavoriteList($params);
                    $result = $result['data'];
                    $mood = D('Mood','Service');
                    $user = D('User','Service');
                    $data=null;
                    foreach($result as $k=>$v){
                        $data[$k]['createtime'] = $v['createtime'];
                        $data[$k]['id'] = $v['id'];
                        $param['id']=$v['moodid'];
                        $param['field'] = 'content,uid';
                        $res = $mood->GetFieldByid($param);
                        if(empty($res)){
                            unset($data[$k]);
                            continue;
                        }
                        $data[$k]['content'] = $res['content'];
                        $param['id'] = $res['uid'];
                        $param['field'] = 'username';
                        $username = $user->GetFieldByid($param);
                        $data[$k]['username'] = $username['username'];

                    }
                    $this->assign('favorite',$data);
                    break;
            }
            $this->assign('right', $active);

            $link = D('Link','Service');
            $links = $link->ShowLink();
            $this->assign('links',$links);

            $this->display();
        }else{
            $this->error('操作错误');
        }

    }
}