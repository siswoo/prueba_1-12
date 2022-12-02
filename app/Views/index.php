<?php echo $cabecera ?>
<div class="container">
	<form id="formulario1" method="POST" action="#">
		<div class="row">
			<div class="col-12 mt-3 mb-3 text-center" style="font-size: 20px; font-weight: bold;">Ingrese Datos de Acceso</div>
			<div class="col-12 mt-3 mb-3">
				<label for="usuario">Usuario</label>
				<input type="text" class="form-control" name="usuario" id="usuario" autocomplete="off" required>
			</div>
			<div class="col-12 mt-3 mb-3">
				<label for="clave">Clave</label>
				<input type="password" class="form-control" name="clave" id="clave" required>
			</div>
			<div class="col-12 text-center">
				<button type="submit" class="btn btn-primary">Ingresar</button>
			</div>
		</div>
	</form>
</div>

</body>
</html>
<?php $ubicacion_url = $_SERVER["PHP_SELF"]; ?>
<?php echo $footer ?>

<script type="text/javascript">
	$(document).ready(function() {});
	
	$("#formulario1").on("submit", function(e){
		e.preventDefault();
		var usuario = $('#usuario').val();
		var clave = $('#clave').val();
		$.ajax({
			type: 'POST',
			url: 'login',
			dataType: "JSON",
			data: {
				'usuario': usuario,
				'clave': clave,
			},

			success: function(respuesta) {
				console.log(respuesta);
				if(respuesta["estatus"]=='ok'){
					window.location.href = "crud1";
				}else{
					Swal.fire({
						title: 'error',
						text: respuesta["msg"],
						icon: 'error',
						showConfirmButton: true,
					});
				}
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
  	});

  	function categorias(){
        $.ajax({
            type: 'POST',
            url: 'categorias_consulta',
            dataType: "JSON",
            data: {},

            success: function(respuesta) {
                //console.log(respuesta);
                $('#categoria').html(respuesta["html1"]);
                $('#categoria2').html(respuesta["html1"]);
                $('#categoria_exportar').html(respuesta["html1"]);
                $('#categoria_exportar2').html(respuesta["html1"]);
            },

            error: function(respuesta) {
                console.log(respuesta['responseText']);
            }
        });
    }

</script>