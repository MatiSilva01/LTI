<?php
$instId = $_GET["iid"];
if (!isset($instId)) {
	header("Location: /services/ipleiria");
	exit;
}

$dia = $_GET["dia"];
if (!isset($dia)) {
	header("Location: /services/ipleiria");
	exit;
}

$alimento = $_GET["alimento"];
if (!isset($alimento)) {
	header("Location: /services/ipleiria");
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<meta name="description" content="ReFood FCUL" />
	<meta name="author" content="LTI ASW G21 2022" />

	<title>ReFood IPLeiria</title>
	<link rel="icon" type="image/x-icon" href="/assets/img/logo_ipleiria_small.png" />

	<link href="/assets/css/lib/bootstrap.min.css" rel="stylesheet" />

	<script src="/assets/js/lib/fontawesome.5.15.all.min.js" crossorigin="anonymous"></script>

	<!-- Google fonts-->
	<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" />
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

	<!-- Core theme CSS-->
	<script src="/assets/js/lib/jquery.min.js"></script>
	<script src="/assets/js/lib/jquery.soap.js"></script>
	<script src="/assets/js/lib/jquery.xml2json.js"></script>
	<script src="/assets/js/lib/jquery.validate.min.js"></script>
	<script src="/assets/js/lib/bootstrap.min.js"></script>

	<style>
		html {
			scroll-behavior: smooth;
		}

		.loading-skeleton h1,
		.loading-skeleton h2,
		.loading-skeleton h3,
		.loading-skeleton h4,
		.loading-skeleton h5,
		.loading-skeleton h6,
		.loading-skeleton p,
		.loading-skeleton li,
		.loading-skeleton .btn,
		.loading-skeleton label,
		.loading-skeleton .form-control {
			color: transparent;
			appearance: none;
			-webkit-appearance: none;
			background-color: #eee;
			border-color: #eee;
		}

		.loading-skeleton h1::placeholder,
		.loading-skeleton h2::placeholder,
		.loading-skeleton h3::placeholder,
		.loading-skeleton h4::placeholder,
		.loading-skeleton h5::placeholder,
		.loading-skeleton h6::placeholder,
		.loading-skeleton p::placeholder,
		.loading-skeleton li::placeholder,
		.loading-skeleton .btn::placeholder,
		.loading-skeleton label::placeholder,
		.loading-skeleton .form-control::placeholder {
			color: transparent;
		}

		@keyframes loading-skeleton {
			from {
				opacity: 0.4;
			}

			to {
				opacity: 1;
			}
		}

		.loading-skeleton {
			pointer-events: none;
			animation: loading-skeleton 1s infinite alternate;
		}

		.loading-skeleton img {
			filter: grayscale(100) contrast(0%) brightness(1.8);
		}
	</style>
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container-fluid">
			<a class="navbar-brand" href="/services/ipleiria">
				<img src="/assets/img/logo_ipleiria_small.png" alt="" width="30" height="30" class="d-inline-block align-text-top">
				ReFood IPLeiria
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="nav-link active" aria-current="page" href="/services/ipleiria">Início</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container py-5">
		<div id="instituicoes" class="row align-content-center">
			<div class="col-12 col-md-6" id="inject-instituicao">
				<div class="card loading-skeleton" style="width:100%;">
					<img src="/assets/img/logo.png" style="height:20rem;object-fit:cover;" class="card-img-top" alt="...">
					<div class="card-body">
						<h5 class="card-title">Nome Instituição</h5>
						<p class="card-text">Descrição Instituição</p>
						<a href="/services/ipleiria/doacoes.php?iid=idInstituicao" class="btn btn-primary">Doações</a>

						<hr />

						<div id="inject-doacoes">
							<h6>Dia Doação</h6>
							<p>quantidade alimento (tipo)</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-6">
				<div class="card" style="width:100%;">
					<div class="card-body">
						<h5>Autentique-se para recolher esta doação</h5>

						<form id="formlogin">
							<div class="mb-3">
								<label for="login" class="form-label">Nome ou Email</label>
								<input required type="text" class="form-control" name="login" id="login" placeholder="Lucas" onkeyup="disableBtnSubmit()">
							</div>

							<div class="mb-3">
								<label for="passwd" class="form-label">Senha</label>
								<input required type="password" class="form-control" name="passwd" id="passwd" placeholder="paocommolhos413" onkeyup="disableBtnSubmit()">
							</div>

							<input id="btnSubmitPedido" type="submit" class="btn btn-primary"></input>
						</form>

						<!-- warning div -->
						<div id="inject-recolha">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		const params = new Proxy(new URLSearchParams(window.location.search), {
			get: (searchParams, prop) => searchParams.get(prop),
		});

		const id = params.iid;
		const dia = params.dia;
		const alimento = params.alimento;

		const $login = $('#login');
		const $password = $('#passwd');
		const $btnSubmit = $('#btnSubmitPedido');

		function injectDoacoes(html) {
			$("#inject-doacoes").html(html);
		}

		function injectInstituicao(html) {
			$("#inject-instituicao").html(html);
		}

		function injectRecolha(html) {
			$("#inject-recolha").html(html);
		}

		function showErrInstituicao(err) {
			injectInstituicao(`<div class='alert alert-warning' role='alert'>${err} :(</div>`)
		}

		function showErrDoacoes(err) {
			injectDoacoes(`<div class='alert alert-warning' role='alert'>${err} :(</div>`)
		}

		function showErrRecolha(err) {
			injectRecolha(`<div class='alert alert-warning mt-2' role='alert'>${err} :(</div>`)
		}

		function showInstituicao(instituicao, doacoes, query) {
			if (!instituicao.id) return showErrInstituicao(`Nenhuma instituição encontrada${query ? ` com o id "${query}"` : ''}`);

			const instituicaoHtml = `<div class="card" style="width:100%;">
					<img src="data:image/jpeg;base64,${instituicao.foto}" style="height:20rem;object-fit:cover;" class="card-img-top" alt="...">
					<div class="card-body">
						<h5 class="card-title">${instituicao.nome}</h5>
						<p class="card-text">${instituicao.descricao}</p>
						<a href="/services/ipleiria/doacoes.php?iid=${instituicao.id}" class="btn btn-primary">Doações</a>

						<hr />

						<div id="inject-doacoes"></div>
					</div>
				</div>`;
			injectInstituicao(instituicaoHtml);

			const doacao = doacoes?.find(d => d.dia_semana == dia && d.nome_alimento == alimento);
			if (!doacao) return history.length > 2 ? history.back() : location.href = '/services/ipleiria';

			injectDoacoes(`<h6>${doacao.dia_semana}</h6>
				<p>Doa <strong>${doacao.quantidade_expectada} ${doacao.nome_alimento}</strong> (${doacao.tipo_doacao})</p>`);
		}

		function getInstituicao() {
			$.soap({
				url: '/services/ws/instituicoes.php/',
				method: 'getInfoInstDoacoes',
				data: {
					id
				},
				success: function(data) {
					const json = data.toJSON()?.Body?.getInfoInstDoacoesResponse?.return;
					const donations = json?.donations?.item ? Array.isArray(json.donations?.item) ? json.donations?.item : [json.donations?.item] : null;
					showInstituicao(json.institution, donations, id);
				},
				error: function(error) {
					showErrInstituicao(`Erro: ${error}`);
				}
			})
		}

		let blockSubmit = false;
		let isSubmitBtnDisabled = false;

		function disableBtnSubmit() {
			if (blockSubmit) return;

			isSubmitBtnDisabled = false;
			$btnSubmit.prop('disabled', isSubmitBtnDisabled);
		}

		function submetePedidoRecolha(login, password) {
			$.soap({
				url: '/services/ws/voluntarios.php/',
				method: 'pedeRecolhaDoacao',
				data: {
					login,
					password,
					idInstit: id,
					diaSemana: dia,
					nomeAlimento: alimento,
				},
				success: function(data) {
					const json = data.toJSON()?.Body?.pedeRecolhaDoacaoResponse?.return;
					injectRecolha(`<div class='alert alert-success mt-2' role='alert'>${json} :)</div>`);

					blockSubmit = true;
					isSubmitBtnDisabled = true;
				},
				error: function(error) {
					console.log(error)
					showErrRecolha(`Erro: ${error}`);
				}
			})
		}

		$('#formlogin').submit(($e) => {
			$btnSubmit.prop('disabled', true);
			submetePedidoRecolha($login.val(), $password.val());

			$e.preventDefault();
		})

		getInstituicao();
	</script>
</body>

</html>