@extends('commonpages/usrlayout')

@section('space-work')

<div class="auth-wrapper">
	<div class="auth-content">
		<div class="card">
		@if(Session::has('error'))
     
     <div class="alert alert-danger">{{ Session::get('error') }}</div>
      @endif    
			<div class="row align-items-left text-left">
				<div class="col-md-12">
					<div class="card-body">
						
						<h4 class="mb-3 f-w-400">Signin</h4>
            <form action="{{ route('login') }}" method="POST">
            @csrf
   
						<div class="form-group mb-3">
							<label class="floating-label" for="Email">Email address : </label>
							<input type="text" class="form-control" id="Email" placeholder="Enter Email" name="email">
							<div style="color:red;">{{$errors->first('email')}}</div>
							
						</div>
						<div class="form-group mb-4">
							<label class="floating-label" for="Password">Password : </label>
							<input type="password" class="form-control" id="Password" placeholder="Enter Password" name="password">
							<div style="color:red;">{{$errors->first('password')}}</div>
						</div>
					
						<button class="btn btn-block btn-primary mb-4">Signin</button>
					
						<p class="mb-0 text-muted">Don’t have an account? <a href="/register" class="f-w-400">Signup</a></p>
           </form>		
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- [ auth-signin ] end -->

@endsection