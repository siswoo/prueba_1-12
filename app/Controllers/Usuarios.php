<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Usuario;
use App\Models\Log;

class Usuarios extends Controller {

	public function login(){
		$usuario = $this->request->getPost('usuario');
		$clave = $this->request->getPost('clave');
		$clave = md5($clave);

		$db      = \Config\Database::connect();
		$builder = $db->table('usuarios');

		$sql1 = $db->query("SELECT * FROM usuarios WHERE usuario = '".$usuario."' and clave = '".$clave."'");
		$proceso1 = $sql1->getResultArray();

		$conteo1 = $db->query("SELECT COUNT(*) as conteo1 FROM usuarios  WHERE usuario = '".$usuario."' and clave = '".$clave."'");
		$conteo1 = $conteo1->getResultArray();
		$conteo1 = $conteo1[0]["conteo1"];

	    if($conteo1>=1){
			foreach($proceso1 as $row){
				$session = session();
				$session->set('usuario',$row["id"]);
			}
			$data = ['estatus'=>'ok',"session"=>$session];
			/*****LOGS*****/
			$logs = new Log;
			$datos_logs = [
				'usuario_id' => $session->get("usuario"),
				'accion' => "Login",
				'fecha_creacion' => date('Y-m-d')
			];
			$logs->save($datos_logs);
			/*****************************/
		}else{
			$data = ['estatus'=>'error','msg'=>"Datos incorrectos"];
		}

		return $this->response->setJSON($data);
	}

	public function logs(){
		$log = new Log();
		$datos['cabecera']=view('header.php');
		$datos['footer']=view('footer.php');

		$db      = \Config\Database::connect();
		$builder = $db->table('logs');
		$sql1 = $db->query("SELECT logs.accion as logs_accion, logs.fecha_creacion as logs_fecha_creacion, usuarios.usuario as usuarios_usuario FROM logs INNER JOIN usuarios ON logs.usuario_id = usuarios.id");
		$proceso1 = $sql1->getResultArray();

		$datos['proceso1']=$proceso1;
		return view('logs',$datos);
	}

}

?>
