@extends('commonpages/usrlayout')

@section('space-work')

<br><br><br><br>

<center><h2>Wishlist Items</h2></center>
<br><br>



<div class="container mt-5">
<div class="row">
@if(Session::has('success'))
     
     <div class="alert alert-success">{{ Session::get('success') }}</div>
     @endif 
     @if(Session::has('error'))
    <div class="alert alert-danger">
        {{ Session::get('error') }}
    </div>
       @endif
       @if(Session::has('delete'))
     
     <div class="alert alert-danger">{{ Session::get('delete') }}</div>
     @endif


@foreach($wishlist as $wl)
<div class="col-md-4 mb-4">
        <div class="card h-100">
        
        <img src="{{$wl->product->image}}" alt="Product Image"><hr>
          <div class="card-body">
              
            <h5 class="card-title">Product name : {{$wl->product->productname}}</h5>
            <h5 class="card-title">Price : {{$wl->product->price}}</h5>
            
            
            <button type="button" value="{{ $wl->id }}" class="btn btn-danger deletebutton">Remove from wishlist</button>
            <a href="addtocart/{{ $wl->product->id }}" class="btn btn-primary">Add to cart</a>
            
          </div>
        </div>  
      </div>

@endforeach
<div class="modal fade" id="DeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Wishlist Item</h1>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
      <div class="modal-body">
      <form action="/removewishlist" method="POST" >
        @csrf
         @method('DELETE')
         <p>Are you sure you want to delete this wishlist item?</p>
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
    $(document).ready(function(){
         $(document).on('click','.deletebutton',function(){
         var wishlist_id = $(this).val();
         $('#DeleteModal').modal('show');
         $('#deleting_id').val(wishlist_id);
         });
        });



</script>

</div>
</div>


@endsection