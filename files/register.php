<?php
session_start();
if(isset($_POST['register'])) {
    include '_dbConnection.php';
    $fn = $_POST["first_name"];
    $ln = $_POST["last_name"];
    $usern =$_POST["username"];
    $pw = md5($_POST["password"]);
    $mail = $_POST["email"];
    try {
        $sql = "INSERT INTO  phpmyadmin.users_tbl(first_name,last_name,username,password,email)
                VALUES (:fn, :ln, :usern,:pw,:mail)";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':fn', $fn); //parameter1
        $stmt->bindParam(':ln', $ln); //parameter1
        $stmt->bindParam(':usern', $usern); //parameter1
        $stmt->bindParam(':pw', $pw); //parameter1
        $stmt->bindParam(':mail', $mail); //parameter1

        $stmt->execute();

        $last_id = $connect->lastInsertId();
        $_SESSION['username']=$usern;
        header("location:reviews.php");
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    $connect = null;
}




?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" integrity="sha512-8bHTC73gkZ7rZ7vpqUQThUDhqcNFyYi2xgDgPDHc+GXVGHXq+xPjynxIopALmOPqzo9JZj0k6OqqewdGO3EsrQ==" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js" integrity="sha512-dqw6X88iGgZlTsONxZK9ePmJEFrmHwpuMrsUChjAw1mRUhUITE5QU9pkcSox+ynfLhL15Sv2al5A0LVyDCmtUw==" crossorigin="anonymous"></script>

<div class="ui inverted vertical center aligned segment" style="height: 100vh">
    <div class="ui two column grid" style="margin-top: 2em;border-bottom: 2px solid white;" >
        <div class="column">
            <h1 class="ui inverted header">ReviewSniper</h1>
        </div>
        <div class="column">
            <div class="ui borderless inverted compact menu">
                <a class="active item" href="reviewAlgo.php">Home</a>
                <a class="item" href="reviews.php">Reviews</a>
                <a class="item" href="about.php">About</a>
            </div>
        </div>
    </div>
    <div class="ui content container" style="margin-top: 5em">
        <div class="ui inverted header" style="font-size: 45px">Register</div>
        <form method="post" action="">
            <div class="ui segment" style="width: 30%; margin-right: auto;margin-left: auto">

                <div class="ui left icon input" style="margin-top: 1em">
                    <input name="first_name" type="text" placeholder="First Name">
                    <i class="user icon"></i>
                </div>
                <div class="ui left icon input" style="margin-top: 1em">
                    <input name="last_name" type="text" placeholder="Last Name">
                    <i class="user icon"></i>
                </div>

                <div class="ui left icon input" style="margin-top: 1em">
                    <input name="email" type="text" placeholder="Email">
                    <i class="user icon"></i>
                </div>

                <div class="ui left icon input" style="margin-top: 1em">
                    <input name="username" type="text" placeholder="Username">
                    <i class="user icon"></i>
                </div>
                <br />
                <div class="ui left icon input" style="margin-top: 1em; margin-bottom: 1em">
                    <input name="password" type="password" placeholder="Password">
                    <i class="lock icon"></i>
                </div>
                <br>
                <input class="ui blue button" name="register" type="submit"/>
            </div>
            <p align="center"><a href="login.php">Already have an account, click here to login</a></p>
        </form>

    </div>

    <footer style="margin-top:20em;opacity: 25%">ReviewSniper by Olivier Lemire, Jon Ma, Tuan Nguyen</footer>
</div>