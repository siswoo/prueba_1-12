<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Libro;
use App\Models\Log;

class Libros extends Controller {

	public function index(){
		$libro = new Libro();
		$datos['libros'] = $libro->orderBy('id','ASC')->findAll();
		$datos['cabecera']=view('header.php');
		$datos['footer']=view('footer.php');
		return view('crud1',$datos);
	}

	public function create(){
		$libros = new Libro;
		$data = [
			'titulo' => $this->request->getPost('titulo'),
			'descripcion' => $this->request->getPost('descripcion'),
			'categoria_id' => $this->request->getPost('categoria'),
			'fecha_creacion' => date('Y-m-d'),
		];
		$libros->save($data);

		/*****LOGS*****/
		$logs = new Log;
		$session = session();
		$datos_logs = [
			'usuario_id' => $session->get("usuario"),
			'accion' => "Crear Nuevo Libro",
			'fecha_creacion' => date('Y-m-d')
		];
		$logs->save($datos_logs);
		/*****************************/


		$data = ['estatus'=>'ok','msg'=>'Se ha creado exitosamente','data'=>$data];
		return $this->response->setJSON($data);
	}

	public function consulta(){
		$libros = new Libro;
		$pagina = $this->request->getPost('pagina');
		$consultasporpagina = $this->request->getPost('consultasporpagina');
		$filtrado = $this->request->getPost('filtrado');
		
		if($pagina==0 or $pagina==''){
			$pagina = 1;
		}

		if($consultasporpagina==0 or $consultasporpagina==''){
			$consultasporpagina = 10;
		}

		if($filtrado!=''){
			$filtrado = ' and (libros.titulo LIKE "%'.$filtrado.'%" or libros.descripcion LIKE "%'.$filtrado.'%")';
		}

		$limit = $consultasporpagina;
		$offset = ($pagina - 1) * $consultasporpagina;

		$db      = \Config\Database::connect();
		$builder = $db->table('libros');
		$hola = "1";
		$sql1 = $db->query("SELECT libros.id as lib_id, libros.titulo as lib_titulo, libros.fecha_creacion as lib_fecha_creacion, libros.descripcion as lib_descripcion, categorias.nombre as cate_nombre FROM libros INNER JOIN categorias ON libros.categoria_id = categorias.id WHERE libros.id != 0 ".$filtrado);
		$sql2 = $db->query("SELECT libros.id as lib_id, libros.titulo as lib_titulo, libros.fecha_creacion as lib_fecha_creacion, libros.descripcion as lib_descripcion, categorias.nombre as cate_nombre FROM libros INNER JOIN categorias ON libros.categoria_id = categorias.id WHERE libros.id != 0 ".$filtrado." ORDER BY libros.id ASC LIMIT ".$limit." OFFSET ".$offset);
		
		$proceso1 = $sql1->getResultArray();
		$proceso2 = $sql2->getResultArray();

		$conteo1 = $db->query("SELECT COUNT(*) as conteo1 FROM libros WHERE id != 0 ".$filtrado);
		$conteo1 = $conteo1->getResultArray();
		$conteo1 = $conteo1[0]["conteo1"];
		$paginas = ceil($conteo1 / $consultasporpagina);

		$html = '
		<div class="col-12">
	        <table class="table table-bordered">
	            <thead>
	            <tr>
					<th class="text-center">Titulo</th>
					<th class="text-center">Descripción</th>
					<th class="text-center">Categoría</th>
					<th class="text-center">Fecha Creación</th>
					<th class="text-center">Opciones</th>
	            </tr>
	            </thead>
	            <tbody>
	    ';

	    if($conteo1>=1){
			foreach($proceso2 as $libro){
				$html .= '
					<tr>
						<td class="text-center">'.$libro["lib_titulo"].'</td>
						<td class="text-center">'.$libro["lib_descripcion"].'</td>
						<td class="text-center">'.$libro["cate_nombre"].'</td>
						<td class="text-center">'.$libro["lib_fecha_creacion"].'</td>
						<td class="text-center">
							<button class="btn btn-primary" data-toggle="modal" data-target="#modal_editar" onclick="editar('.$libro["lib_id"].');">Editar</button>
							<button class="btn btn-danger" onclick="eliminar('.$libro["lib_id"].');">Eliminar</button>
						</td>
					</tr>
				';
			}
		}else{
			$html .= '
				<tr>
					<td colspan="4" class="text-center">Sin resultados</td>
				</tr>';
		}

		$html .= '
	            </tbody>
	        </table>
	        <nav>
	            <div class="row">
	                <div class="col-xs-12 col-sm-4 text-center">
	                    <p>Mostrando '.$consultasporpagina.' de '.$conteo1.' Datos disponibles</p>
	                </div>
	                <div class="col-xs-12 col-sm-4 text-center">
	                    <p>Página '.$pagina.' de '.$paginas.' </p>
	                </div> 
	                <div class="col-xs-12 col-sm-4">
			            <nav aria-label="Page navigation" style="float:right; padding-right:2rem;">
							<ul class="pagination">
		';

		if ($pagina > 1) {
			$html .= '
									<li class="page-item">
										<a class="page-link" onclick="paginacion1('.($pagina-1).');" href="#">
											<span aria-hidden="true">Anterior</span>
										</a>
									</li>
			';
		}

		$diferenciapagina = 3;
		
		/*********MENOS********/
		if($pagina==2){
			$html .= '
			                		<li class="page-item">
				                        <a class="page-link" onclick="paginacion1('.($pagina-1).');" href="#">
				                            '.($pagina-1).'
				                        </a>
				                    </li>
			';
		}else if($pagina==3){
			$html .= '
				                    <li class="page-item">
				                        <a class="page-link" onclick="paginacion1('.($pagina-2).');" href="#"">
				                            '.($pagina-2).'
				                        </a>
				                    </li>
				                    <li class="page-item">
				                        <a class="page-link" onclick="paginacion1('.($pagina-1).');" href="#"">
				                            '.($pagina-1).'
				                        </a>
				                    </li>
		';
		}else if($pagina>=4){
			$html .= '
			                		<li class="page-item">
				                        <a class="page-link" onclick="paginacion1('.($pagina-3).');" href="#"">
				                            '.($pagina-3).'
				                        </a>
				                    </li>
				                    <li class="page-item">
				                        <a class="page-link" onclick="paginacion1('.($pagina-2).');" href="#"">
				                            '.($pagina-2).'
				                        </a>
				                    </li>
				                    <li class="page-item">
				                        <a class="page-link" onclick="paginacion1('.($pagina-1).');" href="#"">
				                            '.($pagina-1).'
				                        </a>
				                    </li>
			';
		} 

		/*********MAS********/
		$opcionmas = $pagina+3;
		if($paginas==0){
			$opcionmas = $paginas;
		}else if($paginas>=1 and $paginas<=4){
			$opcionmas = $paginas;
		}
		
		for ($x=$pagina;$x<=$opcionmas;$x++) {
			$html .= '
				                    <li class="page-item 
			';

			if ($x == $pagina){ 
				$html .= '"active"';
			}

			$html .= '">';

			$html .= '
				                        <a class="page-link" onclick="paginacion1('.($x).');" href="#"">'.$x.'</a>
				                    </li>
			';
		}

		if ($pagina < $paginas) {
			$html .= '
				                    <li class="page-item">
				                        <a class="page-link" onclick="paginacion1('.($pagina+1).');" href="#"">
				                            <span aria-hidden="true">Siguiente</span>
				                        </a>
				                    </li>
			';
		}

		$html .= '

							</ul>
						</nav>
					</div>
		        </nav>
		    </div>
		';

		$data = ['estatus'=>'ok','html'=>$html];
		return $this->response->setJSON($data);
	}

