<?php

namespace App\Controllers;
//require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use App\Models\Log;

class Home extends BaseController
{

    public function index(){
        $session = session();
        $session->destroy();
        
        $datos['cabecera']=view('header.php');
        $datos['footer']=view('footer.php');
        return view('index',$datos);
    }

    public function exportar1(){

        /*****LOGS*****/
        $logs = new Log;
        $session = session();
        $datos_logs = [
            'usuario_id' => $session->get("usuario"),
            'accion' => "Exporto los registros en Excel",
            'fecha_creacion' => date('Y-m-d')
        ];
        $logs->save($datos_logs);
        /*****************************/

        $fecha_desde = $this->request->getPost('fecha_desde_exportar');
        $fecha_hasta = $this->request->getPost('fecha_hasta_exportar');
        $categoria = $this->request->getPost('categoria_exportar');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Titulo');
        $sheet->setCellValue('B1', 'Descripción');
        $sheet->setCellValue('C1', 'Categoria');
        $sheet->setCellValue('D1', 'Fecha Creacion');

        $count = 2;

        if($fecha_desde!=''){
            $fecha_desde = ' and (libros.fecha_creacion >= "'.$fecha_desde.'")';
        }

        if($fecha_hasta!=''){
            $fecha_hasta = ' and (libros.fecha_creacion <= "'.$fecha_hasta.'")';
        }

        if($categoria!=''){
            $categoria = ' and (libros.categoria_id = '.$categoria.')';
        }

        $db      = \Config\Database::connect();
        $builder = $db->table('libros');
        $sql1 = $db->query("SELECT libros.id as lib_id, libros.titulo as lib_titulo, libros.descripcion as lib_descripcion, libros.fecha_creacion as lib_fecha_creacion, categorias.nombre as cate_nombre FROM libros INNER JOIN categorias ON libros.categoria_id = categorias.id WHERE libros.id != 0 ".$fecha_desde." ".$fecha_hasta." ".$categoria);
        $proceso1 = $sql1->getResultArray();

        foreach($proceso1 as $row){
            $sheet->setCellValue('A'.$count, $row["lib_titulo"]);
            $sheet->setCellValue('B'.$count, $row["lib_descripcion"]);
            $sheet->setCellValue('C'.$count, $row["cate_nombre"]);
            $sheet->setCellValue('D'.$count, $row["lib_fecha_creacion"]);
            $count = $count+1;
        }

        $writer = new Xlsx($spreadsheet);
        //$documento = ROOTPATH . 'nuevoexcel.xls';
        $file_name = 'data.xlsx';
        $writer->save($file_name);
        header("Content-Type: application/vnd.ms-excel");
        header("Content-disposition: attachment; filename=".basename($file_name.""));
        header("Expires: 0");
        header("Cache-Control: must-revalidate");
        header("Pragma: public");
        header("Content-Length: ".filesize($file_name));
        flush();
        readfile($file_name);
        exit;

        //return view('exportar1.php');
        //$data = ['estatus'=>'ok','proceso1'=>$proceso1];
        //return $this->response->setJSON($data);
    }

    public function pdf1(){

        /*****LOGS*****/
        $logs = new Log;
        $session = session();
        $datos_logs = [
            'usuario_id' => $session->get("usuario"),
            'accion' => "Exporto los registros en PDF",
            'fecha_creacion' => date('Y-m-d')
        ];
        $logs->save($datos_logs);
        /*****************************/

        $fecha_desde = $this->request->getPost('fecha_desde_exportar2');
        $fecha_hasta = $this->request->getPost('fecha_hasta_exportar2');
        $categoria = $this->request->getPost('categoria_exportar2');

        $dompdf = new Dompdf();

        if($fecha_desde!=''){
            $fecha_desde = ' and (libros.fecha_creacion >= "'.$fecha_desde.'")';
        }

        if($fecha_hasta!=''){
            $fecha_hasta = ' and (libros.fecha_creacion <= "'.$fecha_hasta.'")';
        }

        if($categoria!=''){
            $categoria = ' and (libros.categoria_id = '.$categoria.')';
        }

        $html = '
        <div class="col-12">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th class="text-center">Titulo</th>
                    <th class="text-center">Descripción</th>
                    <th class="text-center">Categoría</th>
                    <th class="text-center">Fecha Creación</th>
                </tr>
                </thead>
                <tbody>
        ';

        $db      = \Config\Database::connect();
        $builder = $db->table('libros');
        $sql1 = $db->query("SELECT libros.id as lib_id, libros.titulo as lib_titulo, libros.descripcion as lib_descripcion, libros.fecha_creacion as lib_fecha_creacion, categorias.nombre as cate_nombre FROM libros INNER JOIN categorias ON libros.categoria_id = categorias.id WHERE libros.id != 0 ".$fecha_desde." ".$fecha_hasta." ".$categoria);
        $proceso1 = $sql1->getResultArray();

        foreach($proceso1 as $row){
            $html .= '
                    <tr>
                        <td class="text-center">'.$row["lib_titulo"].'</td>
                        <td class="text-center">'.$row["lib_descripcion"].'</td>
                        <td class="text-center">'.$row["cate_nombre"].'</td>
                        <td class="text-center">'.$row["lib_fecha_creacion"].'</td>
                    </tr>
                ';
        }

        $html .= '
                </tbody>
            </table>
        <div>
        ';

        $dompdf->loadHTML($html);
        $dompdf->setPaper("A4","landscape");
        $dompdf->render();
        $dompdf->stream();
    }
}
