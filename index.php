<?php

require './connect.php';
$connect = new \PDO(DSN, USER, PASS);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $contact = array_map('trim', $_POST);
    $errors = [];

    if (empty($contact['firstName'])) {
        $errors[] = 'Le prénom est obligatoire';
    }
    $maxFisrtnameLength = 45;
    if (strlen($contact['firstName']) > $maxFisrtnameLength) {
        $errors[] = 'Le prénom doit faire moins de' . $maxFisrtnameLength . 'caractères';
    }
    if (empty($contact['lastName'])) {
        $errors[] = 'Le nom est obligatoire';
    }
    $maxlastnameLength = 45;
    if (strlen($contact['lastName']) > $maxlastnameLength) {
        $errors[] = 'Le nom doit faire moins de' . $maxlastnameLength . 'caractères';
    }

    if (empty($errors)) {
        $friends = [];
        $connect = new \PDO(DSN, USER, PASS);

        $query = "INSERT INTO friend (prenom, nom) VALUES (:prenom, :nom)";

        $statement = $connect->prepare($query);
        $statement->bindValue(':prenom', $contact['firstName'], \PDO::PARAM_STR);
        $statement->bindValue(':nom', $contact['lastName'], \PDO::PARAM_STR);
        $statement->execute();

        $queryPost = "SELECT prenom, nom from friend";

        $PDOstatement = $connect->query($queryPost);
        $friends = $PDOstatement->fetchAll(\PDO::FETCH_ASSOC);
        //header('Location: /');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <ul>
        <?php foreach ($friends as $friend) { ?>
            <li>
                <?= $friend['prenom'] . ' ' . $friend['nom'] ?>
            </li>
        <?php } ?>
    </ul>

    <form action="" method="POST">
        <label for="firstName">FirstName</label>
        <input type="text" name="firstName" id="firstName">
        <label for="lastName">lastName</label>
        <input type="text" name="lastName" id="lastName">
        <button>ajouter nouvelle personne</button>
    </form>
</body>

</html>