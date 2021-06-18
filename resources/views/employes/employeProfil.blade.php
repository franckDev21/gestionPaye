@extends('base')

@section('col')
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">

    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profil.css') }}">
@endsection

@section('content')



    <!--begin::Container-->
    <div class="container">
        <div class="row">
            <div class="col-md-7 card p-4 m-4">
                <span class="card__span">Profil de l'employé</span>
                <div class="card__profil">
                    <img class="card__img" src="{{ asset('uploads/employes/' . $employe[0]->profile) }}">
                </div>
                <hr>
                <div class="row mt-4">
                    <div class="col-md-4">
                        <label for="">nom/prenom</label>
                        <div class="card__label form-group p-3">
                            {{ $employe[0]->noms_prenoms }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="">Matricule</label>
                        <div class="card__label form-group p-3">
                            {{ $employe[0]->matricule }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="">téléphone</label>
                        <div class="card__label form-group p-3">
                            {{ $employe[0]->telephone }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="">Email</label>
                        <div class="card__label form-group p-3">
                            {{ $employe[0]->email }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="">Ville</label>
                        <div class="card__label form-group p-3">
                            {{ $employe[0]->ville }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="">Adresse</label>
                        <div class="card__label form-group p-3">
                            {{ $employe[0]->addresse }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="">cni</label>
                        <div class="card__label form-group p-3">
                            {{ $employe[0]->cni }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="">date de naissance</label>
                        <div class="card__label form-group p-3">
                            {{ $employe[0]->date_naissance }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="">poste</label>
                        <div class="card__label form-group p-3">
                            {{ $employe[0]->poste }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="">grade</label>
                        <div class="card__label form-group p-3">
                            {{ $employe[0]->grade }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="">departement</label>
                        <div class="card__label form-group p-3">
                            {{ $employe[0]->departement }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="">sexe</label>
                        <div class="card__label form-group p-3">
                            {{ $employe[0]->sexe }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9"></div>
                    <div class="col-md-3" style="text-align:right"><a href="#" class="btn btn-success">modifier le profil</a></div>
                </div>
            </div>
            <div class="col-md-4 card p-4 m-4">
                <div class="card__montant">
                    <span class="card__prime">total prime</span>
                    {{$totalPrimeCalculer}} F
                </div>
                <div class="card__list">
                    <div class="card__items">
                        <span>Prime A</span>
                        <span>{{ $totalPrime['primeA'] }} F</span>
                    </div>
                    <div class="card__items">
                        <span>Prime B</span>
                        <span>{{ $totalPrime['primeB'] }} F</span>
                    </div>
                    <div class="card__items">
                        <span>Prime C</span>
                        <span>{{ $totalPrime['primeC'] }} F</span>
                    </div>
                </div>
                <form action="/decaisser/{{$employe[0]->id}}" class="inline-block" style="border:none;outline:none;margin:0 auto; width:60%;" method="POST" >
                    @csrf
                    @method('POST')
                    <input type="submit" class="card__btn" value="Décaisser">
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 card p-4 m-4">
                <div class="h2">Transactions Entrantes</div>
                <hr>
                @empty($transactoinInt[0])
                    <div class="card__transaction_noting">
                        Aucune transaction
                    </div>
                @else
                    @foreach ($transactoinInt as $transaction)
                        <div class="card__transaction">
                            <div class="card__date">{{$transaction->created_at->format('d M Y')}} <em style="font-size: 14px;font-weight:lighter">( de la caisse {{ $transaction->montant }}F )</em></div>
                            <div class="card__recu">
                                <div class="card__prix">montant total recu {{ $transaction->totalPrimes }} FCFA</div>
                                <div class="card__list-recu">
                                    <div class="card__items-recu">
                                        <strong>Prime A</strong>
                                        <span>{{ $transaction->primeA }} F</span>
                                    </div>
                                    <div class="card__items-recu">
                                        <strong>Prime B</strong>
                                        <span>{{ $transaction->primeB}} F</span>
                                    </div>
                                    <div class="card__items-recu">
                                        <strong>Prime C</strong>
                                        <span>{{ $transaction->primeC }} F</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endempty
            </div>
            <div class="col-md-5 card p-4 m-4">
                <div class="h2">Transactions Sortantes</div>
                <hr>
                @empty($transactoinOut[0])
                    <div class="card__transaction_noting out">
                        Aucune transaction
                    </div>
                @else
                    @foreach ($transactoinOut as $transaction)
                        <div class="card__transaction out">
                            <div class="card__date">{{ $transaction->created_at->format('d M Y') }}</div>
                            <div class="card__recu">
                                <div class="card__prix">montant total rétirer {{ $transaction->montant }} FCFA</div>
                            </div>
                        </div>
                    @endforeach
                @endempty
            </div>
        </div>
    </div>
    <!--end::Container-->

@endsection

@section('scripts')
    <script>
        
    </script>
@endsection
