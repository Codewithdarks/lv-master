@extends('layouts.panel.master')

@section('page-title', 'Config Settings')

@section('custom-css')

@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="page-title d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                    <h4 class="fw-bold">All Config Settings</h4>
                </div>
            </div>
        </div>

        <div class="bg-white p-3 p-md-4 p-lg-5 shadow-sm">

            <form name="" action="{{ route('saveconfig.setting') }}" method="post">@csrf
            <div class="row">
            
                <div class="col-12 col-md-12 col-lg-6">
                    <h4>Main settings</h4>
                    <div class="pe-lg-4 pb-4 pb-lg-0 mb-2 mb-lg-0">
                            <labe>Checkout URL</labe>
                            @error('checkout_domain') <br><span class="text-danger text-small">{{ $message }}</span> @enderror
                            <div class="input-group mb-3">
                                <input type="url" class="form-control py-lg-3 @error('checkout_domain') is-invalid @enderror" name="checkout_domain" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('checkout_domain') }}" placeholder="https://www.someurl.com" required>
                            </div>
                            <h4>Facebook CAPI detail</h4>
                            <label>Facebook Access Token</label>
                            @error('facebook_accesstoken') <span class="text-danger text-small">{{ $message }}</span> @enderror
                            <div class="input-group mb-3">
                                <input type="text" class="form-control py-lg-3 @error('facebook_accesstoken') is-invalid @enderror" name="facebook_accesstoken" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('facebook_accesstoken') }}" placeholder="Facebook Access Token" required>
                            </div>
                            <label>Facebook PIXELID</label>
                            @error('facebook_pixelid') <span class="text-danger text-small">{{ $message }}</span> @enderror
                            <div class="input-group mb-3">
                                <input type="text" class="form-control py-lg-3 @error('facebook_pixelid') is-invalid @enderror" name="facebook_pixelid" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('facebook_pixelid') }}" placeholder="Facebook PIXELID" required>
                            </div>   
                    </div> 
                </div>
                <div class="col-12 col-md-12 col-lg-6">
                <h4>Avalara settings</h4>
                    <div class="pe-lg-4 pb-4 pb-lg-0 mb-2 mb-lg-0">
                            <labe>Avalara Username</labe>
                            @error('avalara_username') <br><span class="text-danger text-small">{{ $message }}</span> @enderror
                            <div class="input-group mb-3">
                            <input type="text" class="form-control py-lg-3 @error('avalara_username') is-invalid @enderror" name="avalara_username" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('avalara_username') }}" placeholder="Avalara username" required>
                            </div>
                            
                            <label>Avalara Passowrd</label>
                            @error('avalara_password') <span class="text-danger text-small">{{ $message }}</span> @enderror
                            <div class="input-group mb-3">
                                <input type="password" class="form-control py-lg-3 @error('avalara_password') is-invalid @enderror" name="avalara_password" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('avalara_password') }}" placeholder="Avalara Password" required>
                            </div>
							<label for="header_text">Avalara Company</label>
                            @error('avalara_company') <span class="text-danger text-small">{{ $message }}</span> @enderror
                            <div class="input-group mb-3">
                                <input type="text" class="form-control py-lg-3 @error('avalara_company') is-invalid @enderror" name="avalara_company" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('avalara_company') }}" placeholder="Avalara Company Name" required>
                            </div>
                            <label for="header_text">Avalara Account ID</label>
                            @error('avalara_accountid') <span class="text-danger text-small">{{ $message }}</span> @enderror
                            <div class="input-group mb-3">
                                <input type="text" class="form-control py-lg-3 @error('avalara_accountid') is-invalid @enderror" name="avalara_accountid" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('avalara_accountid') }}" placeholder="Avalara Account ID" required>
                            </div>
                            <label for="Checkout_LOGO">Avalara License Key</label>
                            @error('avalara_license_key') <span class="text-danger text-small">{{ $message }}</span> @enderror
                            <div class="input-group mb-3">
                                <input type="text" class="form-control py-lg-3 @error('avalara_license_key') is-invalid @enderror" name="avalara_license_key" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('avalara_license_key') }}" placeholder="Avalara License Key" required>
                            </div>
                            <label for="Checkout_LOGO">Avalara Environment</label>
                            @error('avalara_environment') <span class="text-danger text-small">{{ $message }}</span> @enderror
                            <div class="input-group mb-3">
                                <input type="text" class="form-control py-lg-3 @error('avalara_environment') is-invalid @enderror" name="avalara_environment" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('avalara_environment') }}" placeholder="Avalara Environment" required>
                            </div>
                </div>
                </div>
                <div class="col-12 col-md-12 col-lg-6">
                <h4>Shopify Store and API detail</h4>
                    <div class="pe-lg-4 pb-4 pb-lg-0 mb-2 mb-lg-0">
                            <labe>Shopify Domain</labe>
                            @error('shopify_domain') <br><span class="text-danger text-small">{{ $message }}</span> @enderror
                            <div class="input-group mb-3">
                            <span class="input-group-text">https://</span>
                            <input type="text" class="form-control py-lg-3 @error('shopify_domain') is-invalid @enderror" name="shopify_domain" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('shopify_domain') }}" placeholder="wtdev" required>
                            <span class="input-group-text">.myshopify.com</span>
                            </div>
                            
                            <label>Shopify Website link</label>
                            @error('shopify_main_domain') <span class="text-danger text-small">{{ $message }}</span> @enderror
                            <div class="input-group mb-3">
                                <input type="url" class="form-control py-lg-3 @error('shopify_main_domain') is-invalid @enderror" name="shopify_main_domain" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('shopify_main_domain') }}" placeholder="https://www.someurl.com/" required>
                            </div>
							<label for="header_text">Shopify Admin API Access Token</label>
                            @error('shopify_adminapi_access_token') <span class="text-danger text-small">{{ $message }}</span> @enderror
                            <div class="input-group mb-3">
                                <input type="text" class="form-control py-lg-3 @error('shopify_adminapi_access_token') is-invalid @enderror" name="shopify_adminapi_access_token" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('shopify_adminapi_access_token') }}" placeholder="Shopify Admin API Access Token" required>
                            </div>
                            <label for="Checkout_LOGO">Shopify Storefront API Access Token</label>
                            @error('shopify_storefrontapi_access_token') <span class="text-danger text-small">{{ $message }}</span> @enderror
                            <div class="input-group mb-3">
                                <input type="text" class="form-control py-lg-3 @error('shopify_storefrontapi_access_token') is-invalid @enderror" name="shopify_storefrontapi_access_token" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('shopify_storefrontapi_access_token') }}" placeholder="Shopify Storefront API Access Token" required>
                            </div>
                            <label for="Checkout_LOGO">Shopify API version</label>
                            @error('shopify_api_version') <span class="text-danger text-small">{{ $message }}</span> @enderror
                            <div class="input-group mb-3">
                                <input type="text" class="form-control py-lg-3 @error('shopify_api_version') is-invalid @enderror" name="shopify_api_version" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('Shopify_api_version') }}" placeholder="Shopify API version" required>
                            </div>
                            <label for="Checkout_LOGO">Shopify Currency symbol</label>
                            @error('shopify_currency') <span class="text-danger text-small">{{ $message }}</span> @enderror
                            <div class="input-group mb-3">
                                <input type="text" class="form-control py-lg-3 @error('shopify_currency') is-invalid @enderror" name="shopify_currency" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('Shopify_currency') }}" placeholder="Shopify Currency symbol" required>
                            </div>
                            <label for="Checkout_LOGO">Shopify Currency Code</label>
                            @error('shopify_currency_code') <span class="text-danger text-small">{{ $message }}</span> @enderror
                            <div class="input-group mb-3">
                                <input type="text" class="form-control py-lg-3 @error('shopify_currency_code') is-invalid @enderror" name="shopify_currency_code" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('Shopify_currency_code') }}" placeholder="Shopify Currency symbol" required>
                            </div>   
                    </div> 
                </div>
                
                        <div class="col-12 col-md-12 col-lg-6">
                        <h4>Shopify Ship from Address for Avalara</h4>
                    <div class="pe-lg-4 pb-4 pb-lg-0 mb-2 mb-lg-0">    
                            <label for="Checkout_LOGO">Shipping Address</label>
                            @error('shipping_address1') <span class="text-danger text-small">{{ $message }}</span> @enderror
                            <div class="input-group mb-3">
                                <input type="text" class="form-control py-lg-3 @error('shipping_address1') is-invalid @enderror" name="shipping_address1" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('shipping_address1') }}" placeholder="Shipping Address" required>
                            </div>
                            <label for="Checkout_LOGO">Shipping Address2</label>
                            @error('shipping_address2') <span class="text-danger text-small">{{ $message }}</span> @enderror
                            <div class="input-group mb-3">
                                <input type="text" class="form-control py-lg-3 @error('shipping_address2') is-invalid @enderror" name="shipping_address2" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('shipping_address2') }}" placeholder="Shipping Address2">
                            </div>
                            <label for="Checkout_LOGO">Shipping Address3</label>
                            @error('shipping_address3') <span class="text-danger text-small">{{ $message }}</span> @enderror
                            <div class="input-group mb-3">
                                <input type="text" class="form-control py-lg-3 @error('shipping_address3') is-invalid @enderror" name="shipping_address3" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('shipping_address3') }}" placeholder="Shipping Address3">
                            </div>
                            <label for="Checkout_LOGO">Shipping City</label>
                            @error('shipping_city') <span class="text-danger text-small">{{ $message }}</span> @enderror
                            <div class="input-group mb-3">
                                <input type="text" class="form-control py-lg-3 @error('shipping_city') is-invalid @enderror" name="shipping_city" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('shipping_city') }}" placeholder="Shipping City" required>
                            </div>
                            <label for="Checkout_LOGO">Shipping State</label>
                            @error('shipping_state') <span class="text-danger text-small">{{ $message }}</span> @enderror
                            <div class="input-group mb-3">
                                <input type="text" class="form-control py-lg-3 @error('shipping_state') is-invalid @enderror" name="shipping_state" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('shipping_state') }}" placeholder="Shipping State" required>
                            </div>
                            <label for="Checkout_LOGO">Shipping Postalcode</label>
                            @error('shipping_postalcode') <span class="text-danger text-small">{{ $message }}</span> @enderror
                            <div class="input-group mb-3">
                                <input type="text" class="form-control py-lg-3 @error('shipping_postalcode') is-invalid @enderror" name="shipping_postalcode" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('shipping_postalcode') }}" placeholder="Shipping Postalcode" required>
                            </div>   
                            <label for="Checkout_LOGO">Shipping Country</label>
                            @error('shipping_country') <span class="text-danger text-small">{{ $message }}</span> @enderror
                            <div class="input-group mb-3">
                                <input type="text" class="form-control py-lg-3 @error('shipping_country') is-invalid @enderror" name="shipping_country" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('shipping_country') }}" placeholder="Shipping Country" required>
                            </div>
                    </div> 
                </div>
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="input-group">
                        <button type="submit" class="btn btn-primary fw-bold text-uppercase py-2 px-4">Save</button>
                     </div>
                </div>
            </div>
        </form>
        </div>

    </div>
@endsection

@section('custom-js')

@endsection
