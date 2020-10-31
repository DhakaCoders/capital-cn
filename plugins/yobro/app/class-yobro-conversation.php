<?php


namespace YoBro\App;

class Conversation extends \Illuminate\Database\Eloquent\Model {

  protected $primaryKey = 'id';
  public $timestamps = false;
  protected $table = 'yobro_conversation';
  protected $fillable = array('sender','reciever','block_status','created_at', 'delete_status', 'blocked_user_id', 'seen');
  public function message(){
    return $this->hasMany('\YoBro\App\Message','conv_id');
  }
}
