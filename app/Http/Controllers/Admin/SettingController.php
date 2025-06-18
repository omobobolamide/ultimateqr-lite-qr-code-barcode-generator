<?php

namespace App\Http\Controllers\Admin;

use DateTimeZone;
use App\Models\Config;
use App\Models\Setting;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use Spatie\ResponseCache\Facades\ResponseCache;

class SettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    // Settings
    public function index()
    {
        // Queries
        $timezonelist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
        $currencies = Currency::get();
        $settings = Setting::first();
        $config = Config::get();
        //dd($config);

        // Get email configuration details
        $email_configuration = [
            'driver' => env('MAIL_MAILER', 'smtp'),
            'host' => env('MAIL_HOST', 'smtp.mailgun.org'),
            'port' => env('MAIL_PORT', 587),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'address' => env('MAIL_FROM_ADDRESS'),
            'name' => env('MAIL_FROM_NAME', $settings->site_name),
        ];

        // Get image limit
        $image_limit = [
            'SIZE_LIMIT' => env('SIZE_LIMIT', '')
        ];

        // Get Recaptcha configuration details
        $recaptcha_configuration = [
            'RECAPTCHA_ENABLE' => env('RECAPTCHA_ENABLE', ''),
            'RECAPTCHA_SITE_KEY' => env('RECAPTCHA_SITE_KEY', ''),
            'RECAPTCHA_SECRET_KEY' => env('RECAPTCHA_SECRET_KEY', '')
        ];

        $settings['email_configuration'] = $email_configuration;
        $settings['recaptcha_configuration'] = $recaptcha_configuration;
        $settings['image_limit'] = $image_limit;

        return view('admin.pages.settings.index', compact('settings', 'timezonelist', 'currencies', 'config'));
    }

    // Update General Setting
    public function changeGeneralSettings(Request $request)
    {
        Config::where('config_key', 'timezone')->update([
            'config_value' => $request->timezone,
        ]);

        Config::where('config_key', 'currency')->update([
            'config_value' => $request->currency,
        ]);

        Config::where('config_key', 'share_content')->update([
            'config_value' => $request->share_content,
        ]);

        Config::where('config_key', 'app_users')->update([
            'config_value' => $request->app_users,
        ]);

        $this->changeEnv([
            'TIMEZONE' => $request->timezone,
            'APP_TYPE' => $request->app_type,
            'SIZE_LIMIT' => $request->image_limit
        ]);

        // Page redirect
        return redirect()->back()->with('success', trans('General Settings Updated Successfully!'));
    }

    // Update Website Setting
    public function changeWebsiteSettings(Request $request)
    {
        Setting::where('id', '1')->update([
            'site_name' => $request->site_name
        ]);

        $double_site_name = str_replace('"', '', trim($request->site_name, '"'));
        $space_name = str_replace("'", '', trim($double_site_name, "'"));
        $site_name = str_replace(" ", '', trim($space_name, " "));

        Config::where('config_key', 'site_name')->update([
            'config_value' => $site_name,
        ]);

        // Update details
        Setting::where('id', '1')->update([
            'site_name' => $request->site_name, 'seo_meta_description' => $request->seo_meta_desc, 'seo_keywords' => $request->meta_keywords
        ]);

        // Check website logo
        if (isset($request->site_logo)) {
            $validator = Validator::make($request->all(), [
                'site_logo' => 'mimes:jpeg,png,jpg,gif|max:' . env("SIZE_LIMIT") . '',
            ]);

            if ($validator->fails()) {
                return back()->with('errors', $validator->messages()->all()[0])->withInput();
            }

            // get site logo
            $site_logo = $request->site_logo->getClientOriginalName();
            $UploadExtension = pathinfo($site_logo, PATHINFO_EXTENSION);

            // Upload image
            if ($UploadExtension == "jpeg" || $UploadExtension == "png" || $UploadExtension == "jpg" || $UploadExtension == "gif") {
                $site_logo = '/images/' . uniqid() . '.' . $UploadExtension;
                $request->site_logo->move(public_path('images'), $site_logo);
            }

            // Update details
            Setting::where('id', '1')->update([
                'site_logo' => $site_logo
            ]);
        }

        // Check favicon
        if (isset($request->favi_icon)) {
            $validator = Validator::make($request->all(), [
                'favi_icon' => 'mimes:jpeg,png,jpg,gif|max:' . env("SIZE_LIMIT") . '',
            ]);

            if ($validator->fails()) {
                return back()->with('errors', $validator->messages()->all()[0])->withInput();
            }

            // get favicon
            $favi_icon = $request->favi_icon->getClientOriginalName();
            $UploadExtension = pathinfo($favi_icon, PATHINFO_EXTENSION);

            // Upload image
            if ($UploadExtension == "jpeg" || $UploadExtension == "png" || $UploadExtension == "jpg" || $UploadExtension == "gif") {
                $favi_icon = '/images/' . uniqid() . '.' . $UploadExtension;
                $request->favi_icon->move(public_path('images'), $favi_icon);
            }

            // Update details
            Setting::where('id', '1')->update([
                'favicon' => $favi_icon
            ]);
        }

        // Page redirect
        return redirect()->back()->with('success', trans('Website Settings Updated Successfully!'));
    }

    // Update Google Setting
    public function changeGoogleSettings(Request $request)
    {
        // Page redirect
        return redirect()->back()->with('failed', trans('You can change the respective values directly from .env file.'));
    }

    // Update Email Setting
    public function changeEmailSettings(Request $request)
    {
        // Page redirect
        return redirect()->back()->with('failed', trans('You can change the respective values directly from .env file.'));
    }

    // Update email setting
    public function updateEmailSetting(Request $request)
    {
        // Update
        Config::where('config_key', 'email_heading')->update([
            'config_value' => $request->email_heading,
        ]);

        Config::where('config_key', 'email_footer')->update([
            'config_value' => $request->email_footer,
        ]);

        // Page redirect
        return redirect()->route('admin.tax.setting')->with('success', trans('Email Setting Updated Successfully!'));
    }

    // Clear cache
    public function clear()
    {
        // Laravel cache commend
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        ResponseCache::clear();

        // Page redirect
        return redirect()->back()->with('success', trans('Application Cache Cleared Successfully!'));
    }

    // Test email
    public function testEmail()
    {
        $message = [
            'msg' => 'Test mail'
        ];
        $mail = false;
        try {
            Mail::to(ENV('MAIL_FROM_ADDRESS'))->send(new \App\Mail\TestMail($message));
            $mail = true;
        } catch (\Exception $e) {
            // Page redirect
            return redirect()->back()->with('failed', trans('Email configuration wrong.'));
        }
        // Check email
        if ($mail == true) {
            // Page redirect
            return redirect()->back()->with('success', trans('Test mail send successfully.'));
        }
    }

    // Change .env file
    public function changeEnv($data = array())
    {
        if (count($data) > 0) {

            // Read .env-file
            $env = file_get_contents(base_path() . '/.env');

            // Split string on every " " and write into array
            $env = preg_split('/\s+/', $env);

            // Loop through given data
            foreach ((array) $data as $key => $value) {

                // Loop through .env-data
                foreach ($env as $env_key => $env_value) {

                    // Turn the value into an array and stop after the first split
                    // So it's not possible to split e.g. the App-Key by accident
                    $entry = explode("=", $env_value, 2);

                    // Check, if new key fits the actual .env-key
                    if ($entry[0] == $key) {
                        // If yes, overwrite it with the new one
                        $env[$env_key] = $key . "=" . $value;
                    } else {
                        // If not, keep the old one
                        $env[$env_key] = $env_value;
                    }
                }
            }

            // Turn the array back to an String
            $env = implode("\n", $env);

            // And overwrite the .env with the new data
            file_put_contents(base_path() . '/.env', $env);

            return true;
        } else {
            return false;
        }
    }
}
