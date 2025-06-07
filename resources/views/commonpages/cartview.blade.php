@extends('commonpages/usrlayout')

@section('space-work')
<br><br><br><br>

@auth
    @php
      $user = Auth::user(); // Retrieve the authenticated user
    @endphp
    @if($user->role->id == 2)
<center><h2>Cart Items</h2></center>
<br><br>



<div class="container mt-5">
@if(Session::has('delete'))
 
 <div class="alert alert-danger">{{ Session::get('delete') }}</div>
@endif
@if(Session::has('success'))
     
     <div class="alert alert-success">{{ Session::get('success') }}</div>
     @endif 
     @if(Session::has('error'))
    <div class="alert alert-danger">
        {{ Session::get('error') }}
    </div>
       @endif
<div class="row">


@foreach($cart as $crt)
<div class="col-md-4 mb-4">
        <div class="card h-100">
        
        <img src="{{$crt->product->image}}" alt="Product Image"><hr>
          <div class="card-body">
              
            <h5 class="card-title">Product name : {{$crt->product->productname}}</h5>
            <p class="card-text">Price : {{$crt->product->price}}</p>
            <p class="card-text">Available product : {{$crt->product->quantity}}</p>
            <p class="card-text">Quantity : 
            <span class="quantity-display">{{ $crt->quantity }}</span><br>  
            <button type="button" class="btn btn-sm btn-link edit-quantity">Edit Quantity</button>
            </p>
            <div class="quantity-edit" style="display: none;">
                <input type="number" class="form-control" value="{{ $crt->quantity }}" min="1" oninput="validity.valid||(value='');"><br>
                <button type="button" class="btn btn-sm btn-primary save-quantity">Save</button>
                <button type="button" class="btn btn-sm btn-danger cancel-edit">Cancel</button>
            </div>
            <p class="card-text">Total : 
            <span class="total-display">{{ $crt->total }}</span>  
            </p>
            <button type="button" value="{{ $crt->id }}" class="btn btn-danger deletebutton">Remove from cart</button>
            <a href="/Loadorder/{{ $crt->product->id }}" class="btn btn-primary">Order now</a> 
            <!-- <a href="/removecart/{{ $crt->id }}" class="btn btn-primary">Remove from cart</a> -->
          </div>
        </div>  
      </div>

@endforeach
<div class="modal fade" id="DeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Cart Item</h1>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
      <div class="modal-body">
      <form action="/removecart" method="POST" >
        @csrf
         @method('DELETE')
         <p>Are you sure you want to delete this cart item?</p>
         <input type="hidden" id="deleting_id" name="delete_user_id">
      
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
        <button type="submit" class="btn btn-danger">Yes delete</button>
      </div>
      </form>
    </div>
  </div>
</div>    
<script>
         document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-quantity');
        
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const cardBody = this.closest('.card-body');
                const quantityDisplay = cardBody.querySelector('.quantity-display');
                const quantityEdit = cardBody.querySelector('.quantity-edit');
                
                quantityDisplay.style.display = 'none';
                quantityEdit.style.display = 'block';
            });
        });
        
        // Handle cancel edit button
        const cancelButtons = document.querySelectorAll('.cancel-edit');
        
        cancelButtons.forEach(button => {
            button.addEventListener('click', function() {
                const cardBody = this.closest('.card-body');
                const quantityDisplay = cardBody.querySelector('.quantity-display');
                const quantityEdit = cardBody.querySelector('.quantity-edit');
                const quantityInput = quantityEdit.querySelector('input');
                
                quantityDisplay.style.display = 'inline';
                quantityEdit.style.display = 'none';
                
                // Reset input value to original quantity
                quantityInput.value = quantityDisplay.textContent.trim();
            });
        });
        
        // Handle save quantity button
        const saveButtons = document.querySelectorAll('.save-quantity');
        
        saveButtons.forEach(button => {
            button.addEventListener('click', function() {
                const cardBody = this.closest('.card-body');
                const quantityDisplay = cardBody.querySelector('.quantity-display');
                const quantityEdit = cardBody.querySelector('.quantity-edit');
                const quantityInput = quantityEdit.querySelector('input');
                
                // Update quantity display with new value
                quantityDisplay.textContent = quantityInput.value;
                
                // Perform AJAX request to update quantity in backend (Laravel controller)
                const cartItemId = this.closest('.card').querySelector('.deletebutton').value;
                const newQuantity = quantityInput.value;
                
                // Example AJAX request with fetch API
                fetch(`/updatecart/${cartItemId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ quantity: newQuantity })
                })
                .then(response => response.json())
                .then(data => {
                    // Handle success or error response if needed
                    if (data.error) {
                     // Handle error message display in your cart view
                      alert(data.error); // Example: Displaying error using alert
                      }else{
                        const totalDisplay = cardBody.querySelector('.total-display');
                        totalDisplay.textContent = data.updatedCartItem.total;
                        
                        // Hide edit form and display updated quantity
                        quantityDisplay.style.display = 'inline';
                        quantityEdit.style.display = 'none';
                        
                        // alert('Cart item quantity updated successfully');
                      }
                    // console.log(data);
                })
                .catch(error => console.error('Error:', error));
                
                // Hide edit form and display updated quantity
                quantityDisplay.style.display = 'inline';
                quantityEdit.style.display = 'none';
            });
        });
    });
          
         $(document).ready(function(){
         $(document).on('click','.deletebutton',function(){
         var cart_id = $(this).val();
         $('#DeleteModal').modal('show');
         $('#deleting_id').val(cart_id);
         });
        });

        










        </script>
</div>
</div>
@else
<div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-4">You need to login first to add items to cart</h4>

                        <div class="text-center mb-4">
                            <a href="/login" class="btn btn-primary mr-2">Login</a>
                            <span>or</span>
                            <a href="/register" class="btn btn-primary ml-2">Register</a>
                        </div>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif 
    @else
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-4">You need to login first to add items to cart</h4>

                        <div class="text-center mb-4">
                            <a href="/login" class="btn btn-primary mr-2">Login</a>
                            <span>or</span>
                            <a href="/register" class="btn btn-primary ml-2">Register</a>
                        </div>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endauth
     
     
     

       
@endsection



