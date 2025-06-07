@extends('admin/layout')

@section('space-work')
<div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Edit Sub Category</h5>
                    </div>
                    <div class="card-body">
                       
                      
<div class="row">

                          <div class="col-md-6">
                         
                                <form action="/admin/editsubcategory/{{$subcat->id}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                 
                                        <b><label for="exampleInputEmail1">Select Category name</label></b>
                                        <select name="category_id" class="form-control" >
                                           <option value="">Select Category</option>
                                           @foreach ($category as $cat)
                                              <option value="{{ $cat->id }}">{{ $cat->categoryname }}</option>
                                           @endforeach
                                        </select>
                                        <div style="color:red;">{{$errors->first('category_id')}}</div>  
                                    </div>
                                    <div class="form-group">
                                        <b><label for="exampleInputEmail1">Sub Category name</label></b>
                                        <input type="text" class="form-control" id="subcategoryname" aria-describedby="emailHelp" placeholder="Enter Sub category name" name="subcategoryname" value="{{$subcat->subcategoryname}}">
                                        <div style="color:red;">{{$errors->first('subcategoryname')}}</div>  
                                    </div>
                                    
                                   
                                    <button type="submit" class="btn  btn-primary">Submit</button>
                                </form>
                            </div>
</div>
</div>
</div>
</div>      
@endsection
