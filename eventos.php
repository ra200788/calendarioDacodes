<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
 
$pdo=new PDO("mysql:host=127.0.0.1;dbname=sistemacalendario;charset=UTF8","root","");


$accion = (isset($_GET['accion']))?$_GET['accion']:'leer';

switch($accion){
    case 'agregar':
        //instruccion de agregar
        
        $sql = $pdo->prepare("INSERT INTO eventos(title,descripcion,color,textColor,start,end) 
        VALUES (:title,:descripcion,:color,:textColor,:start,:end)");

        $resultado = $sql->execute(array(
            "title" => $_POST['title'],
            "descripcion" => $_POST['descripcion'],
            "color" => $_POST['color'],
            "textColor" => $_POST['txtColor'],
            "start" => $_POST['start'],
            "end" => $_POST['end']

        ));
        echo json_encode($resultado);

        break;
        
    case 'eliminar':
            //instruccion de eliminar
            //echo "instruccion de eliminar";


            $resultado = false;
            if(isset($_POST['id'])){
                $sql = $pdo->prepare("DELETE FROM eventos WHERE id=:ID");
                $resultado = $sql->execute(array("ID"=>$_POST['id']));


            }

            echo json_encode($resultado);
            
        break;

    case 'modificar':
  
      
        $sentenciaSQL = $pdo->prepare("UPDATE eventos SET title=:title, descripcion=:descripcion, color=:color, textColor=:textColor, start=:start, end=:end WHERE id=:id");



$respuesta = $sentenciaSQL->execute(array(
    "id" => $_POST['id'],
    "title" => $_POST['title'],
    "descripcion" => $_POST['descripcion'],
    "color" => $_POST['color'],
    "textColor" => $_POST['txtColor'],
    "start" => $_POST['start'],
    "end" => $_POST['end']

));

echo json_encode($respuesta);


      
                break;
    
    
    default:
        // accion si ninguna condicional se cumple
        
        // selecionar los eventos del calendario
$sentenciaSQL = $pdo->prepare('SELECT * FROM eventos');
$sentenciaSQL->execute();

$resultado= $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($resultado); 
        break;     
}


?>