<?php
include_once "../comun/vendor/autoload.php";
include_once "../comun/database.php";
include_once "../comun/vendor/autoload.php";
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

$reader = ReaderFactory::create(Type::XLSX); //Esto elige los archivos xlsx

$filePath= "test_para_spout.xlsx";

$reader->open($filePath);
$fields_position=[
        "id"     => 0,
        "nombre" => 1,
        "sexo"   => 2 
];
foreach ($reader->getSheetIterator() as $sheet) {
    $i = 0;
    foreach ($sheet->getRowIterator() as $row) {
        if($i):
        // CONTROLAR DATOS QUE SON OBLIGATORIOS 
            if( empty($row[ $fields_position[ "nombre" ] ]) ) : 
                die("Falta nombre y es obligatorio en fila $i");
            endif;
        else:
            foreach ($fields_position as $nombre_campo => $posicion_excel) {
                if($row[$posicion_excel] !== $nombre_campo):
                    echo "Esperaba<br>". json_encode($fields_position)."<br>";
                    echo "Recibido<br>". json_encode($row)."<br>";
                    die("El campo ".$nombre_campo." no esta en la posición correcta");
                endif;
                # code...
            }
         //   echo $row[ $fields_position[ "nombre" ] ] ."|";
         //   echo $row[ $fields_position[ "sexo" ] ] ."<br>";
        endif;
        $i++;
     
    }
}
$reader->close($filePath);




