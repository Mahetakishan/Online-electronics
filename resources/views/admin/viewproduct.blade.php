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
                            <form action="{{ route('searchproduct') }}" method="GET">
                             @csrf
                                <input type="text" name="search" placeholder="Search Here">
                                <button type="submit">Search</button>
                                <div style="color:red;">{{$errors->first('search')}}</div>       
                             </form><br>
                            
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Category</th>
                                        <th>Subcategory</th>
                                        <th>Quantity</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if (count($product) > 0)
                                   @foreach ($product as $key=> $prod)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $prod->productname }}</td>
                                        <td>{{ $prod->price }}</td>
                                        <td>{{ $prod->category->categoryname }}</td>
                                        <td>{{ $prod->subcategory->subcategoryname }}</td>
                                        <td>{{ $prod->quantity }}</td>
                                        <td><img src="\{{$prod->image}}" height="40px" width="40px" /></td>
                                        <td>

                                        <a href="/admin/edit/{{ $prod->id }}"><button type="button" class="btn btn-primary">Edit</button></a>
                                        <a href="/admin/delete/{{ $prod->id }}"><button type="button" class="btn btn-danger">Delete</button></a>
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
                            {{$product->links()}}
                        </div>
                    </div>
                </div>
            </div>
</div>
@endsection