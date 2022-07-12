@extends('layouts.panel.master')

@section('page-title', 'Payment Providers')

@section('custom-css')

@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="page-title d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                    <h4 class="fw-bold">Payment Providers</h4>
                </div>
            </div>
        </div>

        <div class="bg-white p-3 p-md-4 p-lg-5 shadow-sm">

            <div class="row row-cols-1 row-cols-lg-4 align-items-start payment-outer">
                <div class="col pe-lg-0">
                    <div class="payment-tab border border-end-0 rounded-start text-center bg-white py-5 px-4">
                        <img src="{{ asset('images/stripe_logo.png') }}" alt="" width="90">
                        <h6 class="m-0 p-0">Preferred payment processor</h6>
                    </div>
                </div>

                <div class="col col-lg-9 ps-lg-0">
                    <div class="payment-provider border rounded-end py-2 py-lg-5 px-4">
                        <img src="{{ asset('images/stripe_logo.png') }}" alt="" width="90" class="d-none d-lg-block">

                        <div class="payment-select pt-0 pt-lg-5 d-flex justify-content-lg-end justify-content-center">

                            <div class="form-check form-switch d-flex h6 justify-content-between align-content-center text-center p-0">
                                <span>Sandbox</span>
                                <span><label for="ProductionSandbox"></label><input class="form-check-input" type="checkbox" id="ProductionSandbox" @if(isset($provider['status'])){{ $provider['status'] == 'production' ? 'checked' : '' }}@endif><input type="hidden" id="CheckBoxCSRF" value="{{ csrf_token() }}"></span>
                                <span>Production</span>
                            </div>
                        </div>

                        <div class="payment-form pt-4" id="production" style="display: none;">
                            <form name="">
                                <input type="hidden" id="production_csrf_token" value="{{ csrf_token() }}" name="_token">
                                <div class="input-group mb-3">
                                    <input type="text" name="production_secret_key" id="StripeProductionSecret" value="@if(isset($provider['key'])){{ trim($provider['key']->production_secret) }}@endif" class="form-control py-lg-3" placeholder="Production Secret key" aria-label="Secret key" aria-describedby="basic-addon1">
                                </div>
                                <div class="input-group mb-3">
                                    <input type="text" name="production_share_key" value="@if(isset($provider['key'])){{ $provider['key']->production_publishable }}@endif" id="StripeProductionShow" class="form-control py-lg-3" placeholder="Production Publishable key" aria-label="Publishable key" aria-describedby="basic-addon1">
                                </div>

                                <button type="button" id="productionSubmit" class="btn btn-primary fw-bold text-uppercase py-2 px-4">Submit</button>
                            </form>
                        </div>
                        <div class="payment-form pt-4" id="sandbox" style="display: none;">
                            <form name="">
                                <input type="hidden" id="sandbox_csrf_token" value="{{ csrf_token() }}" name="_token">
                                <div class="input-group mb-3">
                                    <input type="text" id="SandBoxSecret" name="sandbox_secret_key" value="@if(isset($provider['key'])){{ $provider['key']->sandbox_secret }}@endif" class="form-control py-lg-3" placeholder="Sandbox Secret key" aria-label="Secret key" aria-describedby="basic-addon1">
                                </div>
                                <div class="input-group mb-3">
                                    <input type="text" id="SandBoxShow" name="sandbox_share_key" value="@if(isset($provider['key'])){{ $provider['key']->sandbox_publishable }}@endif" class="form-control py-lg-3" placeholder="Sandbox Publishable key" aria-label="Publishable key" aria-describedby="basic-addon1">
                                </div>
                                <button type="button" id="sandboxSubmit" class="btn btn-primary fw-bold text-uppercase py-2 px-4">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection

@section('custom-js')
<script type="text/javascript">
    const SubmitURL = "{{ route('payment.key') }}";
    const ChangeState = "{{ route('payment.state') }}";
</script>
<script type="text/javascript" src="{{ asset('js/paymentsetting.js') }}"></script>
@endsection
