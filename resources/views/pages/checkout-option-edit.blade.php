@extends('layouts.panel.master')

@section('page-title', 'Create Page')

@section('content')
    <div class="container">
        <main>
            <form action="{{ route('checkout.update', $checkout_update->id) }}" method="POST">@csrf
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="page-title d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                                <h4 class="fw-bold">Create pages</h4>
                                <a href="{{ route('checkout.list') }}" class="btn btn-primary btn-lg">Back to options</a>
                            </div>
                        </div>
                    </div>
                    <div class="grey-bg px-4 py-4 mb-4 shadow-sm m-5">
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-3">
                                    <input type="text" name="option_name" class="form-control" value="{{ $checkout_update['option_name'] }}" placeholder="Enter Option name">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="exampleInput" name="option_value" value="{{ $checkout_update['option_value'] }}" placeholder="checkout description">
                                </div>
                            </div>
                            <div class="col-4 ">

                                <select name="option_for" id="SelectUsage" class="form-select">
                                    <option value="">Select Usage</option>
                                    <option value="checkout_page_why" @if($checkout_update['option_for'] == 'checkout_page_why') selected @endif>Why Choose Us</option>
                                    <option value="checkout_page_review" @if($checkout_update['option_for'] == 'checkout_page_review') selected @endif>Review</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-6">
                            <div class="d-flex justify-content-end align-items-center">
                                <input type="submit" value="submit" class="btn btn-primary btn-lg">
                            </div>
                        </div>
                    </div>
                </div>
    </div>
    </form>
    </main>
    </div>
@endsection

@section('custom-js')
    <script type="text/javascript">var URL = "{{ route('upsellfunnels') }}";</script>
    <script type="text/javascript" src="{{ asset('js/upsellfunnels.js') }}"></script>
@endsection


{{--@extends('layouts.app')--}}
{{--@section('content')--}}
{{--    <div class="container w-50">--}}
{{--    <form action="{{ route('checkout.option') }}" method="POST"> @csrf--}}
{{--        <div class="form-group">--}}
{{--            <label for="exampleInputEmail1">Title</label>--}}
{{--            <input type="text" class="form-control" id="exampleInputEmail1" name="option_name" aria-describedby="emailHelp" placeholder="checkout title">--}}
{{--        </div>--}}
{{--        <div class="form-group m-1">--}}
{{--            <label for="exampleInputPassword1">Description</label>--}}
{{--            <input type="text" class="form-control" id="exampleInput" name="option_value" placeholder="checkout description">--}}
{{--        </div>--}}
{{--        <div class="form-group m-1">--}}
{{--            <label for="SelectUsage">Select Usage</label>--}}
{{--            <select name="option_for" id="SelectUsage" class="form-select">--}}
{{--                <option value="">Select Usage</option>--}}
{{--                <option value="checkout_page_why">Why Choose Us</option>--}}
{{--                <option value="checkout_page_review">Review</option>--}}
{{--            </select>--}}
{{--        </div>--}}
{{--        <button type="submit" class="btn btn-primary">Submit</button>--}}
{{--    </form>--}}
{{--    </div>--}}
{{--@endsection--}}
