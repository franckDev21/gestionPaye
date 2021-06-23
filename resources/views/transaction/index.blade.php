@extends('base')

@section('col')
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
		<h4 class="ml-3 p-2">Transactions</h4>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/transaction.css') }}">
@endsection

@section('content')


	<div class="container">
		<div class="error_message"></div>
		<div class="card">
				<div class="card-header">
					<div class="row align-items-center">
						<div class="col-md-5">
							<form id="form" style="transform: translateX(-10px)" action="#" class="form search">
								<input autocomplete="off" placeholder="Rechercher un employé" type="texte" name="q" class="inputSearch form-control">
								<div class="result"></div>
							</form>
						</div>
						<div class="col-md-4  p-4 parent__employer">
							<span class="h5 text-center employe" style="color: #606060">Aucun Employé (veillez rechercher un employé)</span>
						</div>
						<div class="col-md-3">
							<button  style="border-radius: 0" class="btn_ref_form2 btn btn-lg btn-primary">Rechercher transaction(s)</button>
						</div>
					</div>
				<form action="/searchTransaction" method="POST" class="form2">
					@csrf
					@method('POST')
					<div style="z-index: 1" class="row mt-2 align-items-center bg bg-light-primary p-2">
						<div class="col-md-2 h6">Type de transaction</div>
						<div class="col-md-1">
							<label for="transactionInt" style="color:var(--primary);font-weight:bold">Entrante</label> <input type="checkbox" class="checkbox"  style="height: 18px;width:18px" name="transactionInt" id="transactionInt">
						</div>
						<div class="col-md-1">
							<label for="transactionOut" style="color:var(--primary);font-weight:bold">Sortante</label> <input type="checkbox" class="checkbox"  style="height: 18px;width:18px" name="transactionOut" id="transactionOut">
						</div>
						<div class="col-md-3">
							<label for="debut">date debut</label>
							<input type="date" name="debut" class="form-control" id="debut">
						</div>
						<div class="col-md-3">
							<label for="fin">date fin</label>
							<input type="date" name="fin" class="form-control" id="fin">
						</div>
						<div class="col-md-2">
							<label for="order">Trier par ordre</label>
							<div class="d-flex align-items-center">
								<strong style="color:var(--primary)">Desc</strong>&nbsp;<input  type="radio" style="height: 18px;width:18px" value="desc" name="trie" class="mr-1" id="">
								&nbsp;&nbsp;&nbsp; <strong style="color:var(--primary)">Asc</strong>&nbsp;<input type="radio" style="height: 18px;width:18px" value="asc" name="trie" class="mr-1" id="">
							</div>
						</div>
					</div>
				</form>
				</div>
			
			<div class="card-body row">
				@empty($all)
					<div class="result__card noting p-4" style="width: 100%;">
						<div class="result_noting p-4">Aucune transaction effectué</div>
					</div>
				@else
					<table class="table table-head-custom table-responsive-sm">
						<thead>
							<tr>
								<th></th>
								<th>Type</th>
								<th>Employé</th>
								<th>Montant</th>
								<th>Date (reception/retrait)</th>
								<th>Provient de la caisse</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($all as $item)
								@if ($item instanceof $classNameInt)
									<tr style="background-color: #06af1534">
										<td>
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20pt" height="20pt" viewBox="0 0 30 30" version="1.1">
												<g id="surface1">
													<path style=" stroke:none;fill-rule:nonzero;fill:#109c10;fill-opacity:1;" d="M 24.671875 3.949219 C 24.648438 3.949219 22.265625 3.96875 19.84375 5.839844 C 16.714844 8.257813 14.984375 12.710938 14.816406 18.75 L 18.75 18.75 C 19.148438 18.75 19.507813 18.988281 19.664063 19.359375 C 19.8125 19.730469 19.730469 20.152344 19.449219 20.433594 L 12.539063 27.34375 C 12.15625 27.726563 11.53125 27.726563 11.144531 27.34375 L 4.238281 20.433594 C 3.957031 20.152344 3.871094 19.730469 4.019531 19.359375 C 4.175781 18.988281 4.539063 18.75 4.933594 18.75 L 8.898438 18.75 C 9.429688 2.453125 23.085938 1.972656 24.671875 1.972656 C 25.21875 1.972656 25.65625 2.417969 25.65625 2.960938 C 25.65625 3.503906 25.21875 3.949219 24.671875 3.949219 Z "/>
												</g>
											</svg>
										</td>
										<td><strong style="font-size: 17px; color:#109c10;">Prime</strong></td>
										<td>
											<strong><?= getEmploye($item->id_employe)->noms_prenoms ?></strong> <br>
											<em><?= getEmploye($item->id_employe)->matricule ?></em>
										</td>
										<td>
											<strong style="font-size: 17px">{{floor($item->totalPrimes)}} FCFA</strong>
										</td>
										<td> 
											<span style="font-size: 16px">{{$item->created_at->format('d M Y')}}</span><br>
											<em>(le {{$item->created_at->format('d/m/Y \a H\hi ')}})</em>
										</td>
										<td>
											<strong style="font-size: 17px"><?= getCaisse($item->id_caisse)->montant ?> FCFA</strong>
										</td>
									</tr>
								@else
									<tr style="background-color: #f64e5f34">
										<td>
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20pt" height="20pt" viewBox="0 0 30 30" version="1.1">
												<g id="surface1">
													<path style=" stroke:none;fill-rule:nonzero;fill:#F64E60;fill-opacity:1;" d="M 4.933594 25.65625 C 4.957031 25.65625 7.339844 25.636719 9.757813 23.765625 C 12.890625 21.347656 14.621094 16.894531 14.789063 10.855469 L 10.855469 10.855469 C 10.457031 10.855469 10.097656 10.617188 9.941406 10.246094 C 9.792969 9.875 9.875 9.453125 10.15625 9.171875 L 17.066406 2.261719 C 17.449219 1.878906 18.074219 1.878906 18.460938 2.261719 L 25.367188 9.171875 C 25.648438 9.453125 25.734375 9.875 25.585938 10.246094 C 25.429688 10.617188 25.066406 10.855469 24.671875 10.855469 L 20.707031 10.855469 C 20.175781 27.152344 6.519531 27.632813 4.933594 27.632813 C 4.386719 27.632813 3.949219 27.1875 3.949219 26.644531 C 3.949219 26.101563 4.386719 25.65625 4.933594 25.65625 Z "/>
												</g>
											</svg>
										</td>
										<td><strong style="font-size: 17px;color:#F64E60">Retrait</strong></td>
										<td>
											<strong><?= getEmploye($item->id_employe)->noms_prenoms ?></strong> <br>
											<em><?= getEmploye($item->id_employe)->matricule ?></em>
										</td>
										<td>
											<strong style="font-size: 17px">{{floor($item->montant)}} FCFA</strong>
										</td>
										<td> 
											<span style="font-size: 16px">{{$item->created_at->format('d M Y')}}</span><br>
											<em>(le {{$item->created_at->format('d/m/Y \a H\hi ')}})</em>
										</td>
										<td></td>
									</tr>
								@endif
							@endforeach
							
						</tbody>
					</table>
				@endempty
				
			</div>
		</div>	
	</div>


