
<?php session_start();

include "databaseSetUp.php";

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
            <a class="item" href=<?php if(isset($_COOKIE['username'])){echo "reviews.php";}else {echo "login.php";}?>>Reviews</a>
            <a class="item" href="about.php">About</a>
        </div>
        </div>
    </div>
    <div class="ui content container" style="margin-top: 5em">
        <div class="ui inverted header" style="font-size: 45px">Welcome to ReviewSniper</div>
        <p style="width: 70%; margin-left: auto;margin-right: auto;font-size: 25px;margin-top: 3em">
            ReviewSniper is a project that came to our mind for a school assignment. With this website,
            you can gather your reviews about specific products or services. We analyze your reviews with
            a home made algorithm to display useful statistics</p>

        <a class="ui blue button" href=<?php if(isset($_COOKIE['username'])){echo "reviews.php";}else {echo "login.php";}?> style="font-size: 25px;margin-top: 3em">Start gathering review statistics now</a>
    </div>

    <footer style="margin-top:20em;opacity: 25%">ReviewSniper by Olivier Lemire, Jon Ma, Tuan Nguyen</footer>
</div>