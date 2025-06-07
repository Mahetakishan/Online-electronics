@extends('commonpages/usrlayout')

@section('space-work')
<br><br><br><br>
@auth
    @php
      $user = Auth::user(); // Retrieve the authenticated user
    @endphp
    @if($user->role->id == 2)
<br><br>
<center><h2>Products </h2></center>
<br><br>

<div class="card">
    @if(Session::has('error'))
    <div class="alert alert-danger">
        {{ Session::get('error') }}
    </div>
    @endif
    
   
                             <div class="card-header">Select Category</div>
                               <div class="card-body">
                                 <select class="form-control" id="category">
                                    <option value="">All Products</option>
                                      @foreach($category as $category)
                                       <option value="{{ $category->id }}">{{ $category->categoryname }}</option>
                                     @endforeach
                                </select>   
                              </div>
                         </div>

                                    <div class="card mt-3" id="subcategory-card" style="display: none;">
                                           <div class="card-header">Select Subcategory</div>
                                    <div class="card-body">
                                         <select class="form-control" id="subcategory">
                                           <option value="">Select Subcategory</option>
                                        </select>
                                         </div>
                                      </div>
                              <div id="top">

                              </div>


                                   

            <div class="card mt-3" id="products-card" style="display: none;">
                <div class="card-header"></div>
                <div class="card-body">
                <div id="message-container"></div>  
                    <div class="row" id="products-container"> 
                        <!-- Product cards will be appended here -->
                    </div>
                </div>
            </div>


<!-- <div id="productsDisplay"  class="product-card-container">
       

