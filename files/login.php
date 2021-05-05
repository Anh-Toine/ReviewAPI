<?php
session_start();
include "_dbConnection.php" ;
if(isset($_REQUEST['username']) && isset($_REQUEST['password'])){
    $password = md5($_REQUEST['password']);
    $username = $_REQUEST['username'];
    $query = "SELECT * FROM phpmyadmin.users_tbl WHERE username=? AND password=?";
    $stmt = $connect->prepare($query);
    $stmt->execute([$_REQUEST['username'],$password]);

    //PDO::FETCH_NUM
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $row = $stmt->fetch();
    if ($row) {
        $_SESSION['username']=$username;
        header("location:reviews.php");
    } else {
        $connect = null;
        echo '<script>alert("Username does not match password")</script>';
    }
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
                <a class="item" href="reviewAlgo.php">Home</a>
                <a class="active item" href="reviews.php">Reviews</a>
                <a class="item" href="about.php">About</a>
            </div>
        </div>
    </div>
    <div class="ui content container" style="margin-top: 5em">
        <div class="ui inverted header" style="font-size: 45px">Log In</div>
        <form method="post" action="">
            <div class="ui segment" style="width: 30%; margin-right: auto;margin-left: auto">
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
                <input class="ui blue button" type="submit">
            </div>
            <p align="center"><a href="register.php">Don't have an account? No problem, click here to register!</a></p>
        </form>

    </div>

    <footer style="margin-top:30em;opacity: 25%">ReviewSniper by Olivier Lemire, Jon Ma, Tuan Nguyen</footer>
</div>
