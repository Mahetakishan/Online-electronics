@extends('commonpages/usrlayout')

@section('space-work')
<br><br><br><br>

<center><h2>My orders</h2></center>
<br><br>

<div class="container mt-5">
<div class="row">

@if(Session::has('success'))
     
     <div class="alert alert-success">{{ Session::get('success') }}</div>
     @endif

@if(Session::has('delete'))
     
     <div class="alert alert-danger">{{ Session::get('delete') }}</div>
     @endif
@foreach($groupedOrders as $groupedOrder)
<div class="col-md-4 mb-4">
        <div class="card h-100">

        <img src="\{{$groupedOrder['product']->image}}" alt="Product Image"><hr>
          <div class="card-body">
              
            <h5 class="card-title">Product name : {{$groupedOrder['product']->productname}}</h5>
            <p class="card-text">Price : {{$groupedOrder['product']->price}}</p>
            
            <p class="card-text">Quantity : 
            <span class="quantity-display">{{ $groupedOrder['total_quantity'] }}</span><br>   <!--total_quantity-->
            </p>
        
            <p class="card-text">Total : 
            <span class="total-display">{{ $groupedOrder['total_quantity'] * $groupedOrder['product']->price  }}</span>     <!--total_quantity * $odr->product->price-->
            </p>
           
           <p class="card-text">Address : <br>
           
           
           <span class="city-display">City - @if(isset($groupedOrder['city']->city_name)) {{ $groupedOrder['city']->city_name }}  @endif, </span>
           <strong>State:</strong> {{ $groupedOrder['state']->state_name }}<br>
           <strong>Country:</strong> {{ $groupedOrder['country']->country_name }}<br>
        
       
          
          <span class="pincode-display">Pincode - {{ $groupedOrder['pincode'] }}</span><br><br>
          
          <span class="status-display">Status - {{ $groupedOrder['status'] }}</span><br><br>
       
          
            <span class="total-display"><b>Payment mode - <mark>CASH ON DELIVERY</mark></b></span>
            </p>
            @if($groupedOrder['status'] !== 'Delivered')
            <button type="button" value="{{ $groupedOrder['id'] }}" class="btn btn-danger deletebutton">Cancel Order</button>
            @else
             <button type="button" class="btn btn-danger" disabled>Cancel order</button>
            @endif
          </div>
        </div>  
      </div>
@endforeach



</div>
</div>

<div class="modal fade" id="DeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Cancel Order</h1>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
      <div class="modal-body">
      <form action="/removeorder" method="POST" >
        @csrf
         @method('DELETE')
         <p>Are you sure you want to cancel this order?</p>
         <input type="hidden" id="deleting_id" name="delete_user_id">
      
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
        <button type="submit" class="btn btn-danger">Yes cancel</button>
      </div>
      </form>
    </div>
  </div>
</div>  

<script>
     $(document).ready(function(){
         $(document).on('click','.deletebutton',function(){
         var order_id = $(this).val();
         $('#DeleteModal').modal('show');
         $('#deleting_id').val(order_id);
         });
        });
</script>




@endsection