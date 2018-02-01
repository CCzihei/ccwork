<?php

namespace app\common\model;

class Comment extends Base
{
	protected $pk = 'id';

	public function user()
	{
		return $this->hasOne('user', 'id', 'uid');
	}
}