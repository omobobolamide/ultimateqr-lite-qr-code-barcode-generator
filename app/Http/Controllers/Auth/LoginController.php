<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Config;
use App\Models\Setting;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use App\Providers\RouteServiceProvider;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\OpenGraph;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // User authentication
    public function authenticated()
    {
        if (Auth::check() && Auth::user()->role_id == 1) {
            return redirect('/admin/dashboard');
        }

        return redirect('/admin/dashboard');
    }

    // Show login form
    public function showLoginForm()
    {
        $config = Config::get();
        $settings = Setting::first();

        // Recaptcha Configuration
        $recaptcha_configuration = [
            'RECAPTCHA_ENABLE' => env('RECAPTCHA_ENABLE', ''),
            'RECAPTCHA_SITE_KEY' => env('RECAPTCHA_SITE_KEY', ''),
            'RECAPTCHA_SECRET_KEY' => env('RECAPTCHA_SECRET_KEY', ''),
            'RECAPTCHA_SKIP_IP' => env('RECAPTCHA_SKIP_IP', '[]'),
        ];

        $settings['recaptcha_configuration'] = $recaptcha_configuration;

        // Seo Tools
        SEOTools::setTitle("Login - ".$settings->site_name);
        SEOTools::setDescription($settings->seo_meta_description);

        SEOMeta::setTitle("Login - ".$settings->site_name);
        SEOMeta::setDescription($settings->seo_meta_description);
        SEOMeta::addMeta('article:section', ucfirst("Login - ".$settings->site_name) . ' - ' . $settings->seo_meta_description, 'property');
        SEOMeta::addKeyword([$settings->meta_keywords]);

        OpenGraph::setTitle("Login - ".$settings->site_name);
        OpenGraph::setDescription($settings->seo_meta_description);
        OpenGraph::setUrl(URL::full());
        OpenGraph::addImage([asset($settings->site_logo), 'size' => 300]);

        JsonLd::setTitle("Login - ".$settings->site_name);
        JsonLd::setDescription($settings->seo_meta_description);
        JsonLd::addImage(asset($settings->site_logo));

        return view('auth.login', compact('config', 'settings'));
    }
}
