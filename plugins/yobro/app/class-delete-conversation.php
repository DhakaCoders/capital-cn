<?php


namespace YoBro\App;

class DeleteConversation extends \Illuminate\Database\Eloquent\Model {
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'yobro_deleted_conversation';
    protected $fillable = array('conv_id','user', 'created_at');
}
