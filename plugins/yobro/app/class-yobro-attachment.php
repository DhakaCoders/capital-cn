<?php


namespace YoBro\App;

class Attachment extends \Illuminate\Database\Eloquent\Model {
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'yobro_attachments';
    protected $fillable = array('conv_id','type','url','size', 'created_at');
}
