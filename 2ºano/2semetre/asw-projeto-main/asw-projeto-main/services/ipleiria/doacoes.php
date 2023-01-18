<?php
$instId = $_GET["iid"];
if (!isset($instId)) {
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

	<div class="px-4 pt-5 my-5 text-center border-bottom">
		<div id="inject-instituicao">
			<div class="loading-skeleton">
				<h1 class="display-4 fw-bold">Nome Instituição</h1>
				<div class="col-lg-6 mx-auto">
					<p class="lead mb-4">Descrição Instituição</p>

					<div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-5">
						<a href="#doacoes" type="button" class="btn btn-primary btn-lg px-4 me-sm-3">Doações</a>
						<a href="/" type="button" class="btn btn-outline-secondary btn-lg px-4">ReFood FCUL</a>
					</div>
				</div>
				<div class="overflow-hidden" style="max-height: 30vh;">
					<div class="container px-5">
						<img src="/assets/img/refood_fcul.png" class="img-fluid border rounded-3 shadow-lg mb-4" alt="ReFood FCUL" width="700" height="500" loading="lazy">
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div id="inject-doacoes">
			<div class="row align-center gy-1 loading-skeleton">
				<!-- SKELETON DOACOES -->
				<div class="col-12 col-sm-6 col-lg-4 col-xl-3">
					<div class="card" style="width:100%;">
						<div class="card-body">
							<h5 class="card-title">Dia Doação</h5>
							<p class="card-text">Doa <strong>quantidade alimento</strong> (tipo alimento)</p>
						</div>
					</div>
				</div>
				<div class="col-12 col-sm-6 col-lg-4 col-xl-3">
					<div class="card" style="width:100%;">
						<div class="card-body">
							<h5 class="card-title">Dia Doação</h5>
							<p class="card-text">Doa <strong>quantidade alimento</strong> (tipo alimento)</p>
						</div>
					</div>
				</div>
				<div class="col-12 col-sm-6 col-lg-4 col-xl-3">
					<div class="card" style="width:100%;">
						<div class="card-body">
							<h5 class="card-title">Dia Doação</h5>
							<p class="card-text">Doa <strong>quantidade alimento</strong> (tipo alimento)</p>
						</div>
					</div>
				</div>
				<div class="col-12 col-sm-6 col-lg-4 col-xl-3">
					<div class="card" style="width:100%;">
						<div class="card-body">
							<h5 class="card-title">Dia Doação</h5>
							<p class="card-text">Doa <strong>quantidade alimento</strong> (tipo alimento)</p>
						</div>
					</div>
				</div>
			</div>
			<!-- END SKELETON DOACOES -->
		</div>
	</div>

	<script>
		const params = new Proxy(new URLSearchParams(window.location.search), {
			get: (searchParams, prop) => searchParams.get(prop),
		});

		function injectDoacoes(html) {
			$("#inject-doacoes").html(html);
		}

		function injectInstituicao(html) {
			$("#inject-instituicao").html(html);
		}

		function showErrInstituicao(err) {
			injectInstituicao(`<div class='alert alert-warning' role='alert'>${err} :(</div>`)
		}

		function showErrDoacoes(err) {
			injectDoacoes(`<div class='alert alert-warning' role='alert'>${err} :(</div>`)
		}

		function showInstituicao(instituicao, doacoes, query) {
			if (!instituicao.id) {
				showErrInstituicao(`Nenhuma instituição encontrada${query ? ` com o id "${query}"` : ''}`);
				injectDoacoes('');
				return;
			}

			const instituicaoHtml = `
			<h1 class="display-4 fw-bold" style="position:relative">
				${instituicao.nome}
				<span class="badge bg-primary" style="font-size:1rem;position:absolute;bottom:0;margin-bottom:1rem;margin-left:.5rem;">${instituicao.tipo}</span>
			</h1>

			<div class="col-lg-6 mx-auto">
				<p class="lead mb-4">${instituicao.descricao}</p>

				<div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-5">
					<a href="#doacoes" type="button" class="btn btn-primary btn-lg px-4 me-sm-3">Doações</button>
					<a href="/" type="button" class="btn btn-outline-secondary btn-lg px-4">ReFood FCUL</a>
				</div>
			</div>
			<div class="overflow-hidden" style="max-height: 30vh;">
				<div class="container px-5">
					<img src="data:image/jpeg;base64,${instituicao.foto}" class="img-fluid border rounded-3 shadow-lg mb-4" alt="ReFood FCUL" width="700" height="500" loading="lazy">
				</div>
			</div>`;
			injectInstituicao(instituicaoHtml);

			if (!doacoes?.length) return showErrDoacoes(`Sem horários de doações`);
			const mapped = doacoes.map((doacao) => (
				`<div class="col-12 col-sm-6 col-lg-4 col-xl-3">
					<div class="card" style="width:100%;">
						<div class="card-body">
							<h5 class="card-title">${doacao.dia_semana}</h5>
							<p class="card-text">Doa <strong>${doacao.quantidade_expectada} ${doacao.nome_alimento}</strong> (${doacao.tipo_doacao})</p>
							${true ? `<a href="/services/ipleiria/recolher.php?iid=${instituicao.id}&dia=${doacao.dia_semana}&alimento=${doacao.nome_alimento}" type="button" class="btn btn-primary btn-lg px-4 me-sm-3">Recolher</a>` : ''}
						</div>
					</div>
				</div>`
			))

			injectDoacoes(`<div class="row align-center gy-1">${mapped.join('')}</div>`);
		}

		function getInstituicao() {
			const id = params.iid;

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

		getInstituicao();
	</script>
</body>

</html>