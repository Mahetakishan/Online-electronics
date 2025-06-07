@extends('commonpages/usrlayout')

@section('space-work')


<div class="auth-wrapper">
	<div class="auth-content">
		<div class="card">
			<div class="row align-items-left text-left">
				<div class="col-md-12">
					<div class="card-body">
					
            
            @if(Session::has('success'))
     
           <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
						<h4 class="mb-3 f-w-400">Signin</h4>
            <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
							<label class="floating-label" for="Email">Name</label>
							<input type="text" class="form-control" id="Name" placeholder="Enter name" name="name">
							<div style="color:red;">{{ $errors->first('name') }}</div>
						</div>
						<div class="form-group mb-3">
							<label class="floating-label" for="Email">Email address</label>
							<input type="text" class="form-control" id="Email" placeholder="Enter email" name="email">
							<div style="color:red;">{{ $errors->first('email') }}</div>
						</div>
						<div class="form-group mb-4">
							<label class="floating-label" for="Password">Password</label>
							<input type="password" class="form-control" id="Password" placeholder="Enter password" name="password">
							<div style="color:red;">{{ $errors->first('password') }}</div>
						</div>
                        <div class="form-group mb-4">
							<label class="floating-label" for="Password">Confirm Password</label>
							<input type="password" class="form-control" id="password_confirmation" placeholder="Enter confirm password" name="password_confirmation">
						</div>
					
						<button class="btn btn-block btn-primary mb-4">Sign up</button>
					
						<p class="mb-0 text-muted">Don’t have an account? <a href="/login" class="f-w-400">Sign In</a></p>
           </form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- [ auth-signin ] end -->

@endsection





