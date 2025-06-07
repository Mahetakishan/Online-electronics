@extends('admin/layout')

@section('space-work')
<div class="row">

        



<div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h5>Sub category view</h5>
                        
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
                                        <th>Sub Category Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if (count($subcat) > 0)
                                   @foreach ($subcat as $key=> $scat)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        
                                        <td>{{ $scat->category->categoryname }}</td>
                                       
                                        <td>{{ $scat->subcategoryname }}</td>
                                       
                                        
                                        <td>

                                        <a href="/admin/editsubcategory/{{ $scat->id }}"><button type="button" class="btn btn-primary">Edit</button></a>
                                        <!-- <a href="/admin/deletesubcategory/{{ $scat->id }}"><button type="button" class="btn btn-danger">Delete</button></a> -->
                                        <button type="button" value="{{ $scat->id }}" class="btn btn-danger deletebutton">Delete</button>
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
                            {{$subcat->links()}}
                            <div class="modal fade" id="DeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Subcategory</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="delete-subcategory" method="POST" >
        @csrf
         @method('DELETE')
         <p>Are you sure you want to delete this subcategory?</p>
         <input type="hidden" id="deleting_id" name="delete_user_id">
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger">Yes delete</button>
      </div>
      </form>
    </div>
  </div>
</div>    
<script>
         $(document).ready(function(){
         $(document).on('click','.deletebutton',function(){
         var user_id = $(this).val();
         $('#DeleteModal').modal('show');
         $('#deleting_id').val(user_id);
         });
        });
        </script>
                        </div>
                    </div>
                </div>
            </div>
</div>




@endsection