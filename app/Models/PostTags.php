<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\CommonHelper as CommonHelper;
use Config;

class PostTags extends Model {

    protected $table = 'post_tags';
    public $primaryKey = "post_tag_id";

    /*
      All model relations arrives here
     */
    public function tag() {
        return $this->belongsTo('App\Models\Tags', 'tag_id', 'tag_id');
    }
    
    public function getTagIdByPostId($post_id) {
        return $this->where('post_id',$post_id)->lists('tag_id')->all();
    }
    public function getDataByPostIdAndTagId($post_id,$tag_id) {
        return $this->where('post_id',$post_id)->where('tag_id',$tag_id)->first();
    }
}
