<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\CommonHelper as CommonHelper;
use Config;

class Tags extends Model {

    protected $table = 'tags';
    public $primaryKey = "tag_id";

    /*
      All model relations arrives here
     */

    public function getTagList($take = 10) {
        return $this->orderBy('created_at', 'DESC')->take($take)->get();
    }

    public function getTagByText($text) {
        return $this->where('tag_text', $text)->first();
    }

    function addNew($input) {
        $jsondata = CommonHelper::defaultJson();
        $tag = $this->getTagByText($input['tag']);

        if (!empty($tag)) {
            $jsondata['success'] = 1;
            $jsondata['tag_id'] = $tag->tag_id;
            $jsondata['tag_text'] = $tag->tag_text;
        } else {
            $rules = array(
                'tag' => 'required',
            );
            $newnames = array(
                'new_tag' => 'Tag',
                'tag' => 'Tag',
            );
            $messages = array(
                'required' => ':attribute is required.',
            );
            $v = \Validator::make($input, $rules, $messages);
            $v->setAttributeNames($newnames);
            if ($v->passes()) {
                $tagObj = new Tags();
                $tagObj->tag_key = CommonHelper::getEncryptedKey();
                $tagObj->tag_text = $input['tag'];
                $tagObj->status = 1;
                $tagObj->save();
                $jsondata['success'] = 1;
                $jsondata['tag_id'] = $tagObj->tag_id;
                $jsondata['tag_text'] = $tagObj->tag_text;
                $jsondata['success_mess'] = trans('messages.success.save');
            } else {
                $jsondata['error'] = 1;
                $jsondata['error_mess'] = $v->messages();
            }
        }
        return $jsondata;
    }

}
