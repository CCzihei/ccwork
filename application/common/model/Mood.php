<?php
namespace app\common\model;

class Mood extends Base
{

    protected $pk = 'id';

    public function user()
    {
        return $this->hasOne('user', 'id', 'uid');
    }

    public function favorite()
    {
        return $this->hasMany('favorite', 'moodId', '', [], 'left');
    }

    public function collect()
    {
        return $this->hasMany('collect', 'moodId', '', [], 'left');
    }

    public function comment()
    {
        return $this->hasMany('comment', 'moodId', '', [], 'left');
    }

}