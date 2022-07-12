@extends('layouts.panel.master')

@section('page-title', 'Checkout Dashboard - Password Change')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="page-title d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                    <h4 class="fw-bold">Password Change</h4>
                </div>
            </div>
        </div>

        <div class="bg-white p-3 p-md-4 p-lg-5 shadow-sm">

            <div class="row justify-content-center">
                <div class="col-12 col-md-12 col-lg-6">
                    <div class="profile-logo-upload pe-lg-4 pb-4 pb-lg-0 mb-2 mb-lg-0">
                        <form action="{{ route('password.change.post') }}" method="post">@csrf
                            <label for="" class="form-label">Enter your current password</label>
                            <div class="input-group mb-0">
                                <input type="password" class="form-control py-lg-3 @error('current_password') is-invalid @enderror" name="current_password" placeholder="Enter your current password" aria-label="Current Password" aria-describedby="current_password" required>
                            </div>
                            @error('current_password') <span class="text-danger text-small">{{ $message }}</span> @enderror
                            <br>

                            <label for="" class="form-label">Enter New Password</label>
                            <div class="input-group mb-0">
                                <input type="password" class="form-control py-lg-3 @error('password') is-invalid @enderror" name="password" placeholder="Enter new password" aria-label="New Password" aria-describedby="new password" required>
                            </div>
                            @error('password') <span class="text-danger text-small">{{ $message }}</span> @enderror
                            <br>

                            <label for="" class="form-label">Confirm New Password</label>
                            <div class="input-group mb-0">
                                <input type="password" class="form-control py-lg-3 @error('confirm_password') is-invalid @enderror" name="confirm_password" placeholder="Confirm new password" aria-label="Confirm Password" aria-describedby="confirm password" required>
                            </div>
                            @error('confirm_password') <span class="text-danger text-small">{{ $message }}</span> @enderror

                            <div class="input-group mt-3 justify-content-center">
                                <button type="submit" class="btn btn-primary fw-bold text-uppercase py-2 px-4">Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
