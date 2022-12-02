<?php echo $cabecera ?>
<?php

$session = session();
if($session->get("usuario")==''){ ?>
	<script type="text/javascript">
		window.location.href = "index";
	</script>
	<?php exit;
}
?>
<div class="container">
	<div class="row">
		<div class="col-12 mt-3 mb-3" style="text-align: right;">
			<a href="<?php echo base_url('index'); ?>">
				<button type="button" class="btn btn-danger">Cerrar Sesión</button>
			</a>
		</div>
		<div class="col-12 mt-3 mb-3">
			<table class="table table-bordered">
	            <thead>
	            <tr>
					<th class="text-center">Acción</th>
					<th class="text-center">Usuario</th>
					<th class="text-center">Fecha Creación</th>
	            </tr>
	            </thead>
	            <tbody>
	            	<?php
	            	if($proceso1>=1){
		            	foreach($proceso1 as $logs){
		            		echo '
		            			<tr>
									<td class="text-center">'.$logs["logs_accion"].'</td>
									<td class="text-center">'.$logs["usuarios_usuario"].'</td>
									<td class="text-center">'.$logs["logs_fecha_creacion"].'</td>
								</tr>
		            		';
		            	}
	            	}
	            	?>
		</div>
	</div>
</div>

</body>
</html>
<?php $ubicacion_url = $_SERVER["PHP_SELF"]; ?>
<?php echo $footer ?>

<script type="text/javascript">
	$(document).ready(function() {} );
</script>