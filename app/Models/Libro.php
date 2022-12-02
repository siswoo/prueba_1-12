<?php
namespace App\Models;

use CodeIgniter\Model;

class Libro extends Model {
	protected $table = 'libros';
	protected $primaryKey = 'id';
	protected $allowedFields = ['titulo','descripcion','categoria_id','fecha_creacion'];
}

?>