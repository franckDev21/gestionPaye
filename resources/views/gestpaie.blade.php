@extends('base')

@section('title')

@endsection

@section('css')
    <link href="css/main.css" rel="stylesheet" />
    <link href="{{asset('css/search.css')}}" rel="stylesheet" />
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
        
        <div class="search">
            <div class="search__content">
                <div class="search__label">Rechercher un employé</div>
                <form class="search__form" method="post" action="/search">
                    @csrf
                    @method('POST')
                    <input class="search__input" type="text" placeholder="Entrez le matricule de l'employé"
                        name="query">
                    <button class="search__btn" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
    </div>

@endsection


@section('scripts')
    <script src="js/extention/choices.js"></script>
    <script>
        var textPresetVal = new Choices('#choices-text-preset-values', {
            removeItemButton: true,
        });

    </script>

@endsection
