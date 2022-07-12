@extends('layouts.panel.master')

@section('page-title', 'Track Codes')

@section('custom-css')

@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="page-title d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                    <h4 class="fw-bold">Global Tracking Codes</h4>
                </div>
            </div>
        </div>

        <div class="bg-white p-3 p-md-4 p-lg-5 shadow-sm">

            <div class="row">

                <div class="col-12 col-md-12 col-lg-12">
                    <div class="alert alert-warning d-flex" role="alert">
                        <svg class="bi flex-shrink-0 me-2" xmlns="http://www.w3.org/2000/svg" fill="#664d03" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M12 5.177l8.631 15.823h-17.262l8.631-15.823zm0-4.177l-12 22h24l-12-22zm-1 9h2v6h-2v-6zm1 9.75c-.689 0-1.25-.56-1.25-1.25s.561-1.25 1.25-1.25 1.25.56 1.25 1.25-.561 1.25-1.25 1.25z" />
                        </svg>
                        <div>
                            <h6 class="fw-bold">Warning</h6>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-12 col-lg-12">


                    <form action="{{ route('store.global') }}" method="post">@csrf
                        <h5 class="fw-bold mb-3">Checkout Page</h5>
                        <div class="input-group mb-3">
                            <textarea class="form-control bg-dark text-white resize" name="checkout_page" rows="6">{{ (new \App\Http\Controllers\GlobalCodeController)->RetrieveCodeValue('checkout_page') }}</textarea>
                        </div>

                        <h5 class="fw-bold mb-3">Thank you Page</h5>
                        <div class="input-group mb-3">
                            <textarea class="form-control bg-dark text-white resize" name="thanks_page" rows="6">{{ (new \App\Http\Controllers\GlobalCodeController)->RetrieveCodeValue('thanks_page') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary fw-bold text-uppercase py-2 px-4">Save</button>
                    </form>


                </div>
            </div>

        </div>

    </div>
@endsection

@section('custom-js')

@endsection
