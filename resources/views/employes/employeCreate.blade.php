@extends('base')

@section('title')
    Enregistrer Employés
@endsection

@section('css')

    <!--begin::Page Custom Styles(used by this page)-->
    <link href="assets/css/pages/wizard/wizard-1.css" rel="stylesheet" type="text/css" />
@endsection

@section('col')

    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <!--begin::Title-->
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Nouvel Employé</h5>
        <!--end::Title-->
        <!--begin::Separator-->
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
        <!--end::Separator-->
        <!--begin::Search Form-->
        <div class="d-flex align-items-center" id="kt_subheader_search">
            <span class="text-dark-50 font-weight-bold" id="kt_subheader_total">Entrer les informations d'un employé et
                Enregistrer</span>
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
                <div class="wizard wizard-1" id="kt_contact_add" data-wizard-state="step-first"
                    data-wizard-clickable="true">

                    <!--begin::Wizard Body-->
                    <div class="row justify-content-center my-10 px-8 my-lg-15 px-lg-10">
                        <div class="col-xl-12 col-xxl-7">
                            <!--begin::Form Wizard Form-->
                            <form class="form" id="kt_contact_add_form" action="/employe" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <!--begin::Form Wizard Step 1-->
                                <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                                    <h3 class="mb-10 font-weight-bold text-dark">Ajouter un Employé</h3>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Photo</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <div class="image-input image-input-outline" id="kt_contact_add_avatar">
                                                        <div class="image-input-wrapper"
                                                            style="background-image: url(assets/media/users/100_2.jpg)">
                                                        </div>
                                                        <label
                                                            class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                            data-action="change" data-toggle="tooltip" title=""
                                                            data-original-title="Change avatar">
                                                            <i class="fa fa-pen icon-sm text-muted"></i>
                                                            <input type="file" name="profile" accept=".png, .jpg, .jpeg" />
                                                            <input type="hidden" name="profile_avatar_remove" />
                                                        </label>
                                                        <span
                                                            class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                            data-action="cancel" data-toggle="tooltip"
                                                            title="Cancel avatar">
                                                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">matricule</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <input class="disabled form-control form-control-lg form-control-solid @error('matricule') is-invalid @enderror"
                                                        name="matricule" value="{{$matricule ?? old('matricule')}}" type="text" />
                                                    @error('matricule') 
                                                        <div class="invalid-feedback" style="background-color:#fff">
                                                            {{ $errors->first('matricule') }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Noms_Prenoms</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <input placeholder="Entrer le nom et le prenom de l'employé" class="form-control form-control-lg form-control-solid @error('noms_prenoms') is-invalid @enderror"
                                                        name="noms_prenoms" type="text" value="{{old('noms_prenoms')}}" />
                                                    @error('noms_prenoms') 
                                                        <div class="invalid-feedback" style="background-color:#fff">
                                                            {{ $errors->first('noms_prenoms') }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">CNI</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <input placeholder="Entrer le numéro de cni " class="form-control form-control-lg form-control-solid @error('cni') is-invalid @enderror"
                                                        name="cni" type="text" value="{{old('cni')}}" />
                                                    @error('cni') 
                                                        <div class="invalid-feedback" style="background-color:#fff">
                                                            {{ $errors->first('cni') }}
                                                        </div>
                                                    @enderror
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
                                                        <input type="text"
                                                            class="form-control form-control-lg form-control-solid @error('telephone') is-invalid @enderror"
                                                            name="telephone" value="{{old('telephone')}}" placeholder="Entrer le numéro de téléphone" />
                                                        @error('telephone') 
                                                            <div class="invalid-feedback" style="background-color:#fff">
                                                                {{ $errors->first('telephone') }}
                                                            </div>
                                                        @enderror
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
                                                        <input type="text"
                                                            class="form-control form-control-lg form-control-solid @error('email') is-invalid @enderror"
                                                            name="email" value="{{old('email')}}" placeholder="Email (anna.krox@loop.com)" />
                                                            @error('email') 
                                                                <div class="invalid-feedback" style="background-color:#fff">
                                                                    {{ $errors->first('email') }}
                                                                </div>
                                                            @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Date Naissance</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <div class="input-group input-group-lg input-group-solid">
                                                        <input type="date" value="{{old('date_naissance')}}"
                                                            class="form-control form-control-lg form-control-solid @error('date_naissance') is-invalid @enderror"
                                                            name="date_naissance" placeholder="Entrer la date naissance" />
                                                        @error('date_naissance') 
                                                            <div class="invalid-feedback" style="background-color:#fff">
                                                                {{ $errors->first('date_naissance') }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Ville</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <div class="input-group input-group-lg input-group-solid">
                                                        <input type="text" value="{{old('ville')}}"
                                                            class="form-control form-control-lg form-control-solid @error('ville') is-invalid @enderror"
                                                            name="ville" placeholder="Entrer la ville" />
                                                        @error('ville') 
                                                            <div class="invalid-feedback" style="background-color:#fff">
                                                                {{ $errors->first('ville') }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Addresse</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <div class="input-group input-group-lg input-group-solid">
                                                        <input type="text" value="{{old('addresse')}}"
                                                            class="form-control form-control-lg form-control-solid @error('addresse') is-invalid @enderror"
                                                            name="addresse" placeholder="Entrer l'adresse de l'employé" />
                                                        @error('addresse') 
                                                            <div class="invalid-feedback" style="background-color:#fff">
                                                                {{ $errors->first('addresse') }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Grade</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <select name="grade"
                                                        class="form-control form-control-lg form-control-solid @error('grade') is-invalid @enderror">
                                                        <option value="A">A</option>
                                                        <option value="B">B</option>
                                                        <option value="C">C</option>
                                                    </select>
                                                    @error('grade') 
                                                        <div class="invalid-feedback" style="background-color:#fff">
                                                            {{ $errors->first('grade') }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Departement</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <select name="departement"
                                                        class="form-control form-control-lg form-control-solid @error('departement') is-invalid @enderror">
                                                        <option value="finance">FINANCE</option>
                                                        <option value="informatique">INFORMATIQUE</option>
                                                        <option value="marketing">MARKETING</option>
                                                    </select>
                                                    @error('departement') 
                                                        <div class="invalid-feedback" style="background-color:#fff">
                                                            {{ $errors->first('departement') }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Poste</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <div class="input-group input-group-lg input-group-solid">
                                                        <input type="text" value="{{old('poste')}}" placeholder="Entrer le poste de l'employé"
                                                            class="form-control form-control-lg form-control-solid @error('poste') is-invalid @enderror"
                                                            name="poste" />
                                                        @error('poste') 
                                                            <div class="invalid-feedback" style="background-color:#fff">
                                                                {{ $errors->first('poste') }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Sexe</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <select name="sexe"
                                                        class="form-control form-control-lg form-control-solid @error('sexe') is-invalid @enderror">
                                                        <option value="homme">homme</option>
                                                        <option value="femme">femme</option>
                                                    </select>
                                                    @error('sexe') 
                                                        <div class="invalid-feedback" style="background-color:#fff">
                                                            {{ $errors->first('sexe') }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>



                                        </div>
                                    </div>
                                </div>
                                <!--end::Form Wizard Step 1-->
                                <!--begin::Wizard Actions-->
                                <div class="modal-footer">
                                    <div>
                                        <button type="submit"
                                            class="btn btn-success font-weight-bolder text-uppercase px-9 py-4">Enregistrer</button>
                                        <a href="/employe"
                                            class="btn btn-danger font-weight-bolder text-uppercase px-9 py-4">Annuler</a>
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

@section('scripts')
    <script>
        let fieldsDisabled = document.querySelector('input.disabled')
        fieldsDisabled.addEventListener('keydown',e=>e.preventDefault())
    </script>

    <script src="assets/js/pages/custom/contacts/add-contact.js"></script>

@endsection
