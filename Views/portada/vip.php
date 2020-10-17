				<div class="card mb-3">
					<div class="card-body">
						<h5 class="card-title">VIP</h5>
						<p class="card-text">Si disfrutás de los servidores, por favor ¡considerá hacer una colaboración! Como agradecimiento, obtendrás los beneficios listados a continuación.</p>
						<ul>
							<li><b>Comandos !ws, !knife.</b> Todos los skins de CS:GO estarán a tu disposición.</li>
							<li><b>Comando !extend.</b> Extiende un mapa durante un máximo de 20 minutos. Una sola vez por mapa para cada jugador, y cinco veces por mapa para todos los jugadores VIP.</li>
							<li><b>Bind +noclip.</b> Posibilidad de volar por el mapa en los servidores KZTimer.</li>
							<li><b>Slot reservado.</b> Acceso a los servidores aunque estén llenos, siempre y cuando no estén ocupados los slots reservados.</li>
							<li><b>Etiqueta exclusiva.</b> Etiqueta exclusiva en el nombre en los servidores KZTimer.</li>
							<li><b>Rol en Discord.</b> Se te asignará un rol especial y desbloquearás una categoría de canales exclusiva para usuarios VIP.</li>
						</ul>
						<p class="card-text">Una vez abonado el pago, el VIP se activará automáticamente, tanto en los servidores de CS:GO como en Discord. Si estás conectado en un servidor de CS:GO, es posible que debas reconectar o esperar que cambie el mapa.</p>
						<div class="card-deck mb-1 text-center">
							<div class="card shadow-sm bg-light text-dark">
								<div class="card-header">
									<h4 class="my-0 font-weight-normal">VIP 1 mes</h4>
								</div>
								<div class="card-body">
									<h1 class="card-title pricing-card-title">$100</h1>
									<a class="btn btn-lg btn-block btn-primary" <?=$estaConectado ? "href=\"/mercadopago/comprar/1\"" : "onclick=\"btnComprarVip()\""?>>Comprar</a>
								</div>
							</div>
							<div class="card shadow-sm bg-light text-dark">
								<div class="card-header">
									<h4 class="my-0 font-weight-normal">VIP 3 meses</h4>
								</div>
								<div class="card-body">
									<h1 class="card-title pricing-card-title">$275</h1>
									<a class="btn btn-lg btn-block btn-primary" <?=$estaConectado ? "href=\"/mercadopago/comprar/2\"" : "onclick=\"btnComprarVip()\""?>>Comprar</a>
								</div>
							</div>
							<div class="card shadow-sm bg-light text-dark">
								<div class="card-header">
									<h4 class="my-0 font-weight-normal">VIP 6 meses</h4>
								</div>
								<div class="card-body">
									<h1 class="card-title pricing-card-title">$500</h1>
									<a class="btn btn-lg btn-block btn-primary" <?=$estaConectado ? "href=\"/mercadopago/comprar/3\"" : "onclick=\"btnComprarVip()\""?>>Comprar</a>
								</div>
							</div>
						</div>
					</div>
				</div>
