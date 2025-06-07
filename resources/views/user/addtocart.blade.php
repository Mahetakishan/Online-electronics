@extends('commonpages/usrlayout')

@section('space-work')

<br><br><br><br>
<div class="container mt-5">
<div class="row">

@foreach($cart as $crt)
<div class="col-md-8 mb-4"> <!-- Use col-md-8 to make it wider -->
            <div class="card h-100">
                <div class="row g-0"> <!-- Use Bootstrap grid row and columns -->
                    <div class="col-md-4">
                        <img src="\{{$crt->image}}" class="img-fluid" alt="Product Image" height="400px" width="400px">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                        @if(Session::has('success'))
     
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                        @endif
                        @if ($errors->any())
                   <div class="alert alert-danger">
                       <ul>
                             @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                             @endforeach
                       </ul>
                 </div>
                    @endif
                            <h5 class="card-title">Product name : {{$crt->productname}}</h5>
                            <h5 class="card-text">Price : {{$crt->price}}</h5><br>
                            <h5 class="card-text">Available products : {{$crt->quantity}}</h5><br><br>
                            <!-- Additional product data can be added here -->
                                            <form action="{{ route('cart.add', ['id' => $crt->id]) }}" method="POST">
                                            @csrf
                                            <div class="input-group mb-3">
                                                    <div class="">
                                                        <button class="btn btn-outline-secondary incheigth" type="button" id="minus-btn"><i class="fas fa-minus">-</i></button>
                                                    </div>
                                                    <div style="width:100px;">
                                                    <input type="number" name="quantity" id="quantity" class="form-control " value="1" min="1">
                                                    </div>
                                                <div class="">
                                                    <button class="btn btn-outline-secondary incheigth" type="button" id="plus-btn"><i class="fas fa-plus">+</i></button>
                                                    </div>
                                                    
                                                    
                                                    <div class="mb-3"><br><br><br><br>
                                                     <label for="total" class="form-label">Total:</label>
                                                     <input type="text" class="form-control" id="total" value="{{$crt->price}}" readonly>
                                                   </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                                            <a href="/viewcart" class="btn btn-primary">View cart</a>
                                            </form>
                                        </div>
                    </div>
                </div>
            </div>
        </div>

@endforeach

</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function calculateTotal() {
            var quantityInput = document.getElementById('quantity');
        var quantity = parseInt(document.getElementById('quantity').value);
        var price = parseFloat("{{$crt->price}}"); // Replace with actual price variable
        if (isNaN(quantity) || quantity < 1) {
            quantity = 1;
            quantityInput.value = quantity;
        }
        var total = quantity * price;

        document.getElementById('total').value = Math.round(total); // Format total to two decimal places
        }
        // Plus button
        document.getElementById('plus-btn').addEventListener('click', function () {
            var quantityInput = document.getElementById('quantity');
        quantityInput.stepUp();
        calculateTotal();
        });

        // Minus button
        document.getElementById('minus-btn').addEventListener('click', function () {
            var quantityInput = document.getElementById('quantity');
            quantityInput.stepDown();
            calculateTotal();
        });
         // Validate and calculate total on input change
         document.getElementById('quantity').addEventListener('input', function () {
              calculateTotal();
          });
          calculateTotal();
    });
       // Calculate total on page load
     
</script>


@endsection



