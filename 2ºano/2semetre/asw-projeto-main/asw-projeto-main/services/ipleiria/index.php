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
		<h1 class="display-4 fw-bold">ReFood FCUL + IPLeiria</h1>
		<div class="col-lg-6 mx-auto">
			<p class="lead mb-4">
				Decidimos criar a parceria ReFood FCUL porque eles são bué fixes!!! são <strong>um máximo</strong>!!! Na ReFood IPLeiria não temos instituições (porque somos de leiria, e leiria factualmente não existe...), então bora lá buscá-las aos nossos amigos lisboetas
			</p>

			<div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-5">
				<a href="#instituicoes" type="button" class="btn btn-primary btn-lg px-4 me-sm-3">Instituições</button>
					<a href="/" type="button" class="btn btn-outline-secondary btn-lg px-4">ReFood FCUL</a>
			</div>
		</div>
		<div class="overflow-hidden" style="max-height: 30vh;">
			<div class="container px-5">
				<img src="/assets/img/refood_fcul.png" class="img-fluid border rounded-3 shadow-lg mb-4" alt="ReFood FCUL" width="700" height="500" loading="lazy">
			</div>
		</div>
	</div>

	<div class="container">
		<div id="instituicoes" class="row align-content-center">
			<div class="col-md-5 col-lg-3">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Procurar Instituições</h5>
						<h6 class="card-subtitle mb-2 text-muted">Filtre por nome</h6>

						<form>
							<input type="email" class="form-control" id="nomeSearch" placeholder="McDonalds" onkeyup="getInstituicoes()">
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-7 col-lg-9 mb-4">
				<div id="inject-instituicoes"></div>
			</div>
		</div>
	</div>

	<script>
		function inject(html) {
			$("#inject-instituicoes").html(html);
		}

		function showErr(err) {
			inject(`<div class='alert alert-warning' role='alert'>${err} :(</div>`)
		}

		function showInstituicoes(instituicoes, query) {
			if (!instituicoes) return showErr(`Nenhuma instituição encontrada${query ? ` com o nome "${query}"` : ''}`);

			const mapped = instituicoes.map((instit) => (
				`<div class="col-12 col-sm-6 col-lg-4 col-xl-3">
					<div class="card" style="width:100%;">
						<img src="data:image/jpeg;base64,${instit.foto}" class="card-img-top" alt="...">
						<div class="card-body">
							<h5 class="card-title">${instit.nome}</h5>
							<p class="card-text">${instit.descricao}</p>
							<a href="/services/ipleiria/doacoes.php?iid=${instit.id}" class="btn btn-primary">Doações</a>
						</div>
					</div>
				</div>`
			))

			inject(`<div class="row align-content-center">${mapped.join('')}</div>`);
		}

		function getInstituicoes() {
			const nome = $('#nomeSearch').val();

			$.soap({
				url: '/services/ws/instituicoes.php/',
				method: 'getInstituicoes',
				data: {
					nome
				},
				success: function(data) {
					const json = data.toJSON()?.Body?.getInstituicoesResponse?.return?.item;
					const arr = json ? Array.isArray(json) ? json : [json] : null;

					showInstituicoes(arr, nome);
				},
				error: function(error) {
					showErr(`Erro: ${error}`)
				}
			})
		}

		getInstituicoes();
	</script>
</body>

</html>