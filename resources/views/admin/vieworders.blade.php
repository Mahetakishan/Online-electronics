@extends('admin/layout')

@section('space-work')
<div class="row">

        



<div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                    @if(Session::has('update'))

                     <div class="alert alert-success">{{ Session::get('update') }}</div>
                     @endif
                        <h5>Order view</h5>
                        
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                       
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Contactno</th>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th colspan="4" style="text-align:center;">Address </th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if (count($order) > 0)
                                   @foreach ($order as $key=> $odr)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $odr->user->name }}</td>
                                        <td>{{ $odr->contactno }}</td>
                                        <td>{{ $odr->product->productname}}</td>
                                        <td>{{ $odr->product->price}}</td>
                                        <td>{{ $odr->quantity}}</td>
                                        <td>{{ $odr->total}}</td>
                                        <td>City: {{ $odr->city->city_name }}</td>
                                        <td>State: {{ $odr->state->state_name }}</td>
                                        <td>Country: {{ $odr->country->country_name }}</td>
                                        <td>Pincode: {{ $odr->pincode }}</td>
                                        <td>{{ $odr->status }}</td>
                                        <td>
                                        @if($odr->status !== 'Delivered')
                                        <a href="/admin/updatestatus/{{ $odr->id }}" class="btn btn-primary">Delivered</a>
                                        @else
                                        <button type="button" class="btn btn-primary" disabled>Delivered</button>
                                        @endif
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
                            {{$order->links()}}
                        </div>
                    </div>
                </div>
            </div>
</div>


@endsection