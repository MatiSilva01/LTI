<?php

require_once __DIR__ . '/../i18n/index.php';
require_once __DIR__ . '/../volunteer/volunteer.php';

$volId = $_GET["vid"];
if (!isset($volId)) {
	header("Location: /user/area.php");
	exit;
}

$vol = Voluntario::getOne($volId);
if (!isset($vol)) {
	header("Location: /user/area.php");
	exit;
}

session_start();
require_once __DIR__ . '/../institution/institution.php';
require_once __DIR__ . '/../volunteer/avaliacao.php';


$user = unserialize($_SESSION["user"]);
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php require_once __DIR__ . '/../components/head.php'; ?>

	<script src="/assets/js/lib/rater.min.js"></script>
	<style>
		html {
			scroll-behavior: smooth;
		}

		.rate-base-layer {
			color: #aaa;
		}

		.rate-hover-layer,
		.rate-select-layer {
			color: orange;
		}

		.bg-blur::before {
			content: "";
			position: absolute;
			left: -5%;
			top: -5%;
			right: 0;
			z-index: -1;

			display: block;
			background-image: url('data:image/jpeg;base64,<?= "$vol->foto"; ?>');
			background-size: cover;
			background-repeat: no-repeat;
			width: 110%;
			height: 50vh;

			-webkit-filter: blur(15px) brightness(.6);
			-moz-filter: blur(15px) brightness(.6);
			-o-filter: blur(15px) brightness(.6);
			-ms-filter: blur(15px) brightness(.6);
			filter: blur(15px) brightness(.6);
		}
	</style>
</head>

<body>
	<!-- Navigation-->
	<?php include '../components/navbar.php' ?>

	<div class="px-4 mb-5 text-center border-bottom bg-blur">
		<div class="pt-5 mt-5 text-light">
			<h1 class="display-4 fw-bold"><?= $vol->nome ?></h1>
			<div class="col-lg-6 mx-auto">
				<p class="lead mb-4"><?= $vol->descricao ?></p>
			</div>
			<div class="overflow-hidden" style="max-height: 30vh;">
				<div class="container px-5">
					<img src="data:image/jpeg;base64,<?= $vol->foto ?>" class="img-fluid border rounded-3 shadow-lg mb-4" alt="ReFood FCUL" width="700" height="500" loading="lazy">
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row align-content-center">
			<div class="col-md-6 col-lg-4 mb-5">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title text-capitalize"><?= _("avaliações") ?></h4>
						<?php $avaliacaoGeral = AvaliacaoVoluntario::getStatsVoluntario($volId); ?>

						<div class="card-text">
							<?php
							if ($avaliacaoGeral['total'] == 0) {
								echo "<p class='text-muted'>" . _("Sem avaliações") . "</p>";
							} else {

								$avg = round($avaliacaoGeral['media'] / 2, 2);
								echo "<div class='rating' data-rate-value=$avg></div>
									$avg " . _("em 5");
								echo "<p class='text-muted'>" . $avaliacaoGeral['total'] . " " . _("avaliações") . "</p>";
							}
							?>
						</div>
					</div>
				</div>

				<div class="card mt-2">
					<div class="card-body">
						<h5 class="card-title"><?= _("Faça uma avaliação") ?></h5>
						<?php
						if (!$user) {
							echo "<h6 class='card-subtitle mb-2 text-muted'>" . _("Autentique-se para avaliar") . "</h6>";
						} else if (!($user instanceof Instituicao)) {
							echo "<h6 class='card-subtitle mb-2 text-muted'>" . _("Apenas instituições podem avaliar voluntários") . "</h6>";
						} else {
							$avaliacao = AvaliacaoVoluntario::getOne($user->id, $volId);

							echo "<form id='formComentario'>
								    <div class='card-text'>
									  <div class='row'>
									    <div class='col-3'>
										<label for='comentario' class='form-label'>" . _("Avaliação") . "</label>
									      <div id='avaliacaoUser'";
							if ($avaliacao->avaliacao) {
								echo "data-rate-value=" . round($avaliacao->avaliacao / 2, 2);
							}
							echo ">
										  </div>
										  <span id='avaliacaoObrigatoria' class='text-danger'>" . _("Avaliação obrigatória") . "</span>
										</div>
										<div class='col-9'>
		  								  <label for='comentario' class='form-label'>Comentário</label>
								          <input type='text' class='form-control' id='comentario' value='$avaliacao->comentario'>
							            </div>
									  </div>

									  <input type='submit' class='btn btn-primary mt-2' value='" . _("Salvar") . "'>
									</div>
								</form>";
						}
						?>
					</div>
				</div>
			</div>

			<?php

			$avaliacoes = AvaliacaoVoluntario::getAllVoluntario($volId);

			foreach ($avaliacoes as $avaliacao) {
				$vol = Instituicao::getOne($avaliacao->id_instituicao);
				$date = gmdate("d-m-Y \à\s H:i", $avaliacao->created_at);
				$rating = round($avaliacao->avaliacao / 2, 2);

				echo "<div class='col-md-6 col-lg-3'>
						<div class='d-flex align-items-center'>
							<div class='avatar px-2'>
								<img src='data:image/jpeg;base64,$vol->foto' style='height:48px' class='rounded-circle' alt='$vol->nome'>
							</div>
							<span>$vol->nome</span>
						</div>

						<p class='text-muted' style='font-size:.8rem;'>$date</p>
						
						<div class='rating' data-rate-value=$rating></div>
						<p>$avaliacao->comentario</p>
				</div>";
			}
			?>
		</div>
	</div>

	<script>
		const params = new Proxy(new URLSearchParams(window.location.search), {
			get: (searchParams, prop) => searchParams.get(prop),
		});

		const ratingOptions = {
			max_value: 5,
			step_size: 0.5
		}

		const $elRatingMessage = $('#avaliacaoObrigatoria');
		$elRatingMessage.hide();

		const $elRatingUser = $('#avaliacaoUser');
		const $elComentario = $('#comentario');


		$('.rating').rate({
			...ratingOptions,
			readonly: true
		});

		if ($elRatingUser)
			$elRatingUser.rate(ratingOptions);

		<?php
		if ($user) {
			echo '$("#formComentario").submit(($e) => {
				$e.preventDefault();

				const avaliacao = $elRatingUser.rate("getValue") * 2;

				if (!avaliacao)
					$elRatingMessage.show();
				else {
					$.ajax({
						url: "/volunteer/submit-avaliacao.php",
						method: "post",
						data: {
							instId: ' . $user->id . ',
							volId: params.vid,
							comentario: $elComentario.val(),
							avaliacao,
						},
						success: () => location.reload(),
						error: () => location.reload()
					})


					$elRatingMessage.hide();
				}
			});';
		}
		?>
	</script>
</body>

</html>