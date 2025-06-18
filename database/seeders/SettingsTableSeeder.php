<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            "site_name" => "UltimateQR Lite",
            "site_logo" => "images/logo.png",
            "favicon" => "images/favicon.png",
            "seo_meta_description" => "UltimateQR Lite is the advanced customizable QR code generator. UltimateQR Lite is the simple and modern application to create powerful QR codes.",
            "seo_keywords" => "qr code maker, qr code generator, barcode maker, barcode generator"
        ]);
    }
}
