<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['user'])) {
    header('Location:.');
    exit;
}
$user = $_SESSION['user'];

try {
    $connection = new \PDO(
      'mysql:host=localhost;dbname=pokemons',
      'root',
      'Antonio131105',
      array(
        PDO::ATTR_PERSISTENT => true,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'set names utf8')
    );
} catch(PDOException $e) {
    header('Location:..');
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $url = '.?op=destroypokemon&result=noid';
    header('Location: ' . $url);
    exit;
}

// Restricción de eliminación basada en el usuario
if (($user === 'even' && $id % 2 != 0) || ($user === 'odd' && $id % 2 == 0)) {
    header('Location: .?op=destroypokemon&result=evenodd');
    exit;
}

// Eliminar Pokémon de la base de datos
$sql = 'DELETE FROM pokemon WHERE id = :id';
$sentence = $connection->prepare($sql);
$parameters = ['id' => $id];
foreach ($parameters as $nombreParametro => $valorParametro) {
    $sentence->bindValue($nombreParametro, $valorParametro);
}

try {
    $sentence->execute();
    $resultado = $sentence->rowCount(); // Cantidad de filas afectadas
} catch (PDOException $e) {
    $resultado = 0;
}

$connection = null;
$url = '.?op=deletepokemon&result=' . $resultado;
header('Location: ' . $url);
