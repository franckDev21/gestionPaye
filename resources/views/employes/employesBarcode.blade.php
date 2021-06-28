@extends('base')

@section('title')
    Code barre
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/barcode.css') }}">
@endsection

@section('col')
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Details-->
            <div class="d-flex align-items-center flex-wrap mr-2">
                <!--begin::Title-->
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Code barre</h5>
                <!--end::Title-->



            </div>
            <!--end::Details-->
            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
                <!--begin::Button-->
                <a href="#" class=""></a>
                <!--end::Button-->
                <!--begin::Button-->
                <button class="btn btn-primary font-weight-bold py-2 px-5 ml-2" data-toggle="modal"
                    data-target="#exampleModal">télecharger le code barre de tous le employés &nbsp;<i class="fas fa-download"></i></button>
                <!--end::Button-->
            </div>
            <!--end::Toolbar-->
        </div>
    </div>
@endsection


@section('content')
    <div class="container">
        <div class="card p-d">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form">
                            <input type="text" placeholder="Rechercher un employé" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-7"></div>
                </div>
                <hr>
                <div class="row mb-4">
                    @forelse ($barcodes as $barcode)
                        <div class="col-md-4 barcode">
                            <img src="/images/barcode.svg" alt="">
                            <div class="">
                                <strong>{{ $barcode->employe->noms_prenoms }}</strong>
                                <div class="span">{{ $barcode->employe->matricule }}</div>
                            </div>
                            <a href="/download/{{ $barcode->employe->id }}/barcode" class="btn btn-primary">Télécharger &nbsp;<i class="fas fa-download"></i></a>
                        </div>
                    @empty
                        Aucun employe
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
