<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use App\Models\Config;
use App\Models\QrCode;
use App\Models\Barcode;
use App\Models\Gateway;
use App\Models\Setting;
use App\Models\Currency;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Dashboard
    public function index()
    {
        // Common Data
        $settings = Setting::where('status', 1)->first();
        $config = Config::get();

        // Overall QR code, EPC QR code and barcode counts
        $qrCodes = QrCode::where('user_id', Auth::user()->id)->where('type', '!=', 'epc')->where('status', 1)->count();
        $epcCodes = QrCode::where('user_id', Auth::user()->id)->where('type', 'epc')->where('status', 1)->count();
        $barCodes = Barcode::where('user_id', Auth::user()->id)->where('status', 1)->count();
        $overallUsers = User::where('status', 1)->count();

        // This month
        $thisMonthQrCodes = QrCode::where('user_id', Auth::user()->id)->where('type', '!=', 'epc')->where('status', 1)->count();
        $thisMonthEpcCodes = QrCode::where('user_id', Auth::user()->id)->where('type', 'epc')->where('status', 1)->count();
        $thisMonthBarCodes = Barcode::where('user_id', Auth::user()->id)->where('status', 1)->count();

        // Overview chart
        $thisMonthQrCodes = [];
        $thisMonthEpcCodes = [];
        $thisMonthBarCodes = [];
        for ($_month = 1; $_month <= 12; $_month++) {
            $startDate = Carbon::create(date('Y'), $_month);
            $endDate = $startDate->copy()->endOfMonth();

            $currentMonthQrCodes = QrCode::where('user_id', Auth::user()->id)->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->where('type', '!=', 'epc')->where('status', 1)->count();
            $currentMonthEpcCodes = QrCode::where('user_id', Auth::user()->id)->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->where('type', 'epc')->where('status', 1)->count();
            $currentMonthBarCodes = Barcode::where('user_id', Auth::user()->id)->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->where('status', 1)->count();
            
            $thisMonthQrCodes[$_month] = $currentMonthQrCodes;
            $thisMonthEpcCodes[$_month] = $currentMonthEpcCodes;
            $thisMonthBarCodes[$_month] = $currentMonthBarCodes;
        }

        $thisMonthQrCodes = implode(',', $thisMonthQrCodes);
        $thisMonthEpcCodes = implode(',', $thisMonthEpcCodes);
        $thisMonthBarCodes = implode(',', $thisMonthBarCodes);

        return view('admin.index', compact('thisMonthQrCodes', 'thisMonthEpcCodes', 'thisMonthBarCodes', 'qrCodes', 'epcCodes', 'barCodes', 'overallUsers', 'settings'));
    }
}
