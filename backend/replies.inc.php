<?php
    require("../config.php");
    require("../resources.php");
    require("../session.php");
    if(!isset($_SESSION['id'])) {
        header("Location: ../");
    }
    if(!isset($_GET['subId'])) {
        header("Location: ../");
    }
    $output = "";
    $sql = "SELECT * FROM replies WHERE subID = :id";
    $replies = $connection->prepare($sql);
    $replies->execute(
        array(
            "id" => $_GET['subId'],
        ),
    );
    $count = $replies->rowCount();
    if($count < 1) {
        $output = "No replies...";
    }

    while($row = $replies->fetch(PDO::FETCH_ASSOC)) {
        $userI = $db->query("SELECT * FROM users WHERE discordID = '{$row['userid']}' LIMIT 1");
        if($userI->num_rows > 0) {
        $userI = $userI->fetch_assoc();
        $output .= '<div class="reply">
                    <span style="font-size: 1em; margin-top:5px">By: <a target="_blank" href="https://discord.com/users/'. $userI['discordID'] .'" style="text-decoration: none; ">'. $userI['name'] .'</a>  <span style="color: '. $siteInfo['siteThemeColor'] .'"></span>| <span style="color: '. $siteInfo['siteThemeColor'] .'; font-size: 14px;">'. $row['date'] .'</span></span>
                    <br>
                    <p id="text02">'. $row['reply'] .'</p>
                    </div>';
        }
    }
    echo $output;
?>