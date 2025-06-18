@extends('admin.layouts.app')

@section('content')
{{-- Page Content --}}
<div class="page-wrapper">
    <div class="container-xl">

        {{-- Failed --}}
        @if (Session::has('failed'))
            <div class="alert alert-important alert-danger alert-dismissible" role="alert">
                <div class="d-flex">
                    <div>
                        {{ Session::get('failed') }}
                    </div>
                </div>
                <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif

        {{-- Success --}}
        @if (Session::has('success'))
            <div class="alert alert-important alert-success alert-dismissible" role="alert">
                <div class="d-flex">
                    <div>
                        {{ Session::get('success') }}
                    </div>
                </div>
                <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif

        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        {{ __('Overview') }}
                    </div>
                    <h2 class="page-title">
                        {{ __('Dashboard') }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards mb-5">
                {{-- Check QR code --}}
                @if (env('APP_TYPE') == 'QRCODE' || env('APP_TYPE') == 'BOTH')
                {{-- QR Codes --}}
                <div class="col-sm-6 {{ env('APP_TYPE') == 'BOTH' ? 'col-lg-3' : 'col-lg-4' }}">
                    <div class="card">
                        <a href="{{ route('admin.all.qr') }}">
                            <div class="card-stamp">
                                <div class="card-stamp-icon bg-green">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-businessplan" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <ellipse cx="16" cy="6" rx="5" ry="3"></ellipse>
                                        <path d="M11 6v4c0 1.657 2.239 3 5 3s5 -1.343 5 -3v-4"></path>
                                        <path d="M11 10v4c0 1.657 2.239 3 5 3s5 -1.343 5 -3v-4"></path>
                                        <path d="M11 14v4c0 1.657 2.239 3 5 3s5 -1.343 5 -3v-4"></path>
                                        <path d="M7 9h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5"></path>
                                        <path d="M5 15v1m0 -8v1"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="subheader">{{ __('QR Codes') }}</div>
                                </div>
                                <div class="h1">{{ $qrCodes }}</div>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- EPC QR Codes --}}
                <div class="col-sm-6 {{ env('APP_TYPE') == 'BOTH' ? 'col-lg-3' : 'col-lg-4' }}">
                    <div class="card">
                        <a href="{{ route('admin.all.epc.qr') }}">
                            <div class="card-stamp">
                                <div class="card-stamp-icon bg-green">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-businessplan" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <ellipse cx="16" cy="6" rx="5" ry="3"></ellipse>
                                        <path d="M11 6v4c0 1.657 2.239 3 5 3s5 -1.343 5 -3v-4"></path>
                                        <path d="M11 10v4c0 1.657 2.239 3 5 3s5 -1.343 5 -3v-4"></path>
                                        <path d="M11 14v4c0 1.657 2.239 3 5 3s5 -1.343 5 -3v-4"></path>
                                        <path d="M7 9h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5"></path>
                                        <path d="M5 15v1m0 -8v1"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="subheader">{{ __('EPC QR Codes') }}</div>
                                </div>
                                <div class="h1">{{ $epcCodes }}</div>
                            </div>
                        </a>
                    </div>
                </div>
                @endif

                {{-- Check Barcode --}}
                @if (env('APP_TYPE') == 'BARCODE' || env('APP_TYPE') == 'BOTH')
                {{-- Barcodes --}}
                <div class="col-sm-6 {{ env('APP_TYPE') == 'BOTH' ? 'col-lg-3' : 'col-lg-4' }}">
                    <div class="card">
                        <a href="{{ route('admin.all.barcode') }}">
                            <div class="card-body">
                                <div class="card-stamp">
                                    <div class="card-stamp-icon bg-green">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-calendar-stats" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path
                                                d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4">
                                            </path>
                                            <path d="M18 14v4h4"></path>
                                            <circle cx="18" cy="18" r="4"></circle>
                                            <path d="M15 3v4"></path>
                                            <path d="M7 3v4"></path>
                                            <path d="M3 11h16"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="subheader">{{ __('Barcodes') }}</div>
                                </div>
                                <div class="h1">{{ $barCodes }}</div>
                            </div>
                        </a>
                    </div>
                </div>
                @endif

                {{-- Overall Users --}}
                <div class="col-sm-6 {{ env('APP_TYPE') == 'BOTH' ? 'col-lg-3' : 'col-lg-4' }}">
                    <div class="card">
                        <a href="{{ route('admin.users') }}">
                            <div class="card-stamp">
                                <div class="card-stamp-icon bg-green">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="subheader">{{ __('Overall Users') }}</div>
                                </div>
                                <div class="h1">{{ $overallUsers }}</div>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- This Month QR and Barcodes generated --}}
                <div class="col-sm-8 col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="subheader mb-2">{{ __('Month Wise Generated QR and Barcodes') }}</div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div id="thisMonth"></div>
                                </div>
                                <div class="col-md-auto">
                                    <div class="divide-y divide-y-fill">
                                        <div class="px-3">
                                            <div>
                                                <span class="status-dot bg-red"></span> {{ __('QR codes') }}
                                            </div>
                                            <div class="h2">
                                                {{ $qrCodes }}</div>
                                        </div>
                                        <div class="px-3">
                                            <div>
                                                <span class="status-dot bg-orange"></span> {{ __('EPC QR codes') }}
                                            </div>
                                            <div class="h2">{{ $epcCodes }}</div>
                                        </div>
                                        <div class="px-3">
                                            <div>
                                                <span class="status-dot bg-green"></span> {{ __('Barcodes') }}
                                            </div>
                                            <div class="h2">{{ $barCodes }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- QR and Barcodes generated --}}
                <div class="col-md-4 col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            {{-- Title --}}
                            <div class="d-flex align-items-center mb-3">
                                <div class="subheader mb-2">{{ __('Generated QR and Barcodes') }}</div>
                            </div>
                            <div id="overAll"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    @include('admin.includes.footer')
