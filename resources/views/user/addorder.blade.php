@extends('commonpages/usrlayout')

@section('space-work')

<br><br><br><br>



<div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Add order</h5>
                    </div>
                    <div class="card-body">
                     
<div class="row">

                          <!-- <div class="col-md-12"> -->
                          
                          <!-- <div class="col-md-4 mb-4"> -->
                       
                                    <div class="col-md-6">
                                    <div class="form-group">
                                       <center><img src="\{{$prod->image}}" /></center>
                                    </div>
                                    </div>
                                    <div class="col-md-6">
                                    @if(Session::has('success'))
     
                                      <div class="alert alert-success">{{ Session::get('success') }}</div>
                                    @endif
                                    <form action="{{ route('odr', ['id' => $prod->id]) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <b><label for="exampleInputEmail1">Product name : </label></b>
                                        <input type="text" class="form-control" id="prd" aria-describedby="emailHelp" placeholder="Enter category name" name="prd" readonly value="{{$prod->productname}}">
                                        <input type="hidden" class="form-control" id="productname" aria-describedby="emailHelp" placeholder="Enter category name" name="productname" readonly value="{{$prod->id}}">
                                       
                                    </div>
                                    <div class="form-group">
                                        <b><label for="exampleInputEmail1">Price : </label></b>
                                        <input type="text" class="form-control" id="price" aria-describedby="emailHelp" placeholder="Enter category name" name="price" readonly value="{{$prod->price}}">
                                         
                                    </div>
                                    <div class="form-group">
                                        <b><label for="exampleInputEmail1">Quantity : </label></b>
                                        <input type="text" class="form-control" id="quantity" aria-describedby="emailHelp" placeholder="Enter category name" name="quantity" readonly value="{{$cart[0]->quantity}}">
                                         
                                    </div>
                                    <div class="form-group">
                                        <b><label for="exampleInputEmail1">Total : </label></b>
                                        <input type="text" class="form-control" id="total" aria-describedby="emailHelp" placeholder="Enter category name" name="total" readonly value="{{$cart[0]->total}}">
                                         
                                    </div>  
                                    <div class="form-group">
                                        <b><label for="exampleInputEmail1">Address : </label></b>
                                        
                                        <select name="select_country" id="select_country" class="form-control">
                                        <option value="">Select Country</option>
                                        @foreach ($country as $cnt)
                                              <option value="{{ $cnt->id }}">{{ $cnt->country_name }}</option>
                                           @endforeach
                                        </select>
                                        <div style="color:red;">{{$errors->first('select_country')}}</div><br>
                                        <select name="select_state" id="select_state" class="form-control">
                                           <option value="">Select State</option>
                                        </select>
                                        <div style="color:red;">{{$errors->first('select_state')}}</div><br>
                                        <select name="select_city" id="select_city" class="form-control">
                                           <option value="">Select City</option>
                                        </select>
                                        <div style="color:red;">{{$errors->first('select_city')}}</div><br>
                                        <input type="number" id="pincode" class="form-control" aria-describedby="emailHelp" placeholder="Enter Pincode" name="pincode">
                                        <div style="color:red;">{{$errors->first('pincode')}}</div><br>  
                                    </div>
                                    <div class="form-group">
                                        <b><label for="exampleInputEmail1">Contact no : </label></b>
                                        <input type="number" class="form-control" id="mobno" aria-describedby="emailHelp" placeholder="Enter Contact No" name="mobno">
                                        <div style="color:red;">{{$errors->first('mobno')}}</div><br>  
                                    </div>  
                                    <div class="form-group">
                                        &nbsp;<b><label for="exampleInputEmail1"><mark>Default payment mode is cash on delivery.</mark></label></b>

                                    </div>
                                    <center><button type="submit" class="btn  btn-primary">Place order</button></center>
                                    </div>
                                   
                                    
                                </form>
                            </div>
                           
                           
</div>
</div>
</div>
</div>      
    <script>

$('#select_country').change(function() {
            var country_id = $(this).val();
            
            if (country_id) {
                $.ajax({
                    url: '/getstate/' + country_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#select_state').empty();
                        $('#select_state').append('<option value="">Select State</option>');
                        // $('#select_city').empty();
                        // $('#select_city').append('<option value="">Select City</option>');
                        $.each(data, function(index, state) {
                            $('#select_state').append('<option value="' + state.id + '">' + state.state_name + '</option>');
                        });
                        // $('#subcategory-card').show();
                    }
                });
                // fetchProducts(category_id)   ;
            } else {
                $('#select_state').empty();
                $('#select_state').append('<option value="">Select State</option>');
                $('#select_city').empty();
                $('#select_city').append('<option value="">Select City</option>');
            }
        });


  



$('#select_state').change(function() {
            var state_id = $(this).val();
            
            if (state_id) {
                $.ajax({
                    url: '/getcity/' + state_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#select_city').empty();
                        $('#select_city').append('<option value="">Select City</option>');
                        $.each(data, function(index, city) {
                            $('#select_city').append('<option value="' + city.id + '">' + city.city_name + '</option>');
                        });
                        // $('#subcategory-card').show();
                    }
                });
                // fetchProducts(category_id);
            } else {
                $('#select_city').empty();
                $('#select_city').append('<option value="">Select City</option>');
                // $('#select_city').append('<option value="">Select City</option>');
            }
        });



      
    </script>




@endsection