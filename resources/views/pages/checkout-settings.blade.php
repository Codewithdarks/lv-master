@extends('layouts.panel.master')

@section('page-title', 'Checkout Settings')

@section('custom-css')

@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="page-title d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                    <h4 class="fw-bold">Checkout Page Settings</h4>
                </div>
            </div>
        </div>

        <div class="bg-white p-3 p-md-4 p-lg-5 shadow-sm">

            <div class="row">
                <div class="col-12 col-md-12 col-lg-6">
                    <div class="profile-logo-upload pe-lg-4 pb-4 pb-lg-0 mb-2 mb-lg-0">
                        <form name="" action="{{ route('page.setting') }}" method="post">@csrf
                            <label for="logo">Logo</label>
                            @error('logo') <br><span class="text-danger text-small">{{ $message }}</span> @enderror
                            <div class="input-group mb-3">
                                <input type="url" class="form-control py-lg-3 @error('logo') is-invalid @enderror" name="logo" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('logo') }}" placeholder="Logo URL, i.e - https://www.someurl.com/logo.png" aria-label="Logo URL" aria-describedby="basic-addon1" required>
                            </div>
                            <label for="favicon">Favicon</label>
                            @error('favicon') <span class="text-danger text-small">{{ $message }}</span> @enderror
                            <div class="input-group mb-3">
                                <input type="url" class="form-control py-lg-3 @error('favicon') is-invalid @enderror" name="favicon" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('favicon') }}" placeholder="Favicon URL, i.e - https://www.someurl.com/icon.ico" aria-label="Favicon URL" aria-describedby="basic-addon1" required>
                            </div>
							<label for="header_text">Shipping Note</label>
                            @error('shipping_note') <span class="text-danger text-small">{{ $message }}</span> @enderror
                            <div class="input-group mb-3">
                                <input type="text" class="form-control py-lg-3 @error('shipping_note') is-invalid @enderror" name="shipping_note" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('shipping_note') }}" placeholder="Shipping Note Information" aria-label="L" aria-describedby="basic-addon1" required>
                            </div>
                            <label for="Checkout_LOGO">Checkout Secure Logo</label>
                            @error('checkout_secure_logo') <span class="text-danger text-small">{{ $message }}</span> @enderror
                            <div class="input-group mb-3">
                                <input type="url" class="form-control py-lg-3 @error('checkout_secure_logo') is-invalid @enderror" name="checkout_secure_logo" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('checkout_secure_logo') }}" placeholder="Checkout Secure logo" aria-label="" aria-describedby="basic-addon1" required>
                            </div>
                            <div class="input-group">
                                <button type="submit" class="btn btn-primary fw-bold text-uppercase py-2 px-4">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12 col-md-12 col-lg-6">
                    <h5 class="fw-bold mb-4"></h5>

                    <div class="faqs-group border-bottom bg-light py-2 px-3 pb-0 text-small">
                        <h6 class="fw-bold">Lorem ipsum dolor sit amet, consectetur</h6>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    </div>

                    <div class="faqs-group border-bottom py-2 px-3 pb-0 text-small">
                        <h6 class="fw-bold">Lorem ipsum dolor sit amet, consectetur</h6>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    </div>

                    <div class="faqs-group border-bottom bg-light py-2 px-3 pb-0 text-small">
                        <h6 class="fw-bold">Lorem ipsum dolor sit amet, consectetur</h6>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection

@section('custom-js')

@endsection