</div> -->
 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
        






     $(document).ready(function() {

        function fetchProducts(category_id = null, subcategory_id = null) {
            var url;
            if (subcategory_id) {
                url = '/products/' + subcategory_id;
            } else if (category_id) {
                url = '/products/category/' + category_id;
            } else {
                url = '/products';
            }
            // var url = subcategory_id ? '/products/' + subcategory_id : '/products';
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    displayProductsBySubcategory(data); 
                }
            });
        }
        function displayProductsBySubcategory(products) {
            // console.log(products);
          
        $('#products-container').empty();
        var groupedProducts = groupProductsBySubcategory(products);
    //    console.log(products);
        $.each(groupedProducts, function(subcategory_id, subcategoryProducts) {
            
            var subcategoryName = subcategoryProducts[0].subcategory.subcategoryname; 
            var subcategoryHtml = '<div class="row"><div class="col-md-12">';
            subcategoryHtml += '<h4>' +  subcategoryName  + '</h4>';
            subcategoryHtml += '</div></div>';  

            subcategoryHtml += '<div class="row">';
          
            $.each(subcategoryProducts, function(index, product) {
               
                var imageUrl = product.image ? product.image : '/default-image.jpg';
                // var isInWishlist = product.inWishlist; 
                var wishlistImageUrl = product.inWishlist ? '/assets/images/wishlist true.jpeg' : '/assets/images/wishlist false.jpeg';
                var cardHtml = '<div class="col-md-3 col-sm-6 mb-4">'; // Adjust column size for different screen sizes //
               
                // cardHtml += '<div id="message-container">';
                // cardHtml += '</div>';
                
                
                cardHtml += '<div class="card h-100">';
               
              
                cardHtml += '<img src="' + imageUrl + '" class="card-img-top" alt="Product Image">';
                cardHtml += '<div class="card-body"><hr>';  
               
                cardHtml += '<h5 class="card-title">' + product.productname + '</h5>';
                cardHtml += '<p class="card-text">Price: ' + product.price + '</p>';
                cardHtml += '<a href="/addtocart/' + product.id + '" class="card-links">';
                cardHtml += '<p class="card-text btn btn-primary">Add to cart';
                cardHtml += '</p>';
                cardHtml += '</a>&nbsp;&nbsp;';
                cardHtml += '<a href="#" class="wishlist-link" data-product-id="' + product.id + '" data-in-wishlist="' + product.inWishlist +  '">';

                // cardHtml += '<a href="/addtowishlist/' + product.id + '" class="card-links">';
                // cardHtml += '<img src="assets{{ asset('images/wishlist false.jpeg') }}" height="30px" width="30px" title="addtowishlist">';
                cardHtml += '<img src="' + wishlistImageUrl + '" height="30px" width="30px" title="Add to Wishlist">';
                cardHtml += '</img>';
                cardHtml += '</a>';
               
                
                cardHtml += '</div></div></div>';
                subcategoryHtml += cardHtml;
            });
           



            subcategoryHtml += '</div>'; // Close row for subcategory
            $('#products-container').append(subcategoryHtml);
        });
        
        $('.wishlist-link').click(function(e) {
            e.preventDefault();
            var $wishlistLink = $(this);    
            var productId = $wishlistLink.data('product-id');
            var isInWishlist = $wishlistLink.data('in-wishlist');
            $wishlistLink.prop('disabled', true);
            
             if (isInWishlist) {
                // Perform AJAX request to delete the product from wishlist
                $.ajax({
                    url: '/removewishlist/' + productId,
                    type: 'POST', // or 'DELETE' based on your route setup
                    headers: {  
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Update the image to wishlist false image
                        $wishlistLink.find('img').attr('src', '/assets/images/wishlist false.jpeg');
                        $wishlistLink.data('in-wishlist', false);
                        displayMessage('Product remove from wishlist successfully.', 'danger');
                        scrollToDiv('#top');
                    },
                    error: function(xhr, textStatus, errorThrown) {
                    console.log(xhr.responseText); // Log the full error response
                     alert('Error removing product from wishlist. See console for details.');
                    },
                    complete: function() {
                        // Re-enable the link after AJAX request completes
                        $wishlistLink.prop('disabled', false);
                    }
                });
            }else{
                $.ajax({
                    url: '/addtowishlist/' + productId,
                    type: 'POST', // or 'DELETE' based on your route setup
                    headers: {  
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Update the image to wishlist false image
                        $wishlistLink.find('img').attr('src', '/assets/images/wishlist true.jpeg');
                        $wishlistLink.data('in-wishlist', true);
                        displayMessage('Product added to wishlist successfully.', 'success');
                        scrollToDiv('#top');
                    },
                    error: function(xhr, textStatus, errorThrown) {
                    console.log(xhr.responseText); // Log the full error response
                     alert('Error removing product from wishlist. See console for details.');
                    },
                    complete: function() {
                        // Re-enable the link after AJAX request completes
                        $wishlistLink.prop('disabled', false);
                    }
                });
            }
            function displayMessage(message, type) {
            // Clear previous messages
            $('#message-container').empty();

            // Create message element
            var messageElement = $('<div class="alert alert-' + type + '">' + message + '</div>');

            // Append to message container
            $('#message-container').append(messageElement);
            }
            }); 
            function scrollToDiv(selector) {
            // Scroll to the specified div
            var $div = $(selector); 
            if ($div.length) {
             $('html, body').animate({
            scrollTop: $div.offset().top
             }, 'fast');
    }
}   




        $('#products-card').show();


        
    }
    
    function groupProductsBySubcategory(products) {
        var groupedProducts = {};
        $.each(products, function(index, product) {
            if (!groupedProducts[product.subcategory_id]) {
                groupedProducts[product.subcategory_id] = [];
            }
            groupedProducts[product.subcategory_id].push(product);
        });
        return groupedProducts;
    }

      

        $('#category').change(function() {
            var category_id = $(this).val();
            if (category_id) {
                $.ajax({
                    url: '/subcategories/' + category_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#subcategory').empty();
                        $('#subcategory').append('<option value="">Select Subcategory</option>');
                        $.each(data, function(index, subcategory) {
                            $('#subcategory').append('<option value="' + subcategory.id + '">' + subcategory.subcategoryname + '</option>');
                        });
                        $('#subcategory-card').show();
                    }
                });
                fetchProducts(category_id);
            } else {
                $('#subcategory').empty();
                $('#subcategory-card').hide();
                fetchProducts(); // Call fetchProducts() when no category is selected
            }
        });

        $('#subcategory').change(function() {
        var category_id = $('#category').val();
        var subcategory_id = $(this).val();
        if (subcategory_id) {
                fetchProducts(null, subcategory_id); // Call fetchProducts() with subcategory_id
            } else {
                fetchProducts(category_id); // Call fetchProducts() when no subcategory is selected
            }
        });

        // Initially fetch all products
        fetchProducts();


     });

</script>
@else
<br><br>
<center><h2>Products </h2></center>
<br><br>

     

                        <div class="card">
                             <div class="card-header">Select Category</div>
                               <div class="card-body">
                                 <select class="form-control" id="category">
                                    <option value="">All Products</option>
                                      @foreach($category as $category)
                                       <option value="{{ $category->id }}">{{ $category->categoryname }}</option>
                                     @endforeach
                                </select>
                              </div>
                         </div>

                                    <div class="card mt-3" id="subcategory-card" style="display: none;">
                                           <div class="card-header">Select Subcategory</div>
                                    <div class="card-body">
                                         <select class="form-control" id="subcategory">
                                           <option value="">Select Subcategory</option>
                                        </select>
                                         </div>
                                      </div>
                              


                                   

                                      <div class="card mt-3" id="products-card" style="display: none;">
                <div class="card-header"></div>
                <div class="card-body">
                    <div class="row" id="products-container">
                        <!-- Product cards will be appended here -->
                      
                    </div>
                </div>
            </div>




