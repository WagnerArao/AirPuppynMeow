<?php

function get_conn() {

    $config = require 'config.php';

    $pdo = new PDO(
        $config['database_dsn'],
        $config['database_user'],
        $config['database_pass'],
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;

};

function get_pets($limit = null) {

    $pdo = get_conn();
    
    $query = 'SELECT * FROM pet';

    if ($limit != 0) {
        $query = $query." LIMIT :limit";
    }

    $stmt = $pdo->prepare($query);
    $stmt->bindParam('limit', $limit, PDO::PARAM_INT);
    $stmt->execute();

    $pets = $stmt->fetchAll();

    return $pets;

}

function get_pet($id) {

    $pdo = get_conn();

    $query = "SELECT * FROM pet WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam('id', $id);
    $stmt->execute();

    return $stmt->fetch();
}

function save_pets($petsToSave){
    $json = json_encode($petsToSave, JSON_PRETTY_PRINT);
    file_put_contents('data/pets.json', $json);
}