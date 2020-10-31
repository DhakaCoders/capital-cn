<?php


namespace YoBro\App;

class BlockConversation extends \Illuminate\Database\Eloquent\Model {
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'yobro_blocked_conversation';
    protected $fillable = array('blocked_by','blocked_user', 'created_at');
}
