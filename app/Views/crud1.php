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
		<div class="col-6 mt-3 mb-3">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_nuevo">Crear Registro</button>
			<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_exportar1">Exportar Excel</button>
			<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_exportar2">Exportar PDF</button>
		</div>
		<div class="col-6 mt-3 mb-3" style="text-align: right;">
			<a href="<?php echo base_url('logs'); ?>" target="_blank">
				<button type="button" class="btn btn-info">Ver Logs</button>
			</a>
			<a href="<?php echo base_url('index'); ?>">
				<button type="button" class="btn btn-danger">Cerrar Sesión</button>
			</a>
		</div>

		<input type="hidden" name="datatables" id="datatables" data-pagina="1" data-consultasporpagina="10" data-filtrado="">
		<div class="col-4 form-group form-check">
			<label for="consultasporpagina" style="color:black; font-weight: bold;">Resultados por página</label>
			<select class="form-control" id="consultasporpagina" name="consultasporpagina">
				<option value="10">10</option>
				<option value="20">20</option>
				<option value="30">30</option>
				<option value="40">40</option>
				<option value="50">50</option>
				<option value="100">100</option>
			</select>
		</div>
		<div class="col-8 form-group form-check">
			<label for="buscarfiltro" style="color:black; font-weight: bold;">Busqueda</label>
			<input type="text" class="form-control" id="buscarfiltro" autocomplete="off" name="buscarfiltro">
		</div>
		
		<div class="col-12" style="background-color: white; border-radius: 1rem; padding: 20px 1px 1px 1px;" id="resultado_table1"></div>
	</div>
</div>

<!-- Modal -->
	<div class="modal fade" id="modal_nuevo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Agregar Nuevo Registro</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="formulario1">
					<div class="modal-body">
						<div class="row">
							<div class="col-12 mt-2">
								<label for="titulo" style="font-weight: bold;">Titulo</label>
								<input type="text" class="form-control" name="titulo" id="titulo" autocomplete="off" required>
							</div>
							<div class="col-12 mt-2">
								<label for="descripcion" style="font-weight: bold;">Descripción</label>
								<input type="text" class="form-control" name="descripcion" id="descripcion" autocomplete="off" required>
							</div>
							<div class="col-12 mt-2">
								<label for="categoria" style="font-weight: bold;">Categoría</label>
								<select class="form-control" name="categoria" id="categoria" required>
									<option value="">Seleccione</option>
								</select>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal" style="cursor:pointer;">Cerrar</button>
						<button type="submit" id="agregarnuevo" class="btn btn-primary" style="cursor:pointer;">Agregar nuevo</button>
					</div>
				</form>
			</div>
		</div>
	</div>

<!-- Modal Editar -->
	<div class="modal fade" id="modal_editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Editar Registro</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="formulario2">
					<div class="modal-body">
						<div class="row">
							<div class="col-12 mt-2">
								<label for="titulo2" style="font-weight: bold;">Titulo</label>
								<input type="text" class="form-control" name="titulo2" id="titulo2" autocomplete="off" required>
							</div>
							<div class="col-12 mt-2">
								<label for="descripcion2" style="font-weight: bold;">Descripción</label>
								<input type="text" class="form-control" name="descripcion2" id="descripcion2" autocomplete="off" required>
							</div>
							<div class="col-12 mt-2">
								<label for="categoria2" style="font-weight: bold;">Categoría</label>
								<select class="form-control" name="categoria2" id="categoria2" required>
									<option value="">Seleccione</option>
								</select>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal" style="cursor:pointer;">Cerrar</button>
						<button type="submit" id="agregarnuevo" class="btn btn-primary" style="cursor:pointer;">Agregar nuevo</button>
					</div>
				</form>
			</div>
		</div>
	</div>

<!-- Modal Exportar EXCEL-->
	<div class="modal fade" id="modal_exportar1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Exportar Registro</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="formulario_exportar1" action="exportar_excel" method="POST">
					<div class="modal-body">
						<div class="row">
							<div class="col-12 mt-2">
								<label for="fecha_desde_exportar" style="font-weight: bold;">Desde</label>
								<input type="date" class="form-control" name="fecha_desde_exportar" id="fecha_desde_exportar" autocomplete="off">
							</div>
							<div class="col-12 mt-2">
								<label for="fecha_hasta_exportar" style="font-weight: bold;">Hasta</label>
								<input type="date" class="form-control" name="fecha_hasta_exportar" id="fecha_hasta_exportar" autocomplete="off">
							</div>
							<div class="col-12 mt-2">
								<label for="categoria_exportar" style="font-weight: bold;">Categoría</label>
								<select class="form-control" name="categoria_exportar" id="categoria_exportar">
									<option value="">Seleccione</option>
								</select>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal" style="cursor:pointer;">Cerrar</button>
						<button type="submit" id="agregarnuevo" class="btn btn-primary" style="cursor:pointer;">Exportar</button>
					</div>
				</form>
			</div>
		</div>
	</div>

