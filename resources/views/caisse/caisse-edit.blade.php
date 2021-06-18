@extends('base')

@section('title')
    Modifier Montant
@endsection

@section('col')
	<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
       <!--begin::Title-->
	   <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">CAISSE</h5>
		<!--end::Title-->
		<!--begin::Separator-->
		<div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
		<!--end::Separator-->
		<!--begin::Search Form-->
		<div class="d-flex align-items-center" id="kt_subheader_search">
			<span class="text-dark-50 font-weight-bold" id="kt_subheader_total">Modifier un Montant</span>
		</div>
		<!--end::Search Form-->     
	</div>
@endsection
@section('content')
       
   <!--begin::Container-->
							<div class="container">
								<!--begin::Card-->
								<div class="card card-custom gutter-b">
									<!--begin::Body-->
									<div class="card-body p-0">
										<!--begin::Wizard-->
										<div class="wizard wizard-1" id="kt_contact_add" data-wizard-state="step-first" data-wizard-clickable="true">
											
											<!--begin::Wizard Body-->
											<div class="row justify-content-center my-10 px-8 my-lg-15 px-lg-10">
												<div class="col-xl-12 col-xxl-7">
													<!--begin::Form Wizard Form-->
													<form action="/modifie-montant/{{$caisse->id}}" class="form" id="kt_contact_add_form" method="POST">
														@csrf
														<!--begin::Form Wizard Step 1-->
														<div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
															  
															<div class="row">
																<div class="col-xl-12">
																	<input type="hidden" name="id" value="">
																	<div class="form-group row">
																		<label class="col-xl-3 col-lg-3 col-form-label">Montant</label>
																		<div class="col-lg-9 col-xl-9">
																			<input class="form-control form-control-lg form-control-solid" name="montant" type="number" value="{{$caisse->montant}}" />
																		</div>
																	</div>	
																	
																</div>
															</div>
														</div>
														<!--end::Form Wizard Step 1-->
														<!--begin::Wizard Actions-->
														<div class="modal-footer">
															
															
															<div>
																 <button type="submit" class="btn btn-success font-weight-bolder  px-9 py-4">Modifier</button>
															     <a href="/caisse"   class="btn btn-danger font-weight-bolder px-9 py-4">Annuler</a>
															</div>
															
														</div>
														<!--end::Wizard Actions-->	
													</form>
													<!--end::Form Wizard Form-->
												</div>
											</div>
											<!--end::Wizard Body-->
										</div>
										<!--end::Wizard-->
									</div>
									<!--end::Body-->
								</div>
								<!--end::Card-->
							</div>
							<!--end::Container-->
@endsection