</div>

{{-- Custom JS --}}
@section('custom-js')
<script src="{{ asset('js/apexcharts.min.js') }}"></script>
<script>
    // This Month Overview
    // @formatter:off
	document.addEventListener("DOMContentLoaded", function () {
        "use strict";
		window.ApexCharts && (new ApexCharts(document.getElementById('thisMonth'), {
			chart: {
				type: "line",
				fontFamily: 'inherit',
				height: 212,
				parentHeightOffset: 0,
				toolbar: {
					show: false,
				},
				animations: {
					enabled: false
				},
			},
			fill: {
				opacity: 1,
			},
			stroke: {
				width: 2,
				lineCap: "round",
				curve: "smooth",
			},
			series: [{
				name: `{{ __("QR codes") }}`,
				data: [{{ $thisMonthQrCodes }}]
			},{
				name: `{{ __("EPC QR codes") }}`,
				data: [{{ $thisMonthEpcCodes }}]
			},{
				name: `{{ __("Barcodes") }}`,
				data: [{{ $thisMonthBarCodes }}]
			}],
			tooltip: {
				theme: 'dark'
			},
			grid: {
				padding: {
					top: -20,
					right: 0,
					left: -4,
					bottom: -4
				},
				strokeDashArray: 4,
			},
			xaxis: {
				labels: {
					padding: 0,
				},
				tooltip: {
					enabled: false
				},
				type: 'year',
			},
			yaxis: {
				labels: {
					padding: 4,
				},
			},
			labels: [`{{ __('Jan') }}`, `{{ __('Feb') }}`, `{{ __('Mar') }}`, `{{ __('Apr') }}`, `{{ __('May') }}`, `{{ __('Jun') }}`, `{{ __('July') }}`, `{{ __('Aug') }}`, `{{ __('Sept') }}`, `{{ __('Oct') }}`, `{{ __('Nov') }}`, `{{ __('Dec') }}`],
			colors: ["#d63939", "#F76707", "#2FB344"],
			legend: {
				show: false,
			},
		})).render();
	});
	// @formatter:on

    // Overall
    // @formatter:off
    document.addEventListener("DOMContentLoaded", function () {
        "use strict";
      	window.ApexCharts && (new ApexCharts(document.getElementById('overAll'), {
      		chart: {
      			type: "donut",
      			fontFamily: 'inherit',
      			height: 250,
      			sparkline: {
      				enabled: true
      			},
      			animations: {
      				enabled: false
      			},
      		},
      		fill: {
      			opacity: 1,
      		},
      		series: [{{ $qrCodes > 0 ? $qrCodes : 0.01 }}, {{ $epcCodes > 0 ? $epcCodes : 0.01 }}, {{ $barCodes > 0 ? $barCodes : 0.01 }}],
      		labels: ['QR codes', 'EPC QR codes', 'Barcodes'],
      		tooltip: {
      			theme: 'dark'
      		},
      		grid: {
      			strokeDashArray: 4,
      		},
      		colors: ["#d63939", "#F76707", "#2FB344"],
      		legend: {
      			show: true,
      			position: 'bottom',
      			offsetY: 12,
      			markers: {
      				width: 10,
      				height: 10,
      				radius: 100,
      			},
      			itemMargin: {
      				horizontal: 8,
      				vertical: 8
      			},
      		},
      		tooltip: {
      			fillSeriesColor: false
      		},
      	})).render();
    });
    // @formatter:on
</script>
@endsection
@endsection
