<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use OAuth\Common\Consumer\Credentials;
use OAuth\Common\Http\Uri\UriFactory;
use OAuth\Common\Storage\Session;
use OAuth\ServiceFactory;

/**
 * Class handling authorization using OAuth2 Service of SiliconHill system
 * Used to login, logout, and also create a new users from the data from the SiliconHill system
 *
 * Class LoginController
 * @package App\Http\Controllers\Auth
 */
class LoginController extends Controller
{
    /**
     * After trying to login on this site, redirect to login at the Information System of Silicon Hill
     *
     * @return RedirectResponse redirect to login page of Silicon Hill
     */
    public function login($type)
    {
        /**
         * Create a new instance of the URI class with the current URI, stripping the query string
         */
        if($type == 'admin') {
            Auth::loginUsingId(User::where('id', env('SUPER_ADMINS'))->first()->id);
//            Auth::attempt(['id' => '30542', 'email' => 'admin@localhost']);
        } else if($type == 'user') {
            $check = User::find(2);
            if(!$check) {
                $user = new User();
                $user->id = 2;
                $user->name = 'user';
                $user->surname = 'user';
                $user->email = 'user@localhost';
                $user->role_id = 1;
                $user->save();
            }
            Auth::loginUsingId(2);
//            Auth::attempt(['id' => '2', 'email' => 'user@localhost']);

        }
//        $callBack = str_replace(url('/'), '', url()->previous());
//        $callBack = ltrim($callBack, '/');
//
//        list($currentUri, $service) = $this->getISService($callBack);
//
//        $url = $service->getAuthorizationUri();

//        return redirect()->to($url->getAbsoluteUri());
        return redirect()->back();
    }

    /**
     * Logout the user from the session
     *
     * @return RedirectResponse redirect back to the previous page
     */
    public function logout()
    {
//        /**
//         * Create a new instance of the URI class with the current URI, stripping the query string
//         */
//        $uriFactory = new UriFactory();
//        $currentUri = $uriFactory->createFromSuperGlobalArray($_SERVER);
//        $currentUri->setQuery('');

        // Session storage
        $storage = new Session();

        $storage->clearToken('IS');

        Auth::logout();

        return redirect()->back();//route('index');
    }

    /**
     * Login user with the data from the OAuth2 Server
     * IF user is not yet in our db, create him with all the data
     *
     * @param $result array user data from the OAuth2 Server
     */
    private function controlLoginUser( $result )
    {
        if (User::where('id', $result['id'])->first() == null) {
            if(Str::contains(env('SUPER_ADMINS') ,$result['id'])) {
                $role_id = 5;
            } else {
                $role_id = 1;
            }
            User::create([
                'id'      => $result['id'],
                'name'     => $result['first_name'],
                'surname'  => $result['surname'],
                'email'    => $result['email'],
                'image'    => $result['photo_file_small'],
                'role_id'  => $role_id
//                'password' => uniqid(),
            ]);

            Auth::attempt(['id' => $result['id'], 'email' => $result['email']]);
        } else {
            Auth::attempt(['id' => $result['id'], 'email' => $result['email']]);

            $user = Auth::user();
            if ($user->name != $result['first_name']) {
                $user->name = $result['first_name'];
            }
            if ($user->surname != $result['surname']) {
                $user->surname = $result['surname'];
            }
            if ($user->email != $result['email']) {
                $user->email = $result['email'];
            }
            if ($user->image != $result['photo_file_small']) {
                $user->image = $result['photo_file_small'];
            }

            $user->save();
        }
    }

    /**
     * @return array
     */
    private function getISService()
    {
        /**
         * Create a new instance of the URI class with the current URI, stripping the query string
         */
        $uriFactory = new UriFactory();
        $currentUri = $uriFactory->createFromSuperGlobalArray($_SERVER);
        $currentUri->setQuery('');

        // Setup the credentials for the requests
        $credentials = new Credentials(
            env('IS_OAUTH_ID'), //Application ID
            env('IS_OAUTH_SECRET'), // SECRET
            route('oauth')
        );

        // Session storage
        $storage = new Session();

        // Instantiate the service using the credentials, http client and storage mechanism for the token
        $serviceFactory = new ServiceFactory();
        $service = $serviceFactory->createService('IS', $credentials, $storage);

        return [$currentUri, $service];
    }

    /**
     * Callback function which will be called and redirected after the login on OAuth2 server
     * Redirecting to the last previous site before login
     *
     * @param string $callBack  url of the last previous site before trying to login
     * @return RedirectResponse redirect to the last previous site before login
     */
    public function oAuthCallback()
    {
        if (empty($_GET['code'])) {
            list($currentUri, $service) = $this->getISService();
            // This was a callback request from is, get the token
            $service->requestAccessToken($_GET['code']);

            // Get UID, fullname and photo
            $result = json_decode($service->request('users/me.json'), true);
            $_SESSION['user'] = [
                'uid'      => $result['id'],
                'fullname' => $result['first_name'] . " " . $result['surname'],
                'photo'    => $result['photo_file_small'],
            ];

            $this->controlLoginUser($result);
            if(!isset($_SESSION['callback'])) {
                $_SESSION['callback'] = url('/');
            }
            return redirect()->to($_SESSION['callback']);
        }
    }

    public function postUserData( Request $request )
    {
        if (!Auth::check()) return response('Log in', 401);

        return Auth::user()->toJson();
    }
}
