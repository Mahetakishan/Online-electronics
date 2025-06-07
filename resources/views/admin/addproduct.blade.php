	@extends('admin/layout')

@section('space-work')
<div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Add products</h5>
                    </div>
                    <div class="card-body">
                       
                        
                      
<div class="row">

                          <div class="col-md-6">
                          @if(Session::has('success'))
     
                           <div class="alert alert-success">{{ Session::get('success') }}</div>
                          @endif
                                <form action="{{ route('addProduct') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <b><label for="exampleInputEmail1">Product name</label></b>
                                        <input type="text" class="form-control" id="productname" aria-describedby="emailHelp" placeholder="Enter product name" name="productname">
                                        <div style="color:red;">{{$errors->first('productname')}}</div>  
                                    </div>
                                    <div class="form-group">
                                    <b><label for="exampleInputEmail1">Select Category</label></b>
                                        <select name="category_id" id="category" class="form-control" >
                                           <option value="">Select Category</option>
                                           @foreach ($categories as $category)
                                              <option value="{{ $category->id }}">{{ $category->categoryname }}</option>
                                           @endforeach
                                        </select>
                                        <div style="color:red;">{{$errors->first('category_id')}}</div>  
                                    </div>
                                    <div class="form-group">
                                    <b><label for="exampleInputEmail1">Select Sub Category</label></b>
                                    <select name="subcategory_id" id="subcategory" class="form-control">
                                     <option value="">Select Subcategory</option>
                                   
                                    </select>   
                                    <div style="color:red;">{{$errors->first('subcategory_id')}}</div>  


                                    </div>
                                    
                                    <div class="form-group">
                                        <b><label for="exampleInputPassword1">Price</label></b>
                                        <input type="text" class="form-control" id="price" placeholder="Enter price" name="price">
                                        <div style="color:red;">{{$errors->first('price')}}</div>  
                                    </div>
                                    <div class="form-group">
                                        <b><label for="exampleInputPassword1">Quantity</label></b>
                                        <input type="number" class="form-control" id="price" placeholder="Enter quantity" name="quantity">
                                        <div style="color:red;">{{$errors->first('quantity')}}</div>  
                                    </div>
                                    <div class="form-group">
                                        <b><label for="exampleInputPassword1">Image</label></b>
                                        <input type="file" class="form-control" id="image" placeholder="Enter image" name="image">
                                        <div style="color:red;">{{$errors->first('image')}}</div>
                                    </div>
                                   
                                    <button type="submit" class="btn  btn-primary">Submit</button>
                                </form>
                            </div>
</div>
</div>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>

    $(document).ready(function(){

        $("#category").change(function(){

            var category_id = $(this).val();
           
            if(category_id == ""){
                $("#subcategory").html("<option value=''>Select Category</option>");
            }

            $.ajax({
                url:"/admin/getsubcat/"+category_id,
                type:"GET",
                success:function(data){
                    var subcategory = data.subcategory;
                    var html = "<option value=''>Select Sub category</option>";
                    for(let i =0;i<subcategory.length;i++){
                        html += `
                        <option value="`+subcategory[i]['id']+`">`+subcategory[i]['subcategoryname']+`</option>
                        `;
                    }
                    $("#subcategory").html(html);
                }
            });

        });

    });

</script>

@endsection
