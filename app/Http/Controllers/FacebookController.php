<?php

namespace App\Http\Controllers;

use Facebook\Facebook;

class FacebookController extends Controller
{
    public function test()
    {
        $fb = new \Facebook\Facebook([
            'app_id' => env('FACEBOOK_KEY'),
            'app_secret' => env('FACEBOOK_SECRET'),
            'default_graph_version' => 'v2.8',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        $permissions = ['email']; // Optional permissions
        $loginUrl = $helper->getLoginUrl('https://example.com/fb-callback.php', $permissions);

        echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
    }
}