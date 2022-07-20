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
                <div class="profile-logo-upload pe-lg-4 pb-4 pb-lg-0 mb-2 mb-lg-0">
                    <form name="" action="{{ route('page.setting') }}" method="post">@csrf
                        <div class="row mb-5">
                            <div class="col-6 col-md-6 col-lg-6">
                                <label for="logo">Logo</label>
                                @error('logo') <br><span class="text-danger text-small">{{ $message }}</span> @enderror
                                <div class="input-group mb-3">
                                    <input type="url" class="form-control py-lg-3 @error('logo') is-invalid @enderror" name="logo" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('logo') }}" placeholder="Logo URL, i.e - https://www.someurl.com/logo.png" aria-label="Logo URL" aria-describedby="basic-addon1" required>
                                </div>
                            </div>
                            <div class="col-6 col-md-6 col-lg-6">
                                <label for="favicon">Favicon</label>
                                @error('favicon') <span class="text-danger text-small">{{ $message }}</span> @enderror
                                <div class="input-group mb-3">
                                    <input type="url" class="form-control py-lg-3 @error('favicon') is-invalid @enderror" name="favicon" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('favicon') }}" placeholder="Favicon URL, i.e - https://www.someurl.com/icon.ico" aria-label="Favicon URL" aria-describedby="basic-addon1" required>
                                </div>
                            </div>
                            <div class="col-6 col-md-6 col-lg-6">
                                <label for="header_text">Shipping Note</label>
                                @error('shipping_note') <span class="text-danger text-small">{{ $message }}</span> @enderror
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control py-lg-3 @error('shipping_note') is-invalid @enderror" name="shipping_note" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('shipping_note') }}" placeholder="Shipping Note Information" aria-label="L" aria-describedby="basic-addon1" required>
                                </div>
                            </div>
                            <div class="col-6 col-md-6 col-lg-6">
                                <label for="Checkout_LOGO">Checkout Secure Logo</label>
                                @error('checkout_secure_logo') <span class="text-danger text-small">{{ $message }}</span> @enderror
                                <div class="input-group mb-3">
                                    <input type="url" class="form-control py-lg-3 @error('checkout_secure_logo') is-invalid @enderror" name="checkout_secure_logo" value="{{ (new \App\Http\Controllers\SettingsController)->RetrieveValue('checkout_secure_logo') }}" placeholder="Checkout Secure logo" aria-label="" aria-describedby="basic-addon1" required>
                                </div>
                            </div>
                            <div class="input-group d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary fw-bold text-uppercase py-2 px-4">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-12 col-md-12 col-lg-12">
                    <div class="page-title d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
                        <h5 class="fw-bold">Why Choose Us</h5>
                        <button style="margin-left: 50px" class="btn btn-primary" type="submit" id="append" name="append">
                            Add New</button>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="row inc">
                        @php
                            $count = 0;
                        @endphp
                        @for($i = 1; $i<5; $i++)
                            @php
                                $exist = \App\Models\StoreSettings::where(['option_name' => 'choose-'.$i])->first();
                            @endphp
                            @if(!is_null($exist) || !empty($exist))
                                @php
                                    $count = $count + 1;
                                    $data = json_decode($exist->option_value);
                                @endphp
                        <div class="col-6 col-md-6 col-lg-6">
                            <form action="{{ route('why.update', $exist->id) }}" enctype="multipart/form-data" method="POST">@csrf
                                <input type="hidden" name="option_name" value="choose-1">
                                <input type="hidden" name="choose" value="$exist->id">

                                <div class="px-4 py-4" >
                                    <div class="row">
                                        <h6 class="fw-bold mb-4">Why Choose Us - {{ $i }}</h6>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <input type="text" name="title" class="form-control" placeholder="Enter Option name" value="{{ $data->title }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <input type="url" class="form-control" id="exampleInput" name="image" placeholder="enter image url" value="{{ $data->image }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <input type="text" class="form-control" id="exampleInput" name="description" placeholder="checkout description" value="{{ $data->description }}">
                                            </div>
                                        </div>
                                        <div class="col-3 mb-3">
                                            <input type="submit" value="Update" style="color:white;" class="btn bg-primary">
                                        </div>
                                        <div class="col-3 mb-3">
                                            <a href="{{ route('why.delete', $exist->id) }}" style="color:white;"  class="btn bg-danger">Delete</a>
                                            <form action="{{ route('why.delete', $exist->id) }}" method="POST" id="delNum{{$exist}}">@csrf</form>
                                            <script type="text/javascript">
                                                document.getElementById('delkey{{ $exist }}').addEventListener('click',function (e){
                                                    e.preventDefault();
                                                    document.getElementById('delNum{{$exist}}').submit();
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                            @else
                            @endif
                        @endfor
                        @if($count == 0)
                            <div class="col-6 col-md-6 col-lg-6">
                                <form action="{{ route('why.create') }}" enctype="multipart/form-data" method="POST">@csrf
                                    <input type="hidden" name="option_name" value="choose-1">
                                    <div class="px-4 py-4" >
                                        <div class="row">
                                            <h6 class="fw-bold mb-4">Why Choose Us - 1</h6>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <input type="text" name="title" class="form-control" placeholder="Enter Option name">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <input type="url" class="form-control" id="exampleInput" name="image" placeholder="enter image url">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <input type="text" class="form-control" id="exampleInput" name="description" placeholder="checkout description">
                                                </div>
                                            </div>
                                            <div class="col-3 mb-3">
                                                <input type="submit" value="Creeate" style="color:white;" class="btn bg-primary">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="page-title d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
                            <h5 class="fw-bold">Review Us</h5>
                            <button style="margin-left: 50px" class="btn btn-primary" type="submit" id="append1" name="append1">
                                Add New</button>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="row inc1">
                            @php
                                $kount = 0;
                            @endphp
                            @for($i = 1; $i<5; $i++)
                                @php
                                    $exist = \App\Models\StoreSettings::where(['option_name' => 'review-'.$i])->first();
                                @endphp
                                @if(!is_null($exist) || !empty($exist))
                                    @php
                                    $kount = $kount + 1;
                                    $data = json_decode($exist->option_value);
                                    @endphp
                                    <div class="col-6 col-md-6 col-lg-6">
                                        <form action="{{ route('why.update', $exist->id) }}" enctype="multipart/form-data" method="POST">@csrf
                                            <input type="hidden" name="option_name" value="review-1">
                                            <div class="px-4 py-4" >
                                                <div class="row">
                                                    <h6 class="fw-bold mb-4">Review - {{ $i }}</h6>
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <input type="text" name="title" class="form-control" placeholder="Enter Option name" value="{{ $data->title }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <input type="url" class="form-control" id="exampleInput" name="image" placeholder="enter image url" value="{{ $data->image }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <input type="text" class="form-control" id="exampleInput" name="description" placeholder="checkout description" value="{{ $data->description }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-3 mb-3">
                                                        <input type="submit" value="update" style="color:white;" class="btn bg-primary">

                                                    </div>
                                                    <div class="col-3 mb-3">
                                                        <a href="{{ route('why.delete', $exist->id) }}" style="color:white;"  class="btn bg-danger">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                @else
                                @endif
                            @endfor
                            @if($kount == 0)
                                <div class="col-6 col-md-6 col-lg-6">
                                    <form action="{{ route('why.create') }}" enctype="multipart/form-data" method="POST">@csrf
                                        <input type="hidden" name="option_name" value="review-1">
                                        <div class="px-4 py-4" >
                                            <div class="row">
                                                <h6 class="fw-bold mb-4">Review - 1</h6>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <input type="text" name="title" class="form-control" placeholder="Enter Option name">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <input type="url" class="form-control" id="exampleInput" name="image" placeholder="enter image url">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" id="exampleInput" name="description" placeholder="checkout description">
                                                    </div>
                                                </div>
                                                <div class="col-3 mb-3">
                                                    <input type="submit" value="create" style="color:white;" class="btn bg-primary">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('custom-js')

                <script>
                    $(document).ready( function () {
                        var i= {{ $count }};
                        $("#append").click( function(e) {
                            e.preventDefault();
                             i=i+1;
                               if(i<5){
                                   $(".inc").append('<div class="col-6 col-md-6 col-lg-6">\
                                       <form action="{{ route('why.create') }}" enctype="multipart/form-data" method="POST">@csrf\
                                       <input type="hidden" name="option_name" value="choose-'+[i]+'">\
                                       <div class="px-4 py-4"><div class="row">\
                                <h6 class="fw-bold mb-4">Why Choose Us - '+[i]+'</h6>\
                                <div class="col-6">\
                                    <div class="mb-3">\
                                        <input type="text" name="title" class="form-control" placeholder="Enter Option name">\
                                    </div>\
                                </div>\
                                <div class="col-6">\
                                    <div class="mb-3">\
                                        <input type="url" accept="image/*" class="form-control" id="exampleInput" name="image" placeholder="enter image url">\
                                    </div>\
                                </div>\
                                <div class="col-9">\
                                    <div class="mb-3">\
                                        <input type="text" class="form-control" id="exampleInput" name="description" placeholder="checkout description">\
                                    </div>\
                                </div>\
                                <div class="col-3">\
                                <div class="mb-3">\
                                    <input type="submit" value="create" style="color:white;" class="btn bg-primary">\
                                </div>\
                            </div>\
                            <div class="col-3">\
                                <div class="d-flex justify-content-end align-items-center">\
                                </div>\
                            </div>\
                        </div>\
                        <a href="#" class="remove_this btn btn-danger mb-3">remove</a></div></form></div>');
                                   return false;
                               }

                        });

                        $(document).on('click', '.remove_this', function() {
                            $(this).parent().remove();
                            return false;
                        });

                    });

                </script>

                <script>
                    $(document).on("click", "#save", function(e) {

                        e.preventDefault(); // Prevent Default form Submission

                        $.ajax({
                            type:"post",
                            url: '/Users/message',
                            data: $("#message").serialize(),
                            success:function(store) {
                                location.href = store;
                            },
                            error:function() {
                            }
                        });

                    });

                </script>

                <script>
                    $(document).ready( function () {
                        var i= {{ $kount }};
                        $("#append1").click( function(e) {
                            e.preventDefault();
                            i=i+1;
                            if(i<5){
                                $(".inc1").append('<div class="col-6 col-md-6 col-lg-6">\
                                       <form action="{{ route('why.create') }}" enctype="multipart/form-data" method="POST">@csrf\
                                       <input type="hidden" name="option_name" value="review-'+[i]+'">\
                                       <div class="px-4 py-4"><div class="row">\
                            <h6 class="fw-bold mb-4">Review - '+[i]+'</h6>\
                            <div class="col-6">\
                                <div class="mb-3">\
                                    <input type="text" name="title" class="form-control" placeholder="Enter Option name">\
                                </div>\
                            </div>\
                            <div class="col-6">\
                                <div class="mb-3">\
                                    <input type="url" accept="image/*" class="form-control" id="exampleInput" name="image" placeholder="enter image url">\
                                </div>\
                            </div>\
                            <div class="col-9">\
                                <div class="mb-3">\
                                    <input type="text" class="form-control" id="exampleInput" name="description" placeholder="checkout description">\
                                </div>\
                            </div>\
                            <div class="col-3">\
                                <div class="mb-3">\
                                    <input type="submit" value="create" style="color:white;" class="btn bg-primary">\
                                </div>\
                            </div>\
                            <div class="col-3">\
                                <div class="d-flex justify-content-end align-items-center">\
                                </div>\
                            </div>\
                        </div>\
                        <a href="#" class="remove_this btn btn-danger mb-3">remove</a></div></form></div>');
                                return false;
                            }

                        });

                        $(document).on('click', '.remove_this1', function() {
                            $(this).parent().remove();
                            return false;
                        });

                    });

                </script>
@endsection
