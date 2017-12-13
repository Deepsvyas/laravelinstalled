<?php

namespace App\Helpers;

use App\Models\PollQuestions;
use App\Models\Notifications;
use App\Models\Topics;
use App\Models\UserTrendingTags;
use App\Models\TrendingTags;
use Config,
    Auth;

class UserHelper {

    public static function getAvatar($obj, $size = "400_400") {
        $image = Config::get("params.user_image");
        $base_path = base_path($image['base_path']);
        if (!empty($obj)) {
            $base_path = $base_path . '/' . $obj->user_id . "/" . $size . "_" . $obj->user_image;
            $path = url($image['path'] . "/" . $obj->user_id . "/" . $size . "_" . $obj->user_image);
        } else {
            $base_path = "";
        }
        if (!file_exists($base_path)) {
            $theme = Config::get("CONFIG_THEME");
            $theme_path = "themes/" . $theme;
            $path = url($theme_path . "/img/img1.png");
        }
        return $path;
    }

    public static function getTopicImg($topicObj, $size = "300_300") {
        $image = Config::get("params.topic_image");
        $base_path = base_path($image['base_path']);
        if (!empty($topicObj)) {
            $base_path = sprintf($base_path, $topicObj->user_id, $topicObj->topic_id) . $topicObj->topic_img;
            $path = url(sprintf($image['path'], $topicObj->user_id, $topicObj->topic_id) . $topicObj->topic_img);
        } else {
            $base_path = "";
        }
        if (!file_exists($base_path)) {
            $theme = Config::get("CONFIG_THEME");
            $theme_path = "themes/" . $theme;
            $path = url($theme_path . "/img/img1.png");
        }
        return $path;
    }

    public static function getCommentImg($commObj, $size = "100_100") {
        $image = Config::get("params.comment_image");
        $base_path = base_path($image['base_path']);
        if (!empty($commObj)) {
            $base_path = sprintf($base_path, $commObj->topic->user_id, $commObj->topic_id) . $commObj->comment_img;
            $path = url(sprintf($image['path'], $commObj->topic->user_id, $commObj->topic_id) . $commObj->comment_img);
        } else {
            $base_path = "";
        }
        if (!file_exists($base_path)) {
            $theme = Config::get("CONFIG_THEME");
            $theme_path = "themes/" . $theme;
            $path = url($theme_path . "/img/img1.png");
        }
        return $path;
    }

    public static function check_email_confrim() {
        $data = Auth::user();
        if ($data->email_verified == 1) {
            return true;
        }
        return false;
    }

    public static function getActiveQuestion() {
        $pollObj = new PollQuestions();
        $data = $pollObj->getActiveQuestions();
        if (!$data['checkAns']) {
            return view('themes.forum.poll.pollsection', ['question' => $data]);
        } else {
            return view('themes.forum.poll.pollanswers', ['data' => $data]);
        }
    }

    public static function getActiveQuestionRender($poll) {
        $pollObj = new PollQuestions();
        $data = $pollObj->get_nextprev_qstin($poll->poll_question_id);
        $html = view('themes.forum.poll.pollanswers', ['data' => $data]);
        return $html->render();
    }

    public static function getUnReadCount($user_id) {
        $notifObj = new Notifications();
        return $notifObj->getUnReadCount($user_id);
    }

    public static function countTotalThreadsView($user_id) {
        $topicObj = new Topics();
        $data = $topicObj->countTotalThreadsView($user_id);
        if ($data) {
            return $data;
        }
        return 0;
    }

    public static function getTrendingTag() {
        $tagObj = new UserTrendingTags();
        $data = $tagObj->getTrendingTagFront();
        return $data;
    }

    public static function getActiveTrendingTag() {
        $tagObj = new TrendingTags();
        $data = $tagObj->getActiveTrendingTags();
        return $data;
    }

}