<!-- <div id="productsDisplay"  class="product-card-container">
       

</div> -->
 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
     $(document).ready(function() {

        function fetchProducts(category_id = null, subcategory_id = null) {
            var url;
            if (subcategory_id) {
                url = '/getproducts/' + subcategory_id;
            } else if (category_id) {
                url = '/getproducts/category/' + category_id;
            } else {
                url = '/getproducts';
            }
            // var url = subcategory_id ? '/products/' + subcategory_id : '/products';
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    displayProductsBySubcategory(data); 
                }
            });
        }
        function displayProductsBySubcategory(products) {
            // console.log(products);
           
        $('#products-container').empty();
        var groupedProducts = groupProductsBySubcategory(products);
    //    console.log(products);
        $.each(groupedProducts, function(subcategory_id, subcategoryProducts) {
            
            var subcategoryName = subcategoryProducts[0].subcategory.subcategoryname; 
            var subcategoryHtml = '<div class="row"><div class="col-md-12">';
            subcategoryHtml += '<h4>' +  subcategoryName  + '</h4>';
            subcategoryHtml += '</div></div>';  

            subcategoryHtml += '<div class="row">';
          
            $.each(subcategoryProducts, function(index, product) {
                var imageUrl = product.image ? product.image : '/default-image.jpg';
                var cardHtml = '<div class="col-md-3 col-sm-6 mb-4">'; // Adjust column size for different screen sizes
                cardHtml += '<div class="card h-100">';
               
              
                cardHtml += '<img src="' + imageUrl + '" class="card-img-top" alt="Product Image">';
                cardHtml += '<div class="card-body"><hr>';  
               
                cardHtml += '<h5 class="card-title">' + product.productname + '</h5>';
                cardHtml += '<p class="card-text">Price: ' + product.price + '</p>';
                cardHtml += '<a href="/getaddtocart/' + product.id + '" class="card-links">';
                cardHtml += '<p class="card-text btn btn-primary">Add to cart';
                cardHtml += '</p>';
                cardHtml += '</a>&nbsp;&nbsp;';
                cardHtml += '<a href="/getaddtowishlist/' + product.id + '" class="card-links">';
                cardHtml += '<img src="assets{{ asset('images/wishlist false.jpeg') }}" height="30px" width="30px">';
                cardHtml += '</img>';
                cardHtml += '</a>';
                cardHtml += '</div></div></div>';
                subcategoryHtml += cardHtml;
            });

            subcategoryHtml += '</div>'; // Close row for subcategory
            $('#products-container').append(subcategoryHtml);
        });

        $('#products-card').show();
    }
    
    function groupProductsBySubcategory(products) {
        var groupedProducts = {};
        $.each(products, function(index, product) {
            if (!groupedProducts[product.subcategory_id]) {
                groupedProducts[product.subcategory_id] = [];
            }
            groupedProducts[product.subcategory_id].push(product);
        });
        return groupedProducts;
    }

      

        $('#category').change(function() {
            var category_id = $(this).val();
            if (category_id) {
                $.ajax({
                    url: '/getsubcategories/' + category_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#subcategory').empty();
                        $('#subcategory').append('<option value="">Select Subcategory</option>');
                        $.each(data, function(index, subcategory) {
                            $('#subcategory').append('<option value="' + subcategory.id + '">' + subcategory.subcategoryname + '</option>');
                        });
                        $('#subcategory-card').show();
                    }
                });
                fetchProducts(category_id);
            } else {
                $('#subcategory').empty();
                $('#subcategory-card').hide();
                fetchProducts(); // Call fetchProducts() when no category is selected
            }
        });

        $('#subcategory').change(function() {
        var category_id = $('#category').val();
        var subcategory_id = $(this).val();
        if (subcategory_id) {
                fetchProducts(null, subcategory_id); // Call fetchProducts() with subcategory_id
            } else {
                fetchProducts(category_id); // Call fetchProducts() when no subcategory is selected
            }
        });

        // Initially fetch all products
        fetchProducts();


     });

       
