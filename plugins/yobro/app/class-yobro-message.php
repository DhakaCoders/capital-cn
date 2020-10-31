<?php


namespace YoBro\App;

class Message extends \Illuminate\Database\Eloquent\Model {
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'yobro_messages';
    protected $fillable = array('conv_id','message', 'attachment_id', 'status','seen' ,'sender_id','reciever_id', 'delete_status', 'created_at');
}