<!-- Modal Exportar PDF-->
	<div class="modal fade" id="modal_exportar2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Exportar Registro</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="formulario_exportar2" action="exportar_pdf" method="POST">
					<div class="modal-body">
						<div class="row">
							<div class="col-12 mt-2">
								<label for="fecha_desde_exportar2" style="font-weight: bold;">Desde</label>
								<input type="date" class="form-control" name="fecha_desde_exportar2" id="fecha_desde_exportar2" autocomplete="off">
							</div>
							<div class="col-12 mt-2">
								<label for="fecha_hasta_exportar2" style="font-weight: bold;">Hasta</label>
								<input type="date" class="form-control" name="fecha_hasta_exportar2" id="fecha_hasta_exportar2" autocomplete="off">
							</div>
							<div class="col-12 mt-2">
								<label for="categoria_exportar2" style="font-weight: bold;">Categoría</label>
								<select class="form-control" name="categoria_exportar2" id="categoria_exportar2">
									<option value="">Seleccione</option>
								</select>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal" style="cursor:pointer;">Cerrar</button>
						<button type="submit" id="agregarnuevo" class="btn btn-primary" style="cursor:pointer;">Exportar</button>
					</div>
				</form>
			</div>
		</div>
	</div>

<input type="hidden" id="hidden_libro" name="hidden_libro" value="">

</body>
</html>
<?php $ubicacion_url = $_SERVER["PHP_SELF"]; ?>
<?php echo $footer ?>

<script type="text/javascript">
	$(document).ready(function() {
        filtrar1();
        categorias();
        setInterval(filtrar1, 1000);
    } );

    function filtrar1(){
        var input_consultasporpagina = $('#consultasporpagina').val();
        var input_buscarfiltro = $('#buscarfiltro').val();
        
        $('#datatables').attr({'data-consultasporpagina':input_consultasporpagina})
        $('#datatables').attr({'data-filtrado':input_buscarfiltro})

        var pagina = $('#datatables').attr('data-pagina');
        var consultasporpagina = $('#datatables').attr('data-consultasporpagina');
        var filtrado = $('#datatables').attr('data-filtrado');
        var ubicacion_url = '<?php echo $ubicacion_url; ?>';

        $.ajax({
            type: 'POST',
            url: 'libros_consulta',
            dataType: "JSON",
            data: {
                "pagina": pagina,
                "consultasporpagina": consultasporpagina,
                "filtrado": filtrado,
                "link1": ubicacion_url,
            },

            success: function(respuesta) {
                //console.log(respuesta);

                if(respuesta["estatus"]=="ok"){
                    $('#resultado_table1').html(respuesta["html"]);
                }else if(respuesta["estatus"]=="error"){
                	Swal.fire({
                        title: 'Error',
                        text: respuesta["msg"],
                        icon: 'error',
                        showConfirmButton: true,
                    })
                }
            },

            error: function(respuesta) {
                console.log(respuesta['responseText']);
            }
        });
    }

    function paginacion1(value){
        $('#datatables').attr({'data-pagina':value})
        filtrar1();
    }
	
	$("#formulario1").on("submit", function(e){
		e.preventDefault();
		var titulo = $('#titulo').val();
		var descripcion = $('#descripcion').val();
		var categoria = $('#categoria').val();
		$.ajax({
			type: 'POST',
			url: 'libros_create',
			dataType: "JSON",
			data: {
				'titulo': titulo,
				'descripcion': descripcion,
				'categoria': categoria,
			},

			success: function(respuesta) {
				console.log(respuesta);
				if(respuesta["estatus"]=='ok'){
					Swal.fire({
						title: 'Listo',
						text: respuesta["msg"],
						icon: 'success',
						showConfirmButton: true,
					});
					$('#titulo').val("");
					$('#descripcion').val("");
					$('#categoria').val("");
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

    function editar(id){
        $.ajax({
            type: 'POST',
            url: 'libros_editar',
            dataType: "JSON",
            data: {
            	"id": id,
            },

            success: function(respuesta) {
                console.log(respuesta);
                $('#hidden_libro').val(respuesta["proceso1"][0]["id"]);
                $('#titulo2').val(respuesta["proceso1"][0]["titulo"]);
                $('#descripcion2').val(respuesta["proceso1"][0]["descripcion"]);
                $('#categoria2').val(respuesta["proceso1"][0]["categoria_id"]);
            },

            error: function(respuesta) {
                console.log(respuesta['responseText']);
            }
        });
    }

    $("#formulario2").on("submit", function(e){
		e.preventDefault();
		var id = $('#hidden_libro').val();
		var titulo = $('#titulo2').val();
		var descripcion = $('#descripcion2').val();
		var categoria = $('#categoria2').val();
		$.ajax({
			type: 'POST',
			url: 'libros_update',
			dataType: "JSON",
			data: {
				'id': id,
				'titulo': titulo,
				'descripcion': descripcion,
				'categoria': categoria,
			},

			success: function(respuesta) {
				console.log(respuesta);
				if(respuesta["estatus"]=='ok'){
					Swal.fire({
						title: 'Listo',
						text: respuesta["msg"],
						icon: 'success',
						showConfirmButton: true,
					});
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

  	function eliminar(id){
		Swal.fire({
			title: 'Estas seguro?',
			text: "Luego no podrás revertir esta acción",
			icon: 'warning',
			showConfirmButton: true,
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si, Eliminar registro!',
			cancelButtonText: 'Cancelar'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					type: 'POST',
					url: 'libros_eliminar',
					dataType: "JSON",
					data: {
						"id": id,
					},
					success: function(respuesta) {
						console.log(respuesta);
					},

					error: function(respuesta) {
						console.log("error..."+respuesta);
					}
				});
			}
		})
	}

</script>