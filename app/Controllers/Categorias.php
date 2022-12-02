<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Categoria;

class Categorias extends Controller {

	public function consulta(){
		$db      = \Config\Database::connect();
		$builder = $db->table('categorias');

		$sql1 = $db->query("SELECT * FROM categorias");
		$proceso1 = $sql1->getResultArray();
		$html1 = '<option value="">Seleccione</option>';
		foreach($proceso1 as $categoria){
			$html1 .= '
				<option value="'.$categoria["id"].'">'.$categoria["nombre"].'</option>
			';
		}
		$data = ['estatus'=>'ok','html1'=>$html1];
		return $this->response->setJSON($data);
	}

}

?>