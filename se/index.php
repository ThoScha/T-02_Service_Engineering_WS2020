<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="table_css.css">
</head>
<body>
<h1>MfCDSD</h1>
<h2>My first Corona Daten Sauger Dashboard :P #sloppy Jessica </h2>

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

    $db["persons"][$nr]["age"]=$_POST['age'];
    $db["persons"][$nr]["gender"]=$_POST['gender'];
    $db["persons"][$nr]["preill"]=$_POST['preill'];
    $db["persons"][$nr]["district"]=$_POST['district'];
    $db["persons"][$nr]["state"]=$_POST['state'];
 

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
    $object->age = $_POST['age'];
    $object->gender = $_POST['gender'];
    $object->preill = $_POST['preill'];
    $object->district = $_POST['district'];
    $object->state = $_POST['state'];
    array_push($db["persons"], $object);

    file_put_contents('test.json', json_encode($db));

} else {
    //invalid action!
}

echo $twig->render('first.html.twig', ['input' => $db["persons"]]);


?>



</body>
</html>
