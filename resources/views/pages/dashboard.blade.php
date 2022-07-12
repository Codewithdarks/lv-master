@extends('layouts.panel.master')

@section('page-title', 'Dashboard')

@section('custom-css')

@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-6">
                <div class="page-title d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                    <h4 class="fw-bold">Dashboard</h4>
                </div>
            </div>
            <div class="col-6 col-md-6">
                <div class="row justify-content-end">
                    <div class="col-12 col-sm-12 col-md-6 col-xl-6">
                        <div class="form-group mb-3">
                            <label for="ChartRefresh">Duration of Statistics</label>
                            <select id="ChartRefresh" class="form-select">
                                <option value="1" selected>1 Week</option>
                                <option value="2">1 Month</option>
                                <option value="3">6 Month</option>
                                <option value="4">1 Year</option>
                                <option value="5">Yearly</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-3 p-md-4 p-lg-5 shadow-sm">
            <div class="row row-cols-1 row-cols-md-12 row-cols-lg-4 justify-content-center">
                <div class="col mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body shadow-sm">
                            <h5 class="fw-bold" id="NetSalesVal"></h5>
                            <p class="card-text">Net Sales</p>
                        </div>
                    </div>
                </div>
{{--                <div class="col mb-3">--}}
{{--                    <div class="card h-100 shadow-sm">--}}
{{--                        <div class="card-body shadow-sm">--}}
{{--                            <h5 class="fw-bold">--</h5>--}}
{{--                            <p class="card-text">Conversion</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="col mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body shadow-sm">
                            <h5 class="fw-bold" id="OrdersCount"></h5>
                            <p class="card-text">Orders</p>
                        </div>
                    </div>
                </div>
                <div class="col mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body shadow-sm">
                            <h5 class="fw-bold" id="AverageCalc"></h5>
                            <p class="card-text">Average order value</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-12 pt-5">
                    <div id="chartBox"></div>
                </div>
            </div>

        </div>

    </div>
@endsection

@section('custom-js')
    <script type="text/javascript">var urlPrefix = "{{ route('chart.data', '') }}";</script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script type="text/javascript" src="{{ asset('js/dashboard.js') }}"></script>
@endsection
