@extends('base')

@section('title')
    Primes
@endsection

@section('col')
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Details-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">PRIMES</h5>
									<!--end::Title-->
									
									
									
								</div>
								<!--end::Details-->
								<!--begin::Toolbar-->
								<div class="d-flex align-items-center">
									<!--begin::Button-->
									<a href="#" class=""></a>
									<!--end::Button-->
									<!--begin::Button-->
									<button class="btn btn-primary font-weight-bold py-2 px-5 ml-2" data-toggle="modal" data-target="#exampleModal">Attribuer Prime</button>
									<!--end::Button-->
									
								</div>
								<!--end::Toolbar-->
							</div>
                </div>
@endsection


@section('content')
	


								<div class="container">
								
								<!--begin::Card-->
								<div class="card card-custom">
									

      <!--#######################################################################################------->

<!---------------------------------ADD-------------------------------------------------->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Attribuer la prime à un employé</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/save-prime" method="POST">
      @csrf
        <div class="modal-body">
                   <div class="form-group">
                        <label>Matricule</label>
                        <input type="text" name="matricule" class="form-control" required>
                    </div>
                    

           </div>
                <div class="modal-footer">
                    <button type="submit"  class="btn btn-success ">Enregistrer</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button> 
                </div>
         </form>
      </div>  
    </div>
  </div>

  <!--###########################################################################################################################-->

                 
			<div class="card-body">
                <div class="table-responsive">
                  <table id="example" class="table">
                    <thead>
					<th>Montant(FCFA)</th>
			    <th>Ajouté le : </th>
          
          <th>EDIT</th>
          <th>DELETE</th>
                     
                    </thead>
                    <tbody>
              @foreach( $prime as $row)
                      <tr>
                       
                <td> {{$row->matricule}}</td>
                <td> {{$row->created_at}}</td>
                
                <td ><a href="edit-montant/{{$row->id}}" class="btn btn-success"> EDIT</a></td>
                <td ><a href="edit-montant/{{$row->id}}" class="btn btn-danger"> DELETE</a></td>
                    </tr>
                    @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
    </div>
							</div>
							<!--end::Container-->
@endsection

@section('scripts')

<script src="assets/js/pages/custom/contacts/list-datatable.js"></script>
	<script>
  $(document).ready( function () {
    $('#example').DataTable();
} );
</script>
@endsection