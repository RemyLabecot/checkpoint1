<?php
/**
 * Created by PhpStorm.
 * User: remy
 * Date: 05/10/18
 * Time: 09:43
 */


function showContacts(\PDO $pdo) : array
{
    $select = "SELECT * FROM contact JOIN civility ON contact.civility_id = civility.id ORDER BY lastname;";
    $result = $pdo->query($select);
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function fullName (string $nom, string $prenom) :string
{
    return strtoupper($nom) . ' ' . ucfirst($prenom);
}
function addContacts(array $data, \PDO $pdo)
{
    $sql = "INSERT INTO contact (`lastname`, `firstname`, `civility_id`) VALUES (:nom, :prenom, :civilite)";
    $prep = $pdo->prepare($sql);
    $prep->bindValue(':nom', $data['nom'], PDO::PARAM_STR);
    $prep->bindValue(':prenom', $data['prenom'], PDO::PARAM_STR);
    $prep->bindValue(':civilite', $data['civilite'], PDO::PARAM_INT);
    $prep->execute();
}
function test_input($variable)
{
    $variable = trim($variable);
    $variable = stripslashes($variable);
    $variable = htmlspecialchars($variable);
    return $variable;
}