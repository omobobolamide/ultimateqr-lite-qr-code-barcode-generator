@extends('admin.layouts.app')

{{-- Custom CSS --}}
@section('custom-css')
    <style>
        .page-title {
            color: cornflowerblue !important;
        }
    </style>
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="container-xl">
            <!-- Page title -->
            <div class="page-header d-print-none">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="page-pretitle">
                            {{ __('Overview') }}
                        </div>
                        <h2 class="mb-2">
                            {{ __('Settings') }}
                        </h2>
                        <span
                            class="text-muted">{{ __('Note: Some fields are disabled. You can change the respective values directly from .env file.') }}
                            <a href="https://qrdocs.nativecode.in" target="_blank">{{ __('How should I do?') }}</a></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
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

                {{-- Settings --}}
                <div class="card">
                    <div class="card-body">
                        <div class="accordion" id="accordion-example">
                            {{-- General Configuration Settings --}}
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-1">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-1" aria-expanded="false">
                                        <h2>{{ __('General Configuration Settings') }}</h2>
                                    </button>
                                </h2>
                                <div id="collapse-1" class="accordion-collapse collapse"
                                    data-bs-parent="#accordion-example">
                                    <div class="accordion-body pt-0">
                                        <form action="{{ route('admin.change.general.settings') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                {{-- User Registration --}}
                                                <div class="col-md-6 col-xl-6">
                                                    <div class="mb-3">
                                                        <label class="form-label required"
                                                            for="app_users">{{ __('User Registration') }}</label>
                                                        <select name="app_users" id="app_users" class="form-control"
                                                            required>
                                                            <option value="yes"
                                                                {{ $config[10]->config_value == 'yes' ? 'selected' : '' }}>
                                                                {{ __('Yes') }}</option>
                                                            <option value="no"
                                                                {{ $config[10]->config_value == 'no' ? 'selected' : '' }}>
                                                                {{ __('No') }}</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- Script Type --}}
                                                <div class="col-md-6 col-xl-6">
                                                    <div class="mb-3">
                                                        <label class="form-label required"
                                                            for="app_type">{{ __('Application Type') }}</label>
                                                        <select name="app_type" id="app_type" class="form-control"
                                                            required>
                                                            <option value="QRCODE"
                                                                {{ env('APP_TYPE') == 'QRCODE' ? ' selected' : '' }}>
                                                                {{ __('QR Code') }}</option>
                                                            <option value="BARCODE"
                                                                {{ env('APP_TYPE') == 'BARCODE' ? ' selected' : '' }}>
                                                                {{ __('Barcode') }}</option>
                                                            <option value="BOTH"
                                                                {{ env('APP_TYPE') == 'BOTH' ? ' selected' : '' }}>
                                                                {{ __('Both') }}</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- Timezone --}}
                                                <div class="col-md-6 col-xl-6">
                                                    <div class="mb-3">
                                                        <label class="form-label required"
                                                            for="timezone">{{ __('Timezone') }}</label>
                                                        <select name="timezone" id="timezone" class="form-control"
                                                            required>
                                                            @foreach (timezone_identifiers_list() as $timezone)
                                                                <option value="{{ $timezone }}"
                                                                    {{ $config[2]->config_value == $timezone ? ' selected' : '' }}>
                                                                    {{ $timezone }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>



                                                {{-- Image Upload Limit --}}
                                                <div class="col-md-6 col-xl-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="image_limit">{{ __('Size') }}
                                                        </label>
                                                        <input type="number" class="form-control" name="image_limit"
                                                            value="{{ $settings->image_limit['SIZE_LIMIT'] }}"
                                                            placeholder="{{ __('Size') }}" min="1024">
                                                    </div>
                                                </div>

                                                {{-- Share Content Settings --}}
                                                <h2 class="page-title my-3">
                                                    {{ __('Share Content Settings') }}
                                                </h2>

                                                <div class="col-md-8 col-xl-8">
                                                    <div class="mb-3">
                                                        <label
                                                            class="form-label required">{{ __('Share Content') }}</label>
                                                        <textarea class="form-control" name="share_content" id="share_content" cols="10" rows="3"
                                                            placeholder="{{ __('Share Content') }}" required>{{ $config[7]->config_value }}</textarea>
                                                    </div>
                                                </div>

                                                {{-- Short codes --}}
                                                <div class="col-md-4 col-xl-4 mt-3">
                                                    <h2 class="text-muted"> {{ __('Short Codes :') }} </h2>
                                                    <span><span class="font-weight-bold">{{ __('##QRLINK##') }}</span> -
                                                        {{ __('QR Code Image Link') }}</span><br>
                                                    <span><span class="font-weight-bold">{{ __('##APPNAME##') }}</span> -
                                                        {{ __('App Name') }}</span>
                                                </div>

                                                {{-- Update button --}}
                                                <div class="text-end">
                                                    <div class="d-flex">
                                                        <button type="submit" class="btn btn-primary btn-md ms-auto">
                                                            {{ __('Update') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- Website Configuration Settings --}}
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-2">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-2" aria-expanded="false">
                                        <h2>{{ __('Website Configuration Settings') }}</h2>
                                    </button>
                                </h2>
                                <div id="collapse-2" class="accordion-collapse collapse"
                                    data-bs-parent="#accordion-example">
                                    <div class="accordion-body pt-0">
                                        <form action="{{ route('admin.change.website.settings') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                {{-- App Name --}}
                                                <div class="col-md-4 col-xl-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">{{ __('App Name') }}</label>
                                                        <input type="text" class="form-control" name="app_name"
                                                            value="{{ config('app.name') }}"
                                                            placeholder="{{ __('App Name') }}" readonly>
                                                    </div>
                                                </div>

                                                {{-- Site Name --}}
                                                <div class="col-md-4 col-xl-6">
                                                    <div class="mb-3">
                                                        <label class="form-label required">{{ __('Site Name') }}</label>
                                                        <input type="text" class="form-control" name="site_name"
                                                            value="{{ $settings->site_name }}"
                                                            placeholder="{{ __('Site Name') }}" required>
                                                    </div>
                                                </div>

                                                {{-- Website Logo --}}
                                                <div class="col-md-4 col-xl-6">
                                                    <div class="mb-3">
                                                        <div class="form-label">{{ __('Website Logo') }}</div>
                                                        <input type="file" class="form-control" name="site_logo"
                                                            placeholder="{{ __('Website Logo') }}"
                                                            accept=".png,.jpg,.jpeg,.gif,.svg" />
                                                        <small>{{ __('Recommended size : 200 x 90') }}</small>
                                                    </div>
                                                </div>

                                                {{-- Favicon --}}
                                                <div class="col-md-4 col-xl-6">
                                                    <div class="mb-3">
                                                        <div class="form-label">{{ __('Favicon') }}</div>
                                                        <input type="file" class="form-control" name="favi_icon"
                                                            placeholder="{{ __('Favicon') }}"
                                                            accept=".png,.jpg,.jpeg,.gif,.svg" />
                                                        <small>{{ __('Recommended size : 200 x 200') }}</small>
                                                    </div>
                                                </div>

                                                {{-- SEO Meta Description --}}
                                                <div class="col-md-6 col-xl-6">
                                                    <div class="mb-3">
                                                        <label
                                                            class="form-label required">{{ __('Meta Description') }}</label>
                                                        <textarea class="form-control" name="seo_meta_desc" rows="3" placeholder="{{ __('Meta Description') }}"
                                                            required>{{ $settings->seo_meta_description }}</textarea>
                                                    </div>
                                                </div>

                                                {{-- SEO Keywords --}}
                                                <div class="col-md-6 col-xl-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">{{ __('Keywords') }}</label>
                                                        <textarea class="form-control required" name="meta_keywords" rows="3"
                                                            placeholder="{{ __('Keywords (Keyword 1, Keyword 2)') }}" required>{{ $settings->seo_keywords }}</textarea>
                                                    </div>
                                                </div>

                                                {{-- Update button --}}
                                                <div class="text-end">
                                                    <div class="d-flex">
                                                        <button type="submit" class="btn btn-primary btn-md ms-auto">
                                                            {{ __('Update') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- Update Google Settings --}}
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-5">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-5" aria-expanded="false">
                                        <h2>{{ __('Google Configuration Settings') }}</h2>
                                    </button>
                                </h2>
                                <div id="collapse-5" class="accordion-collapse collapse"
                                    data-bs-parent="#accordion-example">
                                    <div class="accordion-body pt-0">
                                        <form action="{{ route('admin.change.google.settings') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">

                                                {{-- Google reCAPTCHA Settings --}}
                                                <h2 class="page-title my-3">
                                                    {{ __('Google reCAPTCHA Configuration Settings') }}
                                                </h2>
                                                <div class="col-md-4 col-xl-4">
                                                    <div class="mb-3">
                                                        <div class="form-label">{{ __('reCAPTCHA Enable') }}</div>
                                                        <select class="form-select" placeholder="Select a reCAPTCHA"
                                                            id="recaptcha_enable" name="recaptcha_enable" disabled="">
                                                            <option value="on"
                                                                {{ $settings->recaptcha_configuration['RECAPTCHA_ENABLE'] == 'on' ? 'checked' : '' }}>
                                                                {{ __('On') }}</option>
                                                            <option value="off"
                                                                {{ $settings->recaptcha_configuration['RECAPTCHA_ENABLE'] == 'off' ? 'checked' : '' }}>
                                                                {{ __('Off') }}</option>
                                                        </select>
                                                    </div>
                                                    <span>{{ __('If you did not get a reCAPTCHA (v2 Checkbox), create a') }}
                                                        <a href="https://www.google.com/recaptcha/about/"
                                                            target="_blank">{{ __('reCAPTCHA') }}</a> </span>
                                                </div>

                                                {{-- reCAPTCHA Site Key --}}
                                                <div class="col-md-4 col-xl-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">{{ __('reCAPTCHA Site Key') }}</label>
                                                        <input type="text" class="form-control"
                                                            name="recaptcha_site_key"
                                                            value="{{ $settings->recaptcha_configuration['RECAPTCHA_SITE_KEY'] }}"
                                                            placeholder="{{ __('reCAPTCHA Site Key') }}..." readonly>
                                                    </div>
                                                </div>

                                                {{-- reCAPTCHA Secret Key --}}
                                                <div class="col-md-4 col-xl-4">
                                                    <div class="mb-3">
                                                        <label
                                                            class="form-label">{{ __('reCAPTCHA Secret Key') }}</label>
                                                        <input type="text" class="form-control"
                                                            name="recaptcha_secret_key"
                                                            value="{{ $settings->recaptcha_configuration['RECAPTCHA_SECRET_KEY'] }}"
                                                            placeholder="{{ __('reCAPTCHA Secret Key') }}..." readonly>
                                                    </div>
                                                </div>

                                                {{-- Update button --}}
                                                <div class="text-end">
                                                    <div class="d-flex">
                                                        <button type="submit" class="btn btn-primary btn-md ms-auto">
                                                            {{ __('Update') }}
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- Update Email Configuration Settings --}}
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-6">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-6" aria-expanded="false">
                                        <h2>{{ __('Email Configuration Settings') }}</h2>
                                    </button>
                                </h2>
                                <div id="collapse-6" class="accordion-collapse collapse"
                                    data-bs-parent="#accordion-example">
                                    <div class="accordion-body pt-0">
                                        <form action="{{ route('admin.change.email.settings') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">

                                                {{-- Sender Name --}}
                                                <div class="col-md-4 col-xl-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">{{ __('Sender Name') }}</label>
                                                        <input type="text" class="form-control" name="mail_sender"
                                                            value="{{ $settings->email_configuration['name'] }}"
                                                            placeholder="{{ __('Sender Name') }}" readonly>
                                                    </div>
                                                </div>

                                                {{-- Sender Email Address --}}
                                                <div class="col-md-4 col-xl-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">{{ __('Sender Email Address') }}</label>
                                                        <input type="text" class="form-control" name="mail_address"
                                                            value="{{ $settings->email_configuration['address'] }}"
                                                            placeholder="{{ __('Sender Email Address') }}" readonly>
                                                    </div>
                                                </div>

                                                {{-- Mailer Driver --}}
                                                <div class="col-md-4 col-xl-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">{{ __('Mailer Driver') }}</label>
                                                        <input type="text" class="form-control" name="mail_driver"
                                                            value="{{ $settings->email_configuration['driver'] }}"
                                                            placeholder="{{ __('Mailer Driver') }}" readonly>
                                                    </div>
                                                </div>

                                                {{-- Mailer Host --}}
                                                <div class="col-md-4 col-xl-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">{{ __('Mailer Host') }}</label>
                                                        <input type="text" class="form-control" name="mail_host"
                                                            value="{{ $settings->email_configuration['host'] }}"
                                                            placeholder="{{ __('Mailer Host') }}" readonly>
                                                    </div>
                                                </div>

                                                {{-- Mailer Port --}}
                                                <div class="col-md-4 col-xl-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">{{ __('Mailer Port') }}</label>
                                                        <input type="text" class="form-control" name="mail_port"
                                                            value="{{ $settings->email_configuration['port'] }}"
                                                            placeholder="{{ __('Mailer Port') }}" readonly>
                                                    </div>
                                                </div>

                                                {{-- Mailer Encryption --}}
                                                <div class="col-md-4 col-xl-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">{{ __('Mailer Encryption') }}</label>
                                                        <input type="text" class="form-control" name="mail_encryption"
                                                            value="{{ $settings->email_configuration['encryption'] }}"
                                                            placeholder="{{ __('Mailer Encryption') }}" readonly>
                                                    </div>
                                                </div>

                                                {{-- Mailer Username --}}
                                                <div class="col-md-4 col-xl-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">{{ __('Mailer Username') }}</label>
                                                        <input type="text" class="form-control" name="mail_username"
                                                            value="{{ $settings->email_configuration['username'] }}"
                                                            placeholder="{{ __('Mailer Username') }}" readonly>
                                                    </div>
                                                </div>

                                                {{-- Mailer Password --}}
                                                <div class="col-md-4 col-xl-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">{{ __('Mailer Password') }}</label>
                                                        <input type="password" class="form-control" name="mail_password"
                                                            value="{{ $settings->email_configuration['password'] }}"
                                                            placeholder="{{ __('Mailer Password') }}" readonly>
                                                    </div>
                                                </div>

                                                {{-- Test Mail --}}
                                                <div class="col-md-4 col-xl-4 mt-3">
                                                    <div class="mb-3">
                                                        <label class="form-label"></label>
                                                        <a href="{{ route('admin.test.email') }}"
                                                            class="btn btn-primary">
                                                            {{ __('Test Mail') }}
                                                        </a>
                                                    </div>
                                                </div>

                                                {{-- Update button --}}
                                                <div class="text-end">
                                                    <div class="d-flex">
                                                        <button type="submit" class="btn btn-primary btn-md ms-auto">
                                                            {{ __('Update') }}
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        @include('admin.includes.footer')
    </div>
@endsection
