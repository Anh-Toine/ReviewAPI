<?php include '_dbConnection.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
<?php
try {
    //1)dropping the table in case it exists

    //2)creating table
    $sql = "CREATE TABLE IF NOT EXISTS USERS_TBL (
        id INT(10) AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(125),
        last_name VARCHAR(125),
        username varchar(125) NOT NULL,
        password VARCHAR(300) NOT NULL,
        email VARCHAR(125) 
        )";

    $connect->exec($sql);


    //create users
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
$connect = null;
include '_dbConnection.php';
try {
    //1)dropping the table in case it exists

    //2)creating table
    $sql2 = "CREATE TABLE IF NOT EXISTS REVIEWS_TBL (
        id INT(10) AUTO_INCREMENT PRIMARY KEY,
        user_id int(10) NOT NULL,
        review_url VARCHAR(200) NOT NULL,
        review_name VARCHAR(100)
        )";

    $connect->exec($sql2);


    //create users
} catch (PDOException $e) {
    echo $sql2 . "<br>" . $e->getMessage();
}

$connect = null;
?>
</body>

</html>