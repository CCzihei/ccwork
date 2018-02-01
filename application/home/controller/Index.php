<?php
namespace app\home\Controller;
use app\Common\controller\Home;
use app\common\Model\Sysinfo;
use app\common\Model\Mood;
use app\common\Model\Link;
use think\Db;


class Index extends Home
{
	/**
	 * 首页
	 */
	public function index()
	{
		$mood_list = Mood::where(['display' => 1])->select();
		$links = Link::where(['display' => 1])->select();
		$comment_user = [];
		if (!empty($mood_list)) {
			$comment_user_list = [];
			foreach ($mood_list as $mood) {
				if (!empty($mood['comment'])) {
					foreach ($mood['comment'] as $comment) {
						$comment_user_list[] = $comment['uid'];
					}
				}
			}
			if (!empty($comment_user_list)) {
				$comment_user_list = array_unique($comment_user_list);
				$comment_user = Db::name('user')->where(['id' => ['in', $comment_user_list]])->column('username,icon,id', 'id');
			}
		}

		$this->assign('comment_user', $comment_user);
		$this->assign('links', $links);
		$this->assign('mood_list', $mood_list);
		return $this->fetch();
	}
}