	public function editar(){
		$db      = \Config\Database::connect();
		$builder = $db->table('libros');

		$id = $this->request->getPost('id');
		$sql1 = $db->query("SELECT * FROM libros WHERE id = ".$id);
		$proceso1 = $sql1->getResultArray();

		$data = ['estatus'=>'ok','proceso1'=>$proceso1];
		return $this->response->setJSON($data);
	}

	public function update(){
		$libros = new Libro();
		$id = $this->request->getPost('id');
		$update = [
			"titulo" => $this->request->getPost('titulo'),
			"descripcion" => $this->request->getPost('descripcion'),
			"categoria_id" => $this->request->getPost('categoria')
		];
		$libros->update($id,$update);
		/*****LOGS*****/
		$logs = new Log;
		$session = session();
		$datos_logs = [
			'usuario_id' => $session->get("usuario"),
			'accion' => "Modificar Libro # ".$id,
			'fecha_creacion' => date('Y-m-d')
		];
		$logs->save($datos_logs);
		/*****************************/
		$data = ['estatus'=>'ok','msg'=>"Se ha modificado exitosamente"];
		return $this->response->setJSON($data);
	}

	public function delete(){
		$libros = new Libro();
		$id = $this->request->getPost('id');
		$libros->delete($id);

		/*****LOGS*****/
		$logs = new Log;
		$session = session();
		$datos_logs = [
			'usuario_id' => $session->get("usuario"),
			'accion' => "Elimino el libro # ".$id,
			'fecha_creacion' => date('Y-m-d')
		];
		$logs->save($datos_logs);
		/*****************************/

		$data = ['estatus'=>'ok','msg'=>"Se ha eliminado exitosamente"];
		return $this->response->setJSON($data);
	}

}

?>