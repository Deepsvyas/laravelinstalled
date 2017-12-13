<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Posts;
use App\Models\Comments;
use App\Models\Tags;
use App\Models\PostTags;
use App\Helpers\PostHelper;

class PostsController extends BaseController {
    
    /* == Posts Section Started == */
    
    public function index(Request $request,$new_post=false) {
        return view('admin.posts.list', ['request' => $request,'new_post' => $new_post]);
    }

    public function postlist(Request $request) {
        $json_data = \CommonHelper::defaultJson();
        $postObj = new Posts();
        $commentObj = new Comments();
        $data = $postObj->getPagingPosts();
        $html = view('admin.posts.ajax_posts_list', ['request' => $request, 'data' => $data, 'commentObj' => $commentObj]);
        $json_data['html'] = $html->render();
        $json_data['success'] = 1;
        $json_data['success_mess'] = 1;
        return $json_data;
    }

    public function addnewpostajax(Request $request) {
        $postObj = new Posts();
        $input = $request->all();
        $data  = $postObj->addNew($input);
        return json_encode($data);
    }

    public function get_post_data(Request $request) {
        $post_key = $request->input("post_key");
        $postObj = new Posts();
        $postdata = $postObj->getpostByKey($post_key);
        $data = \CommonHelper::defaultJson();
        $data['post_key'] = $postdata->post_key;
        $data['post_author'] = $postdata->post_author;
        $data['post_title'] = $postdata->post_title;
        $data['post_publish'] = $postdata->status;
        $data['post_youtube_video_url'] = $postdata->post_youtube_video_url;
        $data['post_desc'] = \CommonHelper::htmldata($postdata->post_desc);
        $data['post_image'] = PostHelper::getPostImage($postdata, "100_100");
        $data['success'] = 1;
        $data['success_mess'] = 1;
        return json_encode($data);
    }

    public function update_active(Request $request) {
        $postObj = new Posts();
        $input = $request->all();
        $data = $postObj->updateActive($input);
        return json_encode($data);
    }

    public function delete(Request $request) {
        $postObj = new Posts();
        $input = $request->all();
        $data = $postObj->deleteSelected($input);
        return json_encode($data);
    }
        
        /*  == End Post Section ==  */
        
        /*  == Comment Section Started ==  */
    
    public function commentslist(Request $request) {
        $json_data = \CommonHelper::defaultJson();
        $input = $request->all();
        $postObj = new Posts();
        $post = $postObj->getPostByKey($input['post_key']);
        if (!empty($post)) {
            $commentObj = new Comments();
            $data = $commentObj->getPagingCommentsByPostId($post->post_id);
            $html = view('admin.posts.ajax_comments_list', ['request' => $request, 'post' => $post, 'data' => $data]);
            $json_data['html'] = $html->render();
            $json_data['success'] = 1;
            $json_data['success_mess'] = 1;
        } else {
            $json_data['error'] = 1;
            $json_data['error_mess'] = trans('comments.error.no_comment');
        }
        return $json_data;
    }

    public function get_comment_data(Request $request) {
        $comment_key = $request->input("comment_key");
        $commentObj = new Comments();
        $commentdata = $commentObj->getcommentByKey($comment_key);
        $data = \CommonHelper::defaultJson();
        $data['comment_message'] = $commentdata->comment_message;
        $data['success'] = 1;
        $data['success_mess'] = 1;
        return json_encode($data);
    }

    public function editcommentajax(Request $request) {
        $commentObj = new Comments();
        $input = $request->all();
        $data = $commentObj->addNew($input);
        return json_encode($data);
    }

    public function commentupdate_active(Request $request) {
        $commentObj = new Comments();
        $input = $request->all();
        $data = $commentObj->updateActive($input);
        return json_encode($data);
    }

    public function deletecomment(Request $request) {
        $commentObj = new Comments();
        $input = $request->all();
        $data = $commentObj->deleteSelected($input);
        return json_encode($data);
    }
    
        /*  == End Comment Section  == */

        /*  == Tag section Started ==  */
    public function addnewtagajax(Request $request) {
        $modelObj = new Tags();
        $input = $request->all();
        $data = $modelObj->addNew($input);
        return json_encode($data);
    }

    public function taglist(Request $request) {
        $json_data = \CommonHelper::defaultJson();
        $modelObj = new Tags();
        $data = $modelObj->getTagList();
        $html = view('admin.posts.ajax_tag_list', ['request' => $request, 'data' => $data, 'modelObj' => $modelObj]);
        $json_data['html'] = $html->render();
        $json_data['success'] = 1;
        $json_data['success_mess'] = 1;
        return $json_data;
    }
    
    /*  == End Tag section ==  */

}
