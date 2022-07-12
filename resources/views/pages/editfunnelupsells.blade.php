@extends('layouts.panel.master')

@section('page-title', 'Funnel Upsells')

@section('custom-css')

@endsection

@section('content')


<div class="container">
    <div class="row">
      <div class="col-12 col-md-12">
        <div
          class="page-title edit-funnel-title d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
          <div class="funnel-name d-flex flex-wrap align-items-center">
              <h4 class="fw-bold">Funnel Name:</h4>
              <div class="funnel-title">{{ $funnelname }}</div>
              <button class="btn click-to-edit ms-2"><i class="fas fa-edit"></i></button>
              <button class="btn btn-light click-to-update updatefunnelinfo" style="display: none;">Update</button>
              <button class="btn btn-link click-to-cancel" style="display: none;">Cancel</button>
          </div>
          <div class="funnel-name d-flex flex-wrap align-items-center">
            <h4 class="fw-bold">Tag:</h4>
            <div class="funnel-title">{{ $funneltag }}</div>
            <button class="btn click-to-edit ms-2"><i class="fas fa-edit"></i></button>
            <button class="btn btn-light click-to-update updatefunnelinfo" style="display: none;">Update</button>
            <button class="btn btn-link click-to-cancel" style="display: none;">Cancel</button>
        </div>
        </div>
      </div>
    </div>

    <div class="bg-white p-3 p-md-4 shadow-sm">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-5">
          <div class="funnel-listing">
            <div class="listing-main mb-4">
              <div class="list-item d-flex align-items-center px-3 py-3">
                <div class="list-item-icon">
                  <i class="fab fa-shopify"></i>
                </div>
                <div class="list-item-content">
                  <h5>Your Shopify cart</h5>
                </div>
              </div>
            </div>
            <div class="listing-main mb-4">
              <div class="list-item d-flex align-items-center px-3 py-3">
                <div class="list-item-icon">
                  <i class="fab fa-shopify"></i>
                </div>
                <div class="list-item-content">
                  <h5>One page checkout</h5>
                </div>
              </div>
            </div>
            @foreach ($funnelupdnsells as $funnelupdnsell)
            <div class="listing-main updownsellgroup_{{ $loop->iteration }} mb-4">
                <div class="list-item d-flex align-items-center px-3 py-3 mb-4 upsell{{ $loop->iteration }}">
                  <div class="list-item-icon">
                    <img src="{{ asset('images/upsell.svg') }}" alt="">
                  </div>
                  <div class="list-item-content">
                    <h5>Upsell</h5>
                    <p>{{ $funnelupdnsell['upshopify_productname'] }}</p>
                  </div>
                  <div class="list-item-button">
                    <ul>
                      <li>
                        <a href="javascript:void(0)" class="view-btn" data-id="{{ $funnelupdnsell['upid'] }}" data-type="upsell"><i class="fas fa-eye"></i></a>
                      </li>
                      <li>
                        <a href="javascript:void(0)" class="edit-btn" data-id="{{ $funnelupdnsell['upid'] }}" data-type="upsell"><i class="fas fa-edit"></i></a>
                      </li>
                      <li>
                        <a href="javascript:void(0)" class="deleteupsell" data-id="{{ $funnelupdnsell['upid'] }}" data-type="upsell"><i class="fas fa-trash-alt"></i></a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="downsell ml-70 downsell{{ $loop->iteration }}">
                  @if($funnelupdnsell['dnshopify_productname']!='')
                  <div class="list-item d-flex align-items-center px-3 py-3">
                    <div class="list-item-icon">
                      <img src="{{ asset('images/downsell.svg') }}" alt="">
                    </div>
                    <div class="list-item-content">
                      <h5>Downsell</h5>
                      <p>{{ $funnelupdnsell['dnshopify_productname'] }}</p>
                    </div>
                    <div class="list-item-button">
                      <ul>
                        <li>
                          <a href="javascript:void(0)" class="view-btn" data-id="{{ $funnelupdnsell['dnid'] }}" data-type="downsell"><i class="fas fa-eye"></i></a>
                        </li>
                        <li>
                          <a href="javascript:void(0)" class="edit-btn" data-parentupsellid="{{ $funnelupdnsell['upid'] }}" data-id="{{ $funnelupdnsell['dnid'] }}" data-type="downsell"><i class="fas fa-edit"></i></a>
                        </li>
                        <li>
                          <a href="javascript:void(0)" class="deletedownsell" data-id="{{ $funnelupdnsell['dnid'] }}" data-type="downsell"><i class="fas fa-trash-alt"></i></a>
                        </li>
                      </ul>
                    </div>
                  </div>
                  @else
                  <div class="add-updnsell add-dnsell ml-70">
                    <div class="list-item d-flex align-items-center px-3">
                      <div class="list-item-icon">+</div>
                      <div class="list-item-content"><p>Add an downsell</p></div>
                    </div>
                  </div>
                  @endif
                </div>
              </div>
            @endforeach
            <div class="listing-main mb-4">
              <div class="add-updnsell add-upsell ml-70">
                <div class="list-item d-flex align-items-center px-3">
                  <div class="list-item-icon">
                    +
                  </div>
                  <div class="list-item-content">
                    <p>Add an upsell</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="listing-main mb-4">
              <div class="list-item d-flex align-items-center px-3 py-3">
                <div class="list-item-icon">
                  <i class="far fa-heart"></i>
                </div>
                <div class="list-item-content">
                  <h5>Thank you Page</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-12 col-lg-1"></div>
        <div class="col-12 col-md-12 col-lg-6">
          <div class="product-column">
            <form action="{{ route('saveupsell.funnel') }}" id="saveupdnsellform">
            <input type="hidden" name="funnelid" value="{{ $funnelId }}"/>
            <input type="hidden" name="upselldownid" value=""/>
            <input type="hidden" name="parentupsellid" value=""/>
            <input type="hidden" name="upselltype" value=""/>
            <input type="hidden" name="shopify_productname" value=""/>
            <input type="hidden" name="shopify_productid" value=""/>
            <input type="hidden" name="shopify_producthandle" value=""/>
            @csrf
            
              <div class="mb-4" style="position:relative;">
                <input type="text" id="productname" name="productname" class="form-control py-lg-3" placeholder="Search Product By Name" autocomplete="off">
                <div class="search-dropdown" >
                  
                  </div>
              </div>
            

            <div class="product-detail d-flex justify-content-between mb-4">
              
            </div>

            <div class="discount-offer" style="visibility: hidden;">
              <h4 class="mb-3">Discount you offer</h4>
              <div class="discount-form d-flex align-items-center">
                <div class="discount-field">
                  <input type="number" id="discountamount" name="discountamount" class="form-control py-lg-2" placeholder="Value">
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="discounttype" id="PercentageRadio" value="Percentage">
                  <label class="form-check-label" for="PercentageRadio">
                    Percentage
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="discounttype" id="FixedRadio" value="Fixed">
                  <label class="form-check-label" for="FixedRadio">
                    Fixed
                  </label>
                </div>
              </div>
            </div>

            <div class="actiongroupupdnll btn-outer mt-3 d-flex align-items-center justify-content-between"  style="visibility: hidden;">
              <button type="button" class="btn btn-lg preview-btn" data-id="" data-type="">Preview</button>
              <button type="submit" id="savefunnelupdosell" class="btn btn-lg btn-success">Save</button>
              <button type="button" class="btn btn-lg btn-outline-danger" onClick="window.location.reload();">Cancel</button>
            </div>
            </form>
          </div>
        </div>

        <div class="save-btn-outer mt-4 d-flex align-items-center">
          <button id="savefunnelmain" data-success="{{ route('upsellfunnels') }}" type="button" class="btn btn-lg btn-success">Save Funnel</button>
          <a href="{{ route('upsellfunnels') }}" class="btn btn-lg btn-outline-danger">Cancel</a>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('custom-js')
<script type="text/javascript">var UPDATEURL = "{{ route('update.funnel') }}";</script>
<script type="text/javascript">var GETUPSELLURL = "{{ route('getupdownsell.funnel') }}";</script>
<script type="text/javascript">var SAVEUPSELLURL = "{{ route('saveupdownsell.funnel') }}";</script>
<script type="text/javascript">var ENABLEFUNNELURL = "{{ route('enable.funnel') }}";</script>
<script type="text/javascript">var DELETEFUNNELURL = "{{ route('deleteupdownsell.funnel') }}";</script>
<script type="text/javascript">var CHECKOUTDOMAIN = "{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('checkout_domain') }}";</script>
<script type="text/javascript" src="{{ asset('js/add_edit_upsell.js') }}"></script>
@endsection
