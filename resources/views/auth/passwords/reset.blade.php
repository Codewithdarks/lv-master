@extends('layouts.app')
@section('title','Reset Password')
<style>
.bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
html,
body {
  height: 100%;
}

body {
  display: flex;
  align-items: center;
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #f5f5f5;
}

.form-signin {
  width: 100%;
  max-width: 330px;
  padding: 15px;
  margin: auto;
}

.form-signin .checkbox {
  font-weight: 400;
}

.form-signin .form-floating:focus-within {
  z-index: 2;
}

.form-signin input[type="password"], .form-signin input[type="email"] {
  margin-bottom: 10px;

}
</style>
@section('content')
<main class="form-signin text-center">
  <form method="POST" action="{{ route('password.update') }}">
  @csrf

                        <input type="hidden" name="token" value="{{ $token }}">
    <img class="mb-4" src="/images/logo.png" alt="" width="200">
    <h1 class="h3 mb-3 fw-normal">Sign in</h1>

    <div class="form-floating">
      <input id="floatingEmail" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="Email Address">
      <label for="floatingEmail">Email address</label>
	  
    </div>
	@error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
    <div class="form-floating">
      <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
	  
    </div>
 @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
    <div class="form-floating">
      <input type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password" id="floatingConfirmPassword" placeholder="Confirm Password">
      <label for="floatingConfirmPassword">Confirm Password</label>
	  
    </div>
 
    
    <button class="w-100 btn btn-lg btn-primary" type="submit">{{ __('Reset Password') }}</button>
     
  </form>
</main>
@endsection