@extends('admin/layout')

@section('space-work')
<div class="row">

        



<div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h5>Product view</h5>
                        
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                        @if(Session::has('success'))
     
                           <div class="alert alert-success">{{ Session::get('success') }}</div>
                        @endif
                        @if(Session::has('update'))

                           <div class="alert alert-success">{{ Session::get('update') }}</div>
                        @endif
                        @if(Session::has('delete'))
 
                           <div class="alert alert-danger">{{ Session::get('delete') }}</div>
                        @endif
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Category Name</th>
                                        
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if (count($category) > 0)
                                   @foreach ($category as $key=> $cat)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $cat->categoryname }}</td>
                                       
                                        
                                        <td>

                                        <a href="/admin/editcategory/{{ $cat->id }}"><button type="button" class="btn btn-primary">Edit</button></a>
                                        <a href="/admin/deletecategory/{{ $cat->id }}"><button type="button" class="btn btn-danger">Delete</button></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                <tr>
                                  <td>No Data</td>
                                </tr>
                                @endif
                                </tbody>
                            </table>
                            {{$category->links()}}
                        </div>
                    </div>
                </div>
            </div>
</div>
@endsection