@extends('layouts.auth')

@section('content')
<br>
<br><br><br><br>
<br><br><br>
   <h2>Insurance Brokrage</h2>
           <!--  -->
            <p>Login in. To see it in action.</p>
                    <form class="m-t" method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                       
                                <input id="email" placeholder="Email Address" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                           
                        </div>

                        <div class="form-group">                         
                           
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                           
                        </div>

                        <div class="form-group">
                            
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                          
                        </div>

                          <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                <a href="{{ route('password.request') }}"><small>Forgot password?</small></a>
                <!-- <p class="text-muted text-center"><small>Do not have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="{{ route('register') }}">Create an account</a> -->
            </form>

                    

@endsection
