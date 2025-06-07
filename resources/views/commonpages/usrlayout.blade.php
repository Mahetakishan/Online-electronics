<!DOCTYPE html>
<html lang="en">
<head>
  <title>Online shop</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors2/owl-carousel/css/owl.carousel.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors2/owl-carousel/css/owl.theme.default.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors2/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors2/aos/css/aos.css') }}">
  <!-- <link rel="stylesheet" href="assets{{ asset('css2/style.min.css')}}">          -->
  <link rel="stylesheet" href="{{ asset('assets/css2/style.css') }}">   
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body id="body" data-spy="scroll" data-target=".navbar" data-offset="100">
  <header id="header-section">
  @auth
    @php
      $user = Auth::user(); // Retrieve the authenticated user
    @endphp
    @if($user->role->id == 2)
    <nav class="navbar navbar-expand-lg pl-3 pl-sm-0" id="navbar">
    <div class="container">
      <div class="navbar-brand-wrapper d-flex w-100">
        <img src="images/Group2.svg" alt="">
        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="mdi mdi-menu navbar-toggler-icon"></span>
        </button> 
      </div>
      <div class="collapse navbar-collapse navbar-menu-wrapper" id="navbarSupportedContent">
        <ul class="navbar-nav align-items-lg-center align-items-start ml-auto">
          <li class="d-flex align-items-center justify-content-between pl-4 pl-lg-0">
            <div class="navbar-collapse-logo">
              <img src="images/Group2.svg" alt="">
            </div>
            <button class="navbar-toggler close-button" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="mdi mdi-close navbar-toggler-icon pl-5"></span>
            </button>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/dashboard">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/allproducts">Product</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/viewcart">Cart</a>  
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/viewwishlist">Wishlist</a>  
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/viewallorder">MyOrders</a>  
          </li>
          
          
		  <li class="nav-item">
            <a class="nav-link" href="/logout">Logout</a>  
          </li>
		  <li class="nav-item">
		  <a href="#" id="viewProfile" ><img src="{{ asset('assets/images/user.png') }}" height="30px" width="30px"></img></a>
          </li>
          
          <!-- <li class="nav-item btn-contact-us pl-4 pl-lg-0">
            <button class="btn btn-info" data-toggle="modal" data-target="#exampleModal">Contact Us</button>
          </li> -->
        </ul>
		
      </div>
    </div> 
	
    </nav>   
    @else
    <nav class="navbar navbar-expand-lg pl-3 pl-sm-0" id="navbar">
    <div class="container">
      <div class="navbar-brand-wrapper d-flex w-100">
        <img src="images/Group2.svg" alt="">
        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="mdi mdi-menu navbar-toggler-icon"></span>
        </button> 
      </div>
      <div class="collapse navbar-collapse navbar-menu-wrapper" id="navbarSupportedContent">
        <ul class="navbar-nav align-items-lg-center align-items-start ml-auto">
          <li class="d-flex align-items-center justify-content-between pl-4 pl-lg-0">
            <div class="navbar-collapse-logo">
              <img src="images/Group2.svg" alt="">
            </div>
            <button class="navbar-toggler close-button" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="mdi mdi-close navbar-toggler-icon pl-5"></span>
            </button>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/getallproducts">Product</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/getviewcart">Cart</a>  
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/login">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/register">Register</a>
          </li>
          <!-- <li class="nav-item btn-contact-us pl-4 pl-lg-0">
            <button class="btn btn-info" data-toggle="modal" data-target="#exampleModal">Contact Us</button>
          </li> -->
        </ul>
      </div>
    </div> 
    </nav>   
    @endif
    @else
    <nav class="navbar navbar-expand-lg pl-3 pl-sm-0" id="navbar">
    <div class="container">
      <div class="navbar-brand-wrapper d-flex w-100">
        <img src="images/Group2.svg" alt="">
        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="mdi mdi-menu navbar-toggler-icon"></span>
        </button> 
      </div>
      <div class="collapse navbar-collapse navbar-menu-wrapper" id="navbarSupportedContent">
        <ul class="navbar-nav align-items-lg-center align-items-start ml-auto">
          <li class="d-flex align-items-center justify-content-between pl-4 pl-lg-0">
            <div class="navbar-collapse-logo">
              <img src="images/Group2.svg" alt="">
            </div>
            <button class="navbar-toggler close-button" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="mdi mdi-close navbar-toggler-icon pl-5"></span>
            </button>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/getallproducts">Product</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/getviewcart">Cart</a>  
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/login">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/register">Register</a>
          </li>
          <!-- <li class="nav-item btn-contact-us pl-4 pl-lg-0">
            <button class="btn btn-info" data-toggle="modal" data-target="#exampleModal">Contact Us</button>
          </li> -->
        </ul>
      </div>
    </div> 
    </nav>   
    @endauth
	
  </header>
  <div class="banner" >
    <div class="container">
      <h1 class="font-weight-semibold">Welcome to our shop</h1>
      <h6 class="font-weight-normal text-muted pb-3">This is an online shop which include different different type products</h6>
      <div>
        <!-- <button class="btn btn-opacity-light mr-1">Get started</button>
        <button class="btn btn-opacity-success ml-1">Learn more</button> -->
      </div>
      <img src="{{ asset('assets/images/onlineshop.jpeg') }}" alt="" class="img-fluid">
    </div>
  </div>
  <div class="content-wrapper">
    <div class="container">
      <section class="features-overview" id="features-section" >
        
      </section>     
      <section class="digital-marketing-service" id="digital-marketing-section">
        
      </section>     
      <section class="case-studies" id="case-studies-section">
      @yield('space-work')
      </section>     
      <section class="customer-feedback" id="feedback-section">
        
      </section>
      @if(Auth::check() && Auth::user()->role->id == 2)
      <section class="contact-us" id="contact-section">
        <div class="contact-us-bgimage grid-margin" >
          <div class="pb-4">
            <h4 class="px-3 px-md-0 m-0" data-aos="fade-down">Do you want any products?</h4>
            <!-- <h4 class="pt-1" data-aos="fade-down">Contact us</h4> -->
          </div>
          <div data-aos="fade-up">
           <a href="/allproducts">Click here</a>
          </div>          
        </div>
      </section>
      @else
      <section class="contact-us" id="contact-section">
        <div class="contact-us-bgimage grid-margin" >
          <div class="pb-4">
            <h4 class="px-3 px-md-0 m-0" data-aos="fade-down">Do you want any products?</h4>
            <!-- <h4 class="pt-1" data-aos="fade-down">Contact us</h4> -->
          </div>
          <div data-aos="fade-up">
           <a href="/getallproducts">Click here</a>
          </div>          
        </div>
      </section>
      @endif
      <hr>
      @if(Auth::check() && Auth::user()->role->id == 2)
      <section class="contact-details" id="contact-details-section">
        <div class="row text-center text-md-left">
          <div class="col-12 col-md-6 col-lg-3 grid-margin">
            <img src="images/Group2.svg" alt="" class="pb-2">
            <div class="pt-2">
              <p class="text-muted m-0">ourshop</p>
              <p class="text-muted m-0">906-179-8309</p>
            </div>         
          </div>
          <div class="col-12 col-md-6 col-lg-3 grid-margin">
            <h5 class="pb-2">Get in Touch</h5>
            <p class="text-muted">Don’t miss any updates of our new products.!</p>
            <!-- <form>
              <input type="text" class="form-control" id="Email" placeholder="Email id">
            </form>
            <div class="pt-3">
              <button class="btn btn-dark">Subscribe</button>
            </div>    -->
          </div>
          <div class="col-12 col-md-6 col-lg-3 grid-margin">
            <h5 class="pb-2">Links</h5>
            <a href="/dashboard"><p class="m-0 pb-2">Home</p></a>   
            <a href="/allproducts" ><p class="m-0 pt-1 pb-2">Products</p></a> 
            
          </div>
          <div class="col-12 col-md-6 col-lg-3 grid-margin">
              <h5 class="pb-2">Thank you</h5>
              <p class="text-muted">Visit again</p>
             

			 


			  <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="profileModalLabel">User Profile</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span> 
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="https://via.placeholder.com/150" alt="Profile Picture" class="img-fluid mb-3">
                                </div>
                                <div class="col-md-8">
									
                                   
                                 
                                    <!-- Add more user details here -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
  
   
    <script>
        $(document).ready(function() {
            // AJAX request to fetch user profile on click
            $('#viewProfile').click(function(e) {
                e.preventDefault();
                
                $.ajax({
                    url: '{{ route('user.profile', ['id' => Auth::user()->id]) }}',
                    type: 'GET',
                    success: function(response) {
                        // Update modal content with user details
                        $('#profileModal .modal-body').html(`
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="{{ asset('assets/images/profile.png') }}" alt="Profile Picture" class="img-fluid mb-3" >
                                    </div>
                                    <div class="col-md-8">
                                        <h5>Name: ${response.user.name}</h5>
                                        <p><strong>Email:</strong> ${response.user.email}</p>
                                       
                                        <!-- Add more user details here -->
                                    </div>
                                </div>
                            </div>
                        `);
                        $('#profileModal').modal('show'); // Show the modal
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        // Handle error appropriately
                    }
                });
            });
        });
    </script>
   
   




          </div>
        </div>  
      </section>
      @else
      <section class="contact-details" id="contact-details-section">
        <div class="row text-center text-md-left">
          <div class="col-12 col-md-6 col-lg-3 grid-margin">
            <img src="images/Group2.svg" alt="" class="pb-2">
            <div class="pt-2">
              <p class="text-muted m-0">ourshop</p>
              <p class="text-muted m-0">906-179-8309</p>
            </div>         
          </div>
          <div class="col-12 col-md-6 col-lg-3 grid-margin">
            <h5 class="pb-2">Get in Touch</h5>
            <p class="text-muted">Don’t miss any updates of our new products.!</p>
            <!-- <form>
              <input type="text" class="form-control" id="Email" placeholder="Email id">
            </form>
            <div class="pt-3">
              <button class="btn btn-dark">Subscribe</button>
            </div>    -->
          </div>
          <div class="col-12 col-md-6 col-lg-3 grid-margin">
            <h5 class="pb-2">Links</h5>
            <a href="/"><p class="m-0 pb-2">Home</p></a>   
            <a href="/getallproducts" ><p class="m-0 pt-1 pb-2">Products</p></a> 
            
          </div>
          <div class="col-12 col-md-6 col-lg-3 grid-margin">
              <h5 class="pb-2">Thank you</h5>
              <p class="text-muted">Visit again</p>
          </div>
      </div>
      </section>   

      @endif
      <footer class="border-top">
       
      </footer>
      <!-- Modal for Contact - us Button -->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="exampleModalLabel">Contact Us</h4>
            </div>
            <div class="modal-body">
              <form>
                <div class="form-group">
                  <label for="Name">Name</label>
                  <input type="text" class="form-control" id="Name" placeholder="Name">
                </div>
                <div class="form-group">
                  <label for="Email">Email</label>
                  <input type="email" class="form-control" id="Email-1" placeholder="Email">
                </div>
                <div class="form-group">
                  <label for="Message">Message</label>
                  <textarea class="form-control" id="Message" placeholder="Enter your Message"></textarea>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-success">Submit</button>
            </div>
          </div>
        </div>
      </div>
    </div> 
  </div>
  <script src="{{ asset('assets/vendors2/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/vendors2/bootstrap/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/vendors2/owl-carousel/js/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('assets/vendors2/aos/js/aos.js') }}"></script>
  <script src="{{ asset('assets/js2/landingpage.js') }}"></script>
</body>
</html>