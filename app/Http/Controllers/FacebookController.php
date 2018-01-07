<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Facebook\Facebook;

/**
 * Class FacebookController
 *
 * @package App\Http\Controllers
 */
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