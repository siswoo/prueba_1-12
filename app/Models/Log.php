<?php
namespace App\Models;

use CodeIgniter\Model;

class Log extends Model {
	protected $table = 'logs';
	protected $primaryKey = 'id';
	protected $allowedFields = ['usuario_id','accion','fecha_creacion'];
}

?>