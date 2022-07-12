@extends('layouts.panel.master')

@section('page-title', 'Order Detail')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mb-3">
                    <div class="bg-holder d-none d-lg-block bg-card"></div>
                    <!--/.bg-holder-->
                    <div class="card-body position-relative">
                        <div class="row">
                            <div class="col-6">
                                <h5>Order Number: {{ $order['shopify_order_name'] }}</h5>
                                <p class="fs--1">{{ date('M d, Y, h:i A', strtotime($order['created_at'])) }}</p>
                                <div><strong class="me-2">Status: </strong>
                                    @if($order['cancel_reason'] !== null || $order['cancelled_at'] !== null)
                                        <div class="badge rounded-pill bg-danger fs-6">Cancelled</div>
                                    @else
                                        <div class="badge rounded-pill bg-primary fs-6">{{ $order['orders_status'] }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div><strong class="me-2">Fulfillment Status: </strong>
                                    @if($order['cancel_reason'] !== null || $order['cancelled_at'] !== null)
                                        <div class="badge rounded-pill bg-danger fs-6">Cancelled</div>
                                    @else
                                        <div class="badge rounded-pill bg-primary fs-6">{{ $order['fulfillment_status'] }}</div>
                                    @endif
                                </div>
                                <h6 class="mt-3 mb-1"><strong class="me-2">Name: </strong>{{ $order['name'] }}</h6>
                                <p> <strong>Email: </strong><a href="mailto:{{ $order['email'] }}">{{ $order['email'] }}</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                                <h5 class="mb-3 fs-0">Billing Address</h5>
                                <h6 class="mb-2">{{ $billing->first_name.' '.$billing->last_name ?? $order['name'] }}</h6>
                                <p class="mb-1 fs--1">{!! isset($billing->company) ? $billing->company.'<br>' : '' !!}{{ $billing->address1 ?? '' }}<br />{{ $billing->city ?? '' }},
                                    {{ $billing->province.', ' ?? '' }}{{ $billing->country.', ' ?? '' }}{{ $billing->zip ?? '' }}</p>
                                <p class="mb-0 fs--1"> <strong>Phone: </strong><a href="tel:{{ $shipping->phone ?? '' }}">{{ $shipping->phone ?? '' }}</a></p>
                            </div>
                            <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                                <h5 class="mb-3 fs-0">Shipping Address</h5>
                                <h6 class="mb-2">{{ $shipping->first_name.' '.$shipping->last_name ?? $order['name'] }}</h6>
                                <p class="mb-1 fs--1">{!! isset($shipping->company) ? $shipping->company.'<br>' : '' !!}{{ $shipping->address1 ?? '' }}<br />{{ $shipping->city ?? '' }},
                                    {{ $shipping->province.', ' ?? '' }}{{ $shipping->country.', ' ?? '' }}{{ $shipping->zip ?? '' }}</p>
                                <p class="mb-0 fs--1"> <strong>Phone: </strong><a href="tel:{{ $shipping->phone ?? '' }}">{{ $shipping->phone ?? '' }}</a></p>
                            </div>
                            @if($order['cancel_reason'] !== null || $order['cancelled_at'] !== null)
                                <div class="col-md-6 col-lg-4">
                                    <h5 class="mb-3 fs-0">Order Status</h5>
                                    <div class="d-flex">
                                        <div class="flex-1">
                                            <p class="mb-0"> <strong>Cancelled At: </strong>{{ date('M d, Y, h:i A', strtotime($order['cancelled_at'])) }}</p>
                                            <p class="mb-0"> <strong>Cancellation Reason: </strong>{{ $order['cancel_reason'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="table-responsive fs--1">
                            <table class="table table-striped border-bottom">
                                <thead class="bg-200 text-900">
                                <tr>
                                    <th class="border-0">Products</th>
                                    <th class="border-0 text-center">Quantity</th>
                                    <th class="border-0 text-end">Unit Price</th>
                                    <th class="border-0 text-end">Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($products as $product)
                                    <tr class="border-200">
                                        <td class="align-middle d-flex align-content-center">
                                            <img class="img-fluid rounded-1 me-3 d-none d-md-block" src="{{ $product->image }}" alt="" width="45">
                                            <h6 class="mb-0">{{ $product->title }}</h6>
                                        </td>
                                        <td class="align-middle text-center">{{ $product->quantity }}</td>
                                        <td class="align-middle text-end">${{ sprintf("%.2f", $product->final_price/100) }}</td>
                                        <td class="align-middle text-end">${{ sprintf("%.2f", $product->quantity*($product->final_price/100)) }}</td>
                                    </tr>
                                @empty
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="row g-0 justify-content-end">
                            <div class="col-auto">
                                <table class="table table-sm table-borderless fs--1 text-end">
                                    <tr>
                                        <th class="text-900">Subtotal:</th>
                                        <td class="fw-semi-bold">${{ $order['subtotal_price'] ?? '0' }} </td>
                                    </tr>
                                    @if($order['shipping'] !== null)
                                        <tr>
                                            <th class="text-900">Shipping:</th>
                                            <td class="fw-semi-bold">{{ $order['shipping']>=1 ? '$'.$order['shipping'] : 'Free' }}</td>
                                        </tr>
                                    @endif
                                    @if($discount !== null)
                                        @if($discount->type == 'percentage')
                                            <tr>
                                                <th class="text-900">Discount<span class="text-muted text-uppercase">{{ $discount->code ? ' ('.$discount->code.')' : '' }}</span>:</th>
                                                <td class="fw-semi-bold">${{ $discount->amount ? sprintf("%.2f", ($order['subtotal_price']/100)*$discount->amount) : '0' }}</td>
                                            </tr>
                                        @endif
                                        @if($discount->type == 'fixed_amount')
                                            <tr>
                                                <th class="text-900">Discount<span class="text-muted text-uppercase">{{ $discount->code ? ' ('.$discount->code.')' : '' }}</span>:</th>
                                                <td class="fw-semi-bold">${{ $discount->amount ? sprintf("%.2f", $discount->amount) : '0'}}</td>
                                            </tr>
                                        @endif
                                    @endif
                                    @if($order['tax'] !== null)
                                        <tr>
                                            <th class="text-900">Tax:</th>
                                            <td class="fw-semi-bold">${{ $order['tax'] ?? '0' }}</td>
                                        </tr>
                                    @endif
                                    <tr class="border-top">
                                        <th class="text-900">Total:</th>
                                        <td class="fw-semi-bold">${{ $order['total_price'] ?? '0' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
