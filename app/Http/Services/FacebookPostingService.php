<?php


namespace App\Http\Services;


use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;

class FacebookPostingService
{

    public function __construct()
    {
        $config = config('services.facebook');
        $this->fb = new Facebook($config);
    }

    public function postWithLink($message, $link) {
        $data = [
            'message' => $message,
            'link' => $link,
            ];
        $this->post($data);
    }

    public function postWithMessage($message) {
        $data = [
            'message' => $message,
        ];
        $this->post($data);
    }

    public function post($data)
    {
        $id = env('FACEBOOK_PAGE_ID');
        $response = $this->fb->post("/$id/feed", $data)->getGraphNode()->asArray();
        if (!$response['id']) {
            throw new FacebookSDKException();
        }
    }
}
