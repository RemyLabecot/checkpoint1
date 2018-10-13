<?php
require __DIR__ . '/../App/db.php';
require __DIR__ . '/../src/functions.php';
$pdo = new PDO(DSN, USER, PASS);

$firstName = $lastName = $win ="";
$firstNameErr =  $lastNameErr = "";

if($_SERVER['REQUEST_METHOD'] === 'POST') {


    if (empty($_POST['nom'])) {
        $lastNameErr = "Veuillez entrer un nom";
    } else {
        $lastName = test_input($_POST['nom']);
        if (!preg_match('/^[a-zA-Z ]*$/', $lastName)){
            $lastNameErr = "Lettres et espaces seulement dans le nom";
        }
    }
    if (empty($_POST['prenom'])) {
        $firstNameErr = "Veuillez entrer un prenom";
    } else {
        $firstName = test_input($_POST['prenom']);
        if (!preg_match('/^[a-zA-Z ]*$/', $firstName)){
            $firstNameErr = "Lettres et espaces seulement dans le prénom";
        }
    }

    if ($lastNameErr  === "" && $firstNameErr  === "") {
        addContacts($_POST, $pdo);
        $win = "Utilisateur ajouté";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Ajouter des articles</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" media="screen" href="main.css" />

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
    crossorigin="anonymous">
</head>
<body>
<!-- formulaire ajout -->
  <div class="container">
    <div class="row">
      <div class="col-12">
        <form action="index.php" method="post">
            <div class="form-group">
                <div class="checkbox">
                    <label><input type="checkbox" name="civilite" value="1">M.</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" value="2">Mme.</label>
                </div>
            </div>
          <div class="form-group">
            <label for="nom">Titre</label>
            <input class="form-control" id="nom" name="nom" placeholder="Nom" value="<?php if(isset($_POST['nom'])) echo $_POST['nom'];?>">
              <?= $lastNameErr ?>
          </div>
          <div class="form-group">
            <label for="prenom">Auteur</label>
            <input class="form-control" id="prenom" name="prenom" placeholder="Prenom" value="<?php if(isset($_POST['prenom'])) echo $_POST['prenom'];?>">
              <?= $firstNameErr ?>
          </div>
          <button type="submit" class="btn btn-primary">Ajouter</button>
              <?= $win ?>
        </form>
      </div>
    </div>
  </div>
  <br>
  <br>
  <!-- tableau affichage BDD -->
  <table class="table table-hover">
      <thead>
      <tr>
          <th scope="col">Civilité</th>
          <th scope="col">NOM prénom</th>
      </tr>
      </thead>
      <tbody>
      <?php $names = showContacts($pdo);
      foreach($names as $name) {?>
      <tr class="table-active">
          <td><?= $name['civility']; ?></td>
          <th scope="row"><?= fullName($name['lastname'], $name['firstname']); ?></th>
          <?php }?>
      </tr>
      </tbody>
  </table>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
    crossorigin="anonymous"></script>
</body>

</html>