<?php

$metodo = $_SERVER['REQUEST_METHOD'];

$servername = "172.17.0.1:3306";
$user = "root";
$pass = "sam";
$db = "mydb";

// Create connection
$conn = mysqli_connect($servername, $user, $pass, $db) or die("Connessione non riuscita" . mysqli_connect_error());

$page = $_GET['page'];
$size = $_GET['size'];


/* $start=$_POST['start'];
      $lenght=$_POST['length'];
      $cerca=$_POST['search']['value'];
      $ord=$_POST['order']['0']['dir'];
      $num=$_POST['order']['0']['column'];*/

$num = $num + 1;
$a = array();
$Selectall = "SELECT * FROM employees order by 1 desc limit 20 "; //select 
$Selectallr = mysqli_query($conn, $Selectall) or //risultato
    die("Query fallita 0 " . mysqli_error($conn) . " " . mysqli_errno($conn));


$a["data"] = array();
while ($row = mysqli_fetch_array($Selectallr, MYSQLI_NUM)) //solo associativo
{
    $dipendente = array(

        "DT_RowId" => $row['0'],
        "birth_date" => $row['1'],
        "first_name" => $row['2'],
        "last_name" => $row['3'],
        "gender" => $row['4'],
        "hire_date" => $row['5']
    );
    array_push($a["data"], $dipendente);
}

echo json_encode($a);

if ($_POST["action"] == "create") {

    $birth = $_POST['data']['0']['users']['birth_date'];
    $first = $_POST['data']['0']['users']['first_name'];
    $last = $_POST['data']['0']['users']['last_name'];
    $gender = $_POST['data']['0']['users']['gender'];
    $hire = $_POST['data']['0']['users']['hire_date'];

    $inserto = "INSERT INTO employees (birth_date,first_name,last_name,gender,hire_date)" . " Values('$birth','$first','$last','$gender','$hire')"; //select 
    $insertor = mysqli_query($conn, $inserto) or //risultato
        die("Query fallita 0 " . mysqli_error($conn) . " " . mysqli_errno($conn));
}

if ($_POST["action"] == "edit") {
    $id = array_keys($_POST['data'])[0];
    if ($_POST['data'][$id]['users']['removed_date'] != "") {
        $inserto = "DELETE from employees WHERE id = '$id'"; //select
        $insertor = mysqli_query($conn, $inserto) or //risultato
            die("Query fallita 0 " . mysqli_error($conn) . " " . mysqli_errno($conn));
    } else {

        $birth = $_POST['data'][$id]['users']['birth_date'];
        $first = $_POST['data'][$id]['users']['first_name'];
        $last = $_POST['data'][$id]['users']['last_name'];
        $gender = $_POST['data'][$id]['users']['gender'];
        $hire = $_POST['data'][$id]['users']['hire_date'];
        
        $upda = "UPDATE employees
  SET birth_date='$birth', first_name='$first', last_name= '$last', gender ='$gender',hire_date='$hire' where id='$id'"; //select 
        $updar = mysqli_query($conn, $upda) or //risultato
            die("Query fallita 0 " . mysqli_error($conn) . " " . mysqli_errno($conn));
    }
}
