			<!-- Deluxe Menu -->
			<!-- Code for Deluxe Menu Items. Generated by Deluxe Tuner -->
			<ul id="blueMenu">

<?php
	if ($_SESSION['permisos']['parametros'] == '1'){
?>
				<li class="istylei0"><a href="seguridad.php">Seguridad</a>
				</li>

<?php 
	}
	if ($_SESSION['permisos']['tratamientos'] == '1'){
?>
				<li class="istylei0"><a href="#"><span>Supervisi&oacute;n</span></a>
				<ul>
					<li><a href="enfermedadesABM.php">ABM Enfermedades</a></li>
					<li><a href="licenciasGlobales.php">Actualizaci&oacute;n licencias acumuladas</a></li>
					<li class="istylei1"><a href="#">&nbsp;</a></li>
				</ul>
				</li>

				<li class="istylei0"><a href="#"><span>Tratamientos</span></a>
				<ul>
					<li><a href="maestroTratamientos.php">Maestro tratamientos</a></li>
					<li><a href="altasCercanas.php">Pr&oacute;ximas altas</a></li>
					<li><a href="maestroTratamientosAlta.php">Nuevo tratamiento</a></li>
					<li class="istylei1"><a href="#">&nbsp;</a></li>
				</ul>
				</li>
				
<?php 	
	}
	if ($_SESSION['permisos']['listados'] == '1'){
?>
				<li class="istylei0"><a href="generadorListados.php">Generador de listados</a></li>
				<li class="istylei0"><a href="#"><span>Otros listados</span></a>
				<ul>
					<li><a href="listados.php">Licencias acumuladas</a></li>
					<li><a href="licenciasVencimiento.php">Vencimientos</a></li>
					<li><a href="testlink.html"><span><b>Estad&iacute;sticas</b></span></a>
					<ul>
						<li><a href="estadisticaDiasPorLicencia.php">Detalle estad&iacute;stico por per&iacute;odo</a></li>
						<li><a href="estadisticaEnfermedadesPorLicencia.php">Ranking de enfermedades por licencia</a></li>
						<li><a href="estadisticaRankingEmpleados.php">Ranking de empleados</a></li>
						<li><a href="estadisticaLicenciasPorA&ntilde;o.php">Licencias por a&ntilde;o</a></li>
					</ul>
					</li>
					<li class="istylei1"><a href="#">&nbsp;</a></li>
				</ul>
				</li>
<?php
	}
?>		
			
			<li class="istylei0"><a href="logout.php">Salir del sistema</a></li>
			</ul>
			<!-- End of Code for Deluxe Menu Items -->
			<!-- (c) 2009, Deluxe-Menu.com -->
			<script type="text/javascript" src="blue-menu.files/data.js"></script>
	