@endsection

@section('scripts')
	<script>
		window.onload = () => {
			let inputSearch = document.querySelector(".inputSearch")
			let form = document.querySelector("#form")
			let form2 = document.querySelector(".form2")
			let result = document.querySelector(".result")

			let employerId = false

			document.querySelector('.btn_ref_form2').addEventListener('click',e=>{
				
				let dateDebut = document.querySelector('input[name="debut"]')
				let dateFin = document.querySelector('input[name="fin"]')
				
				if(employerId || (dateDebut.value !== "" || dateFin.value !== "")){
					// on verifie si les dates sont logiques
					if(dateDebut.value !== "" && dateFin.value !== ""){
						dateDebut 	= new Date(dateDebut.value)
						dateFin   	= new Date(dateFin.value)
						if(dateDebut > dateFin){
							let errorDiv = document.querySelector('.error_message')
							errorDiv.innerHTML = "<div class='alert alert-danger'>veuillez saisir une date correcte s’il vous plaît !</div>"
							let id = setTimeout(()=>{
								errorDiv.innerHTML = ''
							},10000)
						}else{
							// on envoi le formulaire si tous ok
							form2.submit()
						}
					}else{
						// on envoi le formulaire si tous ok
						form2.submit()
					}
				}else{
                    let transactionInt = document.querySelector('input[name="transactionInt"]');
                    let transactionOut = document.querySelector('input[name="transactionOut"]');
                    if(transactionOut.checked==false && transactionInt.checked==false){
                        let errorDiv = document.querySelector('.error_message')
                        errorDiv.innerHTML = "<div class='alert alert-danger'>vous devez sélectionnez un employé ou une date avant de soumettre le formulaire</div>"
                        let id = setTimeout(()=>{
                            errorDiv.innerHTML = ''
                        },10000)
                    }else{
                        // on envoi le formulaire si tous ok
						form2.submit()
                    }
				}
			})

			result.addEventListener('mouseenter', e => {
				let card = document.querySelectorAll('.result__card.select')
				let employeField = document.querySelector('.employe')
				if(card.length > 0){
					Array.from(card).forEach(elem=>elem.addEventListener('click',e=>{
						let data = e.currentTarget
						result.innerHTML = ''
						inputSearch.value = ''

						employerId= data.dataset.id
						document.querySelector('.parent__employer').style.backgroundColor= "#06af1560"
						document.querySelector('.parent__employer').firstElementChild.style.color = "#fff"
						employeField.innerHTML = `${data.querySelector('.result__name').innerHTML} <em>(${data.querySelector('.result__matricule').innerHTML})</em>`
						
						if(form2.querySelector('.newImput')){
							form2.removeChild(form2.querySelector('.newImput'))
						}

						let newInput = document.createElement('input')
						newInput.classList.add('newImput')
						newInput.setAttribute('type','hidden')
						newInput.setAttribute('value',employerId)
						newInput.setAttribute('name','id_employe')
						form2.insertBefore(newInput,form2.firstElementChild)
						
					}))
				}
			})


			inputSearch.addEventListener("keyup", (e) => {

				let xhr  = new XMLHttpRequest()
				let data = new FormData(form)
				xhr.open('POST',"/employe/search/all",true)
				xhr.setRequestHeader('x-csrf-token',"<?= $token ?>")
				xhr.send(data)
				xhr.onreadystatechange = ()=>{
					if(xhr.readyState === xhr.DONE){
						if(xhr.status === 200){
							if(xhr.responseText == ""){
								result.innerHTML = ""
							}else{
								let employes = JSON.parse(xhr.responseText).usersSearch
								if(employes.length > 0){
									result.innerHTML = ""
									employes.forEach(element => {

										result.innerHTML += `
											<div class="result__card select" data-id="${element.id}">
												<div class="result__name">${element.noms_prenoms}</div>
												<div class="result__matricule">${element.matricule}</div>
											</div>
										`
									});
								}else if(employes.length === 0){
									result.innerHTML = ""
									result.innerHTML += `
										<div class="result__card noting">
											<div class="result_noting">Aucun Employé trouvé</div>
										</div>
									`
								}
							}
						}else{
							console.log(xhr.status)
						}
					}
				}
			});
		};
	</script>

	<script src="{{ asset('js/transaction.js') }}"></script>
@endsection
