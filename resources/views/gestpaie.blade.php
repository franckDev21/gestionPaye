@extends('base')

@section('title')

@endsection

@section('css')
    <link href="css/main.css" rel="stylesheet" />
@endsection

@section('col')
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">

    </div>
@endsection

@section('content')

    <div class="container">
        @error('query')
            <div class="alert" style="background-color:#dc0f357a;color:#fff">Le champ ne doit pas être vide</div>
        @enderror
        @if(session()->has('message'))
            <div class="alert" style="background-color:#dc0f357a;color:#fff">{{  session()->get('message') }}</div>
        @endif
        <!--begin::Card-->
        <div class="card card-custom">
            <div class="card-header flex-wrap py-5 justify-content-center">
                <div class="card-title">
                    <h3 class="card-label">Voulez-vous payer un employé???</h3>
                </div>
                <form class="form-inline my-2 my-lg-0" method="post" action="/search">
                    @csrf

                    <input class="form-control mr-sm-2" type="text" placeholder="Entrez le matricule de l'employé"
                        name="query">
                    <button class="btn btn-primary my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
            </div>
            </form>


        </div>

        <div class="s004">
            {{-- <form class="form-inline my-2 my-lg-0" method="post" action="{{url('search')}}">
      {{method_field('post')}}
	     @csrf
        <fieldset>
          <legend>Voulez-Vous payer les primes d'un employé?</legend>
          <div class="inner-form">
            
          </div>
          
        </fieldset>
      </form> --}}
        </div>

    </div>
    <!--end::Container-->




@endsection


@section('scripts')
    <script src="js/extention/choices.js"></script>
    <script>
        var textPresetVal = new Choices('#choices-text-preset-values', {
            removeItemButton: true,
        });

    </script>

@endsection
