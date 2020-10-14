<?php use xPaw\SourceQuery\SourceQuery; ?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
		<meta name="generator" content="Jekyll v4.1.1">
		<title>Starter Template · Bootstrap</title>
		<link rel="icon" type="image/png" href="/favicon.ico">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

		<style>
			.bd-placeholder-img {
				font-size: 1.125rem;
				text-anchor: middle;
				-webkit-user-select: none;
				-moz-user-select: none;
				-ms-user-select: none;
				user-select: none;
			}

			@media (min-width: 768px) {
				.bd-placeholder-img-lg {
					font-size: 3.5rem;
				}
			}

			/* body {
				padding-top: 5rem;
			} */

			.starter-template {
				padding: 3rem 1.5rem;
				/* text-align: center; */
			}

			.themed-grid-col {
				padding-top: 15px;
				padding-bottom: 15px;
				background-color: rgba(86, 61, 124, .15);
				border: 1px solid rgba(86, 61, 124, .2);
			}
		</style>
	</head>
	<body>

		<main role="main" class="container">
			<div class="starter-template">
				<!--<h1>Bootstrap starter template</h1>-->
				<!--<p class="lead">Use this document as a way to quickly start any new project.<br> All you get is this text and a mostly barebones HTML document.</p>-->
				<div class="card mb-3">
					<div class="card-body">
						<h5 class="card-title">MercadoPago</h5>
						<!--<p class="card-text">Tu cuenta de Discord no está conectada con la página web.</p>-->
						<!--<a href="/discord/conectar" class="btn btn-success">Conectar Discord</a>-->
						<!--<form action="/procesar-pago" method="POST">
							<script
								src="https://www.mercadopago.com.ar/integrations/v1/web-payment-checkout.js"
								data-preference-id="$preference->id;">
							</script>
						</form>-->
						<!--
						<a href="$preference->init_point;">Pagar con Mercado Pago</a>
						-->
						<a href="/mercadopago/comprar/1">Pagar con Mercado Pago</a>
					</div>
				</div>
			</div>
		</main><!-- /.container -->

		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
		<script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
	</body>
</html>
