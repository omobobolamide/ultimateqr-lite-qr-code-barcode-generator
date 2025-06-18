<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configs')->insert([
            'config_key' => 'show_website',
            'config_value' => 'yes'
        ]);
        DB::table('configs')->insert([
            'config_key' => 'currency',
            'config_value' => 'bdt'
        ]);
        DB::table('configs')->insert([
            'config_key' => 'timezone',
            'config_value' => 'Asia/Dhaka'
        ]);
        DB::table('configs')->insert([
            'config_key' => 'login_button',
            'config_value' => 'green'
        ]);
        DB::table('configs')->insert([
            'config_key' => 'license',
            'config_value' => 1
        ]);
        DB::table('configs')->insert([
            'config_key' => 'app_type',
            'config_value' => 'BOTH'
        ]);
        DB::table('configs')->insert([
            'config_key' => 'currency_format',
            'config_value' => '12,34,567.89'
        ]);
        DB::table('configs')->insert([
            'config_key' => 'share_content',
            'config_value' => 'Hey there,
Scan this QR ##QRLINK##
Made with ##APPNAME## by Your Company Name'
        ]);
        DB::table('configs')->insert([
            'config_key' => 'purchase_code',
            'config_value' => ''
        ]);
        DB::table('configs')->insert([
            'config_key' => 'app_version',
            'config_value' => '1.0.0'
        ]);
        DB::table('configs')->insert([
            'config_key' => 'app_users',
            'config_value' => 'yes'
        ]);
        DB::table('configs')->insert([
            'config_key' => 'date_time_format',
            'config_value' => 'Y-m-d H:i'
        ]);
        DB::table('configs')->insert([
            'config_key' => 'default_language',
            'config_value' => 'bn'
        ]);
        DB::table('configs')->insert([
            'config_key' => 'check_type',
            'config_value' => 1
        ]);
    }
}
