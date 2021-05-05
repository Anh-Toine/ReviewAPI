<?php
session_start();
include '_dbConnection.php';
$sqlUser = 'SELECT id from phpmyadmin.users_tbl WHERE username = ?';
$getUserId = $connect->prepare($sqlUser);
$getUserId->execute([$_SESSION['username']]);
$userId = $getUserId->fetchAll();
$userId = $userId[0]['id'];
$connect = null;

include '_dbConnection.php';
$sqlReviews = 'SELECT * from phpmyadmin.reviews_tbl WHERE user_id = ?';
$getReviews = $connect->prepare($sqlReviews);
$getReviews->execute([$userId]);
$reviews = $getReviews->fetchAll();
$connect = null;

if(!isset($_REQUEST['reviewId'])){
    $reviewId = 0;
} else {
    $reviewId = $_REQUEST['reviewId'];
}

$name = null;
$productId = null;
$productName = null;
if(isset($_POST['name']) && isset($_POST['productName']) && isset($_POST['productId'])) {
    include '_dbConnection.php';
    $name = $_POST["name"];
    $productName = $_POST["productName"];
    $productId = $_POST["productId"];
    $url = "https://www.amazon.com/".$productName."/dp/".$productId;
    try {
        $sql = "INSERT INTO  phpmyadmin.reviews_tbl(user_id,review_url,review_name)
                VALUES (?,?,?)";
        $stmt = $connect->prepare($sql);
        $stmt->execute([$userId,$url,$name]);
        $last_id = $connect->lastInsertId();
        echo $last_id;
        echo "new record";
        header("location:reviews.php");
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    $connect = null;
}

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" integrity="sha512-8bHTC73gkZ7rZ7vpqUQThUDhqcNFyYi2xgDgPDHc+GXVGHXq+xPjynxIopALmOPqzo9JZj0k6OqqewdGO3EsrQ==" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js" integrity="sha512-dqw6X88iGgZlTsONxZK9ePmJEFrmHwpuMrsUChjAw1mRUhUITE5QU9pkcSox+ynfLhL15Sv2al5A0LVyDCmtUw==" crossorigin="anonymous"></script>
<style>
    ol {
        list-style-position: inside;
    }
    li{
        position: relative;
    }
    li a {
        position: absolute;
        left: 30px;
    }
</style>

<body>
<div class="ui inverted vertical center aligned segment" style="height: 100vh">
    <div class="ui two column grid" style="margin-top: 2em;border-bottom: 2px solid white;" >
        <div class="column">
            <h1 class="ui inverted header">ReviewSniper</h1>
        </div>
        <div class="column">
        <div class="ui borderless inverted compact menu">
            <a class="item" href="reviewAlgo.php">Home</a>
            <a class="active item" href=<?php if(isset($_COOKIE['username'])){echo "reviews.php";}else {echo "login.php";}?>>Reviews</a>
            <a class="item" href="about.php">About</a>
        </div>
        </div>
    </div>

    <div class="ui two column grid" style="">
        <div class="ui four wide column">
            <div class="ui inverted vertical menu" style="margin-left: 1em">
                <h1 style="margin-top: 1em">Your Reviews</h1>

                <?php

                if(!empty($reviews)) {
                    foreach ($reviews as $review){
                        echo '<a href="?reviewId='.$review['id'].'" class="item">'.$review['review_name'].'</a>';
                    }
                }
                ?>
                <a href="?reviewId=0" class="item">
                    Add new review <i class="plus icon"></i>
                </a>
            </div>
        </div>
        <div class="ui twelve wide column">
            <?php

            if(!isset($reviewId) || $reviewId == 0){

                echo '<div class="ui grid" style="margin-top: 5em">
                    <div class="ui row">
                    <h1>New Review</h1>
                    </div>
                    <div class="ui row">
                    <h2>Follow the instructions to add a new Review</h2>
                    </div>
                    <div class="ui row">
                        <ol style="font-size: 20px">
                            <li>Choose A review name (it can be anything, it is a name so that you can recognize this review later on)</li>
                            <li style="margin-top: 2em">
                                Enter the product name and product code in the input fields below (the name and the code of a product are the parts in red of the below example url)
                            </li>
                            <img src="comcut.PNG" style="margin-top: 2em">
                            <li style="margin-top: 2em">
                               After that, we will take care of the rest. You will be able to see your newly added review on the left menu
                            </li>
                        </ol>
                    </div>
                    <form action="" method="post" style="width: 100%">

                                <div class="ui input" >
                                    <input type="text" name="name" placeholder="Review Name" value="" id="name">
                                </div>
                                <div class="ui input" >
                                    <input type="text" name="productName" placeholder="Product Name" value="" id="productName">
                                </div>
                                <div class="ui input" >
                                    <input type="text" name="productId" placeholder="Product Id" value="" id="productId">
                                </div>

                        <div class="ui row" style="margin-top: 2em">
                            <div class="ui input">
                                <input class="ui blue button" name="create" type="submit" value="Create">
                            </div>
                        </div>
                    </form>
                </div>';

            } else {


                $productReviews = getReviews($reviews[$reviewId-1]['review_url']);

                $averageStars = 0;
                $topReviews = array();
                $lowReviews = array();
                $totalReview = 0;
                foreach($productReviews as $review){
                    $averageStars = $averageStars + $review['rating'];
                    if($review['rating'] == 5){
                        array_push ( $topReviews , $review );
                    }
                    if($review['rating'] == 1){
                        array_push ( $lowReviews , $review );
                    }
                    $totalReview = $totalReview + 1;
                }

                echo '
                    <div class="ui two column grid" style="margin-top: 5em">
                        <div class="sixteen wide column">
                        <div class="ui huge header" style="color: white">'.$reviews[$reviewId-1]['review_name'].'</div>
                        <div class="ui big header" style="color: white">This Product averages approximately '.round($averageStars/$totalReview).' <i class=" yellow star icon"></i></div>
                        </div>
                            <div class="four column row">
                                <div class="eight wide column">
                                <div class="ui left aligned header" style="color: white">Reviews rated 1 <i class=" yellow star icon"></i></div>
                                    <div class="ui feed">';
                                            foreach($lowReviews as $lreview){
                                                echo '<div class="event">
                                                        <div class="content">
                                                          <div class="summary" style="color: white">
                                                            <a>'.$lreview['user_name'].'</a> posted a review on date :  
                                                            <div class="date" style="color: white">
                                                              '.$lreview['timestamp'].'
                                                            </div>
                                                          </div>
                                                          <div class="extra text" style="color: white">
                                                             '.$lreview['text'].'  
                                                           </div>
                                                        </div>
                                                      </div>';
                                            }
                                            echo '
                                      </div> 
                                </div>
                        <div class="eight wide column">
                                <div class="ui left aligned header" style="color: white">Reviews rated 5 <i class=" yellow star icon"></i></div>
                            <div class="ui feed">';
                                foreach($topReviews as $treview){
                                    echo '<div class="event">
                                               <div class="content">
                                                   <div class="summary" style="color: white">
                                                        <a>'.$treview['user_name'].'</a> posted a review on date :  
                                                            <div class="date" style="color: white">
                                                                '.$treview['timestamp'].'
                                                            </div>
                                                   </div>
                                                   <div class="extra text" style="color: white">
                                                        '.$treview['text'].'  
                                                   </div>
                                                   </div>
                                          </div>';
                                }
                            echo '     
                            </div>
                        </div>
                    </div>';


                                }

            ?>
        </div>
    </div>

</div>
</body>




<?php

function getReviews($url){
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);

    $data = [
        "url" => $url,
        "amount" => "20",
    ];

    curl_setopt($ch, CURLOPT_URL, "https://app.reviewapi.io/api/v1/reviews?" . http_build_query($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "apikey: ba5ffd40-9e10-11eb-8d9c-8d58fde5b1d6",
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($response, true);
    return $json['reviews'];
}