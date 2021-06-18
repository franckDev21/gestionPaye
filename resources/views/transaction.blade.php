@extends('base')



@section('title')
    Transactions
@endsection


@section('content')
   					<div class="container">
								
								<!--begin::Card-->
								<div class="card card-custom">
									<div class="card-header flex-wrap py-5">
										<div class="card-title">
											<h3 class="card-label">Informations Transactions</h3>
										</div>
										<div class="card-toolbar">
											<!--begin::Dropdown-->
											
											<!--end::Dropdown-->
											<!--begin::Button-->
											<a  class="btn btn-primary font-weight-bolder" ><i class="fa fa-plus"></i>
											</a>
											<!--end::Button-->
										</div>
									</div>



                 
			<div class="card-body">
                <div class="table-responsive">
                  <table id="example" class="table">
                    <thead>
						<th> ID</th>
						<th>Noms</th>
						<th>Grade</th>
						<th>Prime1</th>
						<th>Prime2</th>
						<th>Prime3</th>
						<th> Prime_Payé</th>
                        <th> status</th>
						<th > Date</th>
					
                    </thead>
                    <tbody>
                          @foreach( $data as $row)
                            
						<tr>
                       
                <td> {{$row->id}}</td>
                <td> {{$row->noms_prenoms}}</td>

                <td>{{$row->grade}}  </td>

                 <td>{{$row->prime1}}</td>

				<td>{{$row->prime2}}  </td>

                <td>{{$row->prime3}}</td>

				 <td>{{$row->prime_paye}}</td>

                <td ><button type="button" class="btn btn-primary"> {{$row->status}}</a></td>

				 <td>{{$row->date}}</td>	 

				 
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

	<script>
  $(document).ready( function () {
    $('#example').DataTable();
} );

</script>

@endsection