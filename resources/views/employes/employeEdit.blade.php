@extends('base')

@section('title')
    Modifier Employés
@endsection

@section('col')
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Details-->
            <div class="d-flex align-items-center flex-wrap mr-2">
                <!--begin::Title-->
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">EMPLOYES</h5>
                <!--end::Title-->
                <!--begin::Separator-->
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                <!--end::Separator-->
                <!--begin::Search Form-->
                <div class="d-flex align-items-center" id="kt_subheader_search">
                    <span class="text-dark-50 font-weight-bold" id="kt_subheader_total">Modifier Employé</span>

                </div>
                <!--end::Search Form-->

            </div>
            <!--end::Details-->

        </div>
    </div>
@endsection

@section('content')

    <!--begin::Container-->
    <div class="container">
        <!--begin::Profile Personal Information-->
        <div class="d-flex flex-row">

            <!--begin::Content-->
            <div class="flex-row-fluid ml-lg-8">
                <!--begin::Card-->
                <div class="card card-custom card-stretch">
                    <!--begin::Header-->
                    <div class="card-header py-3">
                        <div class="card-title align-items-start flex-column">
                            <h3 class="card-label font-weight-bolder text-dark">Informations Employés</h3>
                            <span class="text-muted font-weight-bold font-size-sm mt-1">Mettre à jour</span>
                        </div>
                        <!--begin::Form-->
                        <form class="form" action="/employe/{{ $employe->id }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
							@method('PATCH')
                            <div class="card-toolbar">
                                <button type="submit" class="btn btn-success mr-2">Modifier</button>
                                <a href="/employe" class="btn btn-danger">Annuler</a>
                            </div>
                    </div>
                    <!--end::Header-->

                    <!--begin::Body-->
                    <div class="card-body">

                        <input type="hidden" name="id" value="">

                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Photo</label>
                            <div class="col-lg-9 col-xl-9">
                                <input type="file" name="profile" class="custom-file-input" id="inputGroupFile04"
                                    value="{{ $employe->profile }}">
                                <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
                                <img class="img-circle" src="{{ asset('uploads/employes/' . $employe->profile) }}"
                                    width="70px" height="70px">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Matricule</label>
                            <div class="col-lg-9 col-xl-9">
                                <input class="form-control form-control-lg form-control-solid" name="matricule" type="text"
                                    value="{{ $employe->matricule }}" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Noms_Prenoms</label>
                            <div class="col-lg-9 col-xl-9">
                                <input class="form-control form-control-lg form-control-solid" name="noms_prenoms"
                                    type="text" value="{{ $employe->noms_prenoms }}" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">CNI</label>
                            <div class="col-lg-9 col-xl-9">
                                <input class="form-control form-control-lg form-control-solid" name="cni" type="text"
                                    value="{{ $employe->cni }}" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Telephone</label>
                            <div class="col-lg-9 col-xl-9">
                                <div class="input-group input-group-lg input-group-solid">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="la la-phone"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control form-control-lg form-control-solid"
                                        name="telephone" value="{{ $employe->telephone }}" placeholder="Phone" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Email </label>
                            <div class="col-lg-9 col-xl-9">
                                <div class="input-group input-group-lg input-group-solid">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="la la-at"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control form-control-lg form-control-solid" name="email"
                                        value="{{ $employe->email }}" placeholder="Email" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Date Naissance</label>
                            <div class="col-lg-9 col-xl-9">
                                <div class="input-group input-group-lg input-group-solid">
                                    <input type="date" class="form-control form-control-lg form-control-solid"
                                        value="{{ $employe->date_naissance }}" name="date_naissance" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Ville</label>
                            <div class="col-lg-9 col-xl-9">
                                <div class="input-group input-group-lg input-group-solid">
                                    <input type="text" class="form-control form-control-lg form-control-solid" name="ville"
                                        value="{{ $employe->ville }}" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Addresse</label>
                            <div class="col-lg-9 col-xl-9">
                                <div class="input-group input-group-lg input-group-solid">
                                    <input type="text" class="form-control form-control-lg form-control-solid"
                                        name="addresse" value="{{ $employe->addresse }}" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Grade</label>
                            <div class="col-lg-9 col-xl-9">
                                <select name="grade" class="form-control form-control-lg form-control-solid"
                                    value="{{ $employe->grade }}">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Departement</label>
                            <div class="col-lg-9 col-xl-9">
                                <select name="departement" class="form-control form-control-lg form-control-solid"
                                    value="{{ $employe->departement }}">
                                    <option value="finance">FINANCE</option>
                                    <option value="informatique">INFORMATIQUE</option>
                                    <option value="marketing">MARKETING</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Poste</label>
                            <div class="col-lg-9 col-xl-9">
                                <div class="input-group input-group-lg input-group-solid">
                                    <input type="text" class="form-control form-control-lg form-control-solid" name="poste"
                                        value="{{ $employe->poste }}" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Sexe</label>
                            <div class="col-lg-9 col-xl-9">
                                <select name="sexe" class="form-control form-control-lg form-control-solid"
                                    value="{{ $employe->sexe }}">
                                    <option value="homme">homme</option>
                                    <option value="femme">femme</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <!--end::Body-->
                    </form>
                    <!--end::Form-->
                </div>
            </div>
            <!--end::Content-->
        </div>
        <!--end::Profile Personal Information-->
    </div>
    <!--end::Container-->

@endsection


@section('scripts')

@endsection