</script>
@endif
@else
<br><br>
<center><h2>Products </h2></center>
<br><br>

     

                        <div class="card">
                             <div class="card-header">Select Category</div>
                               <div class="card-body">
                                 <select class="form-control" id="category">
                                    <option value="">All Products</option>
                                      @foreach($category as $category)
                                       <option value="{{ $category->id }}">{{ $category->categoryname }}</option>
                                     @endforeach
                                </select>
                              </div>
                         </div>

                                    <div class="card mt-3" id="subcategory-card" style="display: none;">
                                           <div class="card-header">Select Subcategory</div>
                                    <div class="card-body">
                                         <select class="form-control" id="subcategory">
                                           <option value="">Select Subcategory</option>
                                        </select>
                                         </div>
                                      </div>
                              


                                   

                                      <div class="card mt-3" id="products-card" style="display: none;">
                <div class="card-header"></div>
                <div class="card-body">
                    <div class="row" id="products-container">
                        <!-- Product cards will be appended here -->
                      
                    </div>
                </div>
            </div>




<!-- <div id="productsDisplay"  class="product-card-container">
       

</div> -->
 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
     $(document).ready(function() {

        function fetchProducts(category_id = null, subcategory_id = null) {
            var url;
            if (subcategory_id) {
                url = '/getproducts/' + subcategory_id;
            } else if (category_id) {
                url = '/getproducts/category/' + category_id;
            } else {
                url = '/getproducts';
            }
            // var url = subcategory_id ? '/products/' + subcategory_id : '/products';
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    displayProductsBySubcategory(data); 
                }
            });
        }
        function displayProductsBySubcategory(products) {
            // console.log(products);
           
        $('#products-container').empty();
        var groupedProducts = groupProductsBySubcategory(products);
    //    console.log(products);
        $.each(groupedProducts, function(subcategory_id, subcategoryProducts) {
            
            var subcategoryName = subcategoryProducts[0].subcategory.subcategoryname; 
            var subcategoryHtml = '<div class="row"><div class="col-md-12">';
            subcategoryHtml += '<h4>' +  subcategoryName  + '</h4>';
            subcategoryHtml += '</div></div>';  

            subcategoryHtml += '<div class="row">';
          
            $.each(subcategoryProducts, function(index, product) {
                var imageUrl = product.image ? product.image : '/default-image.jpg';
                var cardHtml = '<div class="col-md-3 col-sm-6 mb-4">'; // Adjust column size for different screen sizes
                cardHtml += '<div class="card h-100">';
               
              
                cardHtml += '<img src="' + imageUrl + '" class="card-img-top" alt="Product Image">';
                cardHtml += '<div class="card-body"><hr>';  
               
                cardHtml += '<h5 class="card-title">' + product.productname + '</h5>';
                cardHtml += '<p class="card-text">Price: ' + product.price + '</p>';
                cardHtml += '<a href="/getaddtocart/' + product.id + '" class="card-links">';
                cardHtml += '<p class="card-text btn btn-primary">Add to cart';
                cardHtml += '</p>';
                cardHtml += '</a>&nbsp;&nbsp;';
                cardHtml += '<a href="/getaddtowishlist/' + product.id + '" class="card-links">';
                cardHtml += '<img src="assets{{ asset('images/wishlist false.jpeg') }}" height="30px" width="30px">';
                cardHtml += '</img>';
                cardHtml += '</a>';
                cardHtml += '</div></div></div>';
                subcategoryHtml += cardHtml;
            });

            subcategoryHtml += '</div>'; // Close row for subcategory
            $('#products-container').append(subcategoryHtml);
        });

        $('#products-card').show();
    }
    
    function groupProductsBySubcategory(products) {
        var groupedProducts = {};
        $.each(products, function(index, product) {
            if (!groupedProducts[product.subcategory_id]) {
                groupedProducts[product.subcategory_id] = [];
            }
            groupedProducts[product.subcategory_id].push(product);
        });
        return groupedProducts;
    }

      

        $('#category').change(function() {
            var category_id = $(this).val();
            if (category_id) {
                $.ajax({
                    url: '/getsubcategories/' + category_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#subcategory').empty();
                        $('#subcategory').append('<option value="">Select Subcategory</option>');
                        $.each(data, function(index, subcategory) {
                            $('#subcategory').append('<option value="' + subcategory.id + '">' + subcategory.subcategoryname + '</option>');
                        });
                        $('#subcategory-card').show();
                    }
                });
                fetchProducts(category_id);
            } else {
                $('#subcategory').empty();
                $('#subcategory-card').hide();
                fetchProducts(); // Call fetchProducts() when no category is selected
            }
        });

        $('#subcategory').change(function() {
        var category_id = $('#category').val();
        var subcategory_id = $(this).val();
        if (subcategory_id) {
                fetchProducts(null, subcategory_id); // Call fetchProducts() with subcategory_id
            } else {
                fetchProducts(category_id); // Call fetchProducts() when no subcategory is selected
            }
        });

        // Initially fetch all products
        fetchProducts();


     });

       
</script>

@endauth

       
@endsection