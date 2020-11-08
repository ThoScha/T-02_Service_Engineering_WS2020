<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="table_css.css">
</head>
<body>
<h1>MfCDSD</h1>
<h2>My first Corona Daten Sauger Dashboard :P</h2>

<?php
require __DIR__ . '/vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader);


$str = file_get_contents('test.json');
$db = json_decode($str, true);

if (isset($_POST['update_button'])) {

    $userID=$_POST['userID'];
    $nr=array_search($userID, array_column($db["persons"], 'id'));
    $fn=$_POST['firstname'];
    $ln=$_POST['lastname'];

    $db["persons"][$nr]["firstname"]=$fn;
    $db["persons"][$nr]["lastname"]=$ln;
    file_put_contents('test.json', json_encode($db));

} else if (isset($_POST['delete_button'])) {
    $userID=$_POST['userID'];
    $nr=array_search($userID, array_column($db["persons"], 'id'));
    array_splice($db["persons"], $nr, 1);
    file_put_contents('test.json', json_encode($db));
} else if (isset($_POST['add_button'])) {
    //check if id is already in db :§
    $id=rand(0,10000);

    $object = new stdClass();
    $object->id = $id;
    $object->firstname = $_POST['firstname'];
    $object->lastname = $_POST['lastname'];
    array_push($db["persons"], $object);

    file_put_contents('test.json', json_encode($db));

} else {
    //invalid action!
}

echo $twig->render('first.html.twig', ['input' => $db["persons"]]);


?>



</body>
</html>
