@extends('admin/layout')

@section('space-work')
<div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Edit Category</h5>
                    </div>
                    <div class="card-body">
                    
                      
<div class="row">

                          <div class="col-md-6">
                          @if(Session::has('success'))
     
                           <div class="alert alert-success">{{ Session::get('success') }}</div>
                          @endif
                                <form action="/admin/editcategory/{{$category->id}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <b><label for="exampleInputEmail1">Category name</label></b>
                                        <input type="text" class="form-control" id="categoryname" aria-describedby="emailHelp" placeholder="Enter category name" name="categoryname" value="{{$category->categoryname}}">
                                        <div style="color:red;">{{$errors->first('categoryname')}}</div>  
                                    </div>
                                    
                                   
                                    <button type="submit" class="btn  btn-primary">Submit</button>
                                </form>
                            </div>
</div>
</div>
</div>
</div>      
@endsection