@extends('admin/layout')

@section('space-work')
<div class="row">

        



<div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h5>Wishlist view</h5>
                        
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                       
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Product</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if (count($wishlist) > 0)
                                   @foreach ($wishlist as $key=> $crt)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $crt->user->name }}</td>
                                        <td>{{ $crt->product->productname}}</td>
                                    </tr>
                                    @endforeach
                                @else
                                <tr>
                                  <td>No Data</td>
                                </tr>
                                @endif
                                </tbody>
                            </table>
                            {{$wishlist->links()}}
                        </div>
                    </div>
                </div>
            </div>
</div>
@endsection