@extends('base')

@section('title')

@endsection

@section('banner')
    <img style="width: 100%; height: 100%;" src="{{ asset('images/banner.jpg') }}" alt="">
@endsection

@section('css')
    <link href="css/main.css" rel="stylesheet" />
    <link href="{{ asset('css/search.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/loader.css') }}" rel="stylesheet" />
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
        @if (session()->has('message'))
            <div class="alert" style="background-color:#dc0f357a;color:#fff">{{ session()->get('message') }}</div>
        @endif

        <div class="error"></div>

        <div class="search">
            <div class="load notVisible">
                <span class="loader-q loader_"></span>
                Chargement...
            </div>
            <div class="search__content">
                <div class="search__label">Rechercher un employé</div>
                <form class="search__form" method="post" action="/search">
                    @csrf
                    @method('POST')
                    <input class="search__input" type="text" placeholder="Entrez le matricule de l'employé" name="query">
                    <button class="search__btn" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
    </div>

@endsection


@section('scripts')
    <script src="js/extention/choices.js"></script>
    <script>
        window.onload = () => {
            let form  = document.querySelector('.search__form')
            let input = document.querySelector('.search__input')
            let load  = document.querySelector('.load')
            let error = document.querySelector('.error')

            input.addEventListener('keyup', e => {
                let inputValue = input.value
                if(inputValue === ''){
                    error.innerHTML = ""
                }
                if (inputValue.length === 10) {
                    let xhr = new XMLHttpRequest()
                    let data = new FormData(form)
                    xhr.open('POST', "/searchAjax", true)
                    xhr.setRequestHeader('x-csrf-token', "<?= $token ?>")
                    xhr.send(data)

                    xhr.onreadystatechange = () => {
                        load.classList.remove('notVisible')
                        if (xhr.readyState === xhr.DONE) {
                            if (xhr.status === 200) {
                                error.innerHTML = ""
                                load.classList.add('notVisible')
                                let dataGet = xhr.responseText
                                if(dataGet !== 'empty'){
                                    dataGet = JSON.parse(xhr.responseText)
                                    window.location = `/employe/${dataGet[0].id}`
                                }else{
                                    load.classList.add('notVisible')
                                    error.innerHTML = "<div class=\"alert\" style=\"background-color:#dc0f357a;color:#fff\">Aucun employé ne correspond a ce matricule</div>"
                                }
                            }
                        }
                    }
                }
            })
        }
    </script>

@endsection
