<?php 
    require("../config.php");
    require("../resources.php");
    require("../session.php");
    if(!isset($_SESSION['id'])) {
        ?>
        <form method="post" id="loginForm">
            <input type="hidden" name="login">
        </form>
        <script>
          window.onload = () => {  
          document.getElementById("loginForm").submit();
          }
        </script>
        <?php 
    }
    if(isset($_GET['id'])) {
        $sql7 = "SELECT * FROM submissions WHERE id = :id LIMIT 1";
        $check = $connection->prepare($sql7);
        $check->execute(
            array(
                "id" => $_GET['id'],
            )
        );
        $count1 = $check->rowCount();
        if($count1 < 1) {
            echo "Invalid sub id";
        // header("Location: ../");
        }
        $sql8 = "SELECT * FROM forms WHERE id = :id LIMIT 1";
        $check1 = $connection->prepare($sql8);
        $sub = $check->fetch(PDO::FETCH_ASSOC);    
        $check1->execute(
            array(
                "id" => $sub['formId'],
            )
        );
        $form = $check1->fetch(PDO::FETCH_ASSOC);    
        if($_SESSION['id'] !== $sub['userid']) {
            if($_SESSION['id'] !== $form['userid']) {
                header("Location: ../");
            }
        }
        $isStaff = false;
        if($_SESSION['id'] === $form['userid']) {
            $isStaff = true;
        }
        $questions = $db->query("SELECT * FROM questions WHERE formId = '{$form['id']}'");
        $replies = $db->query("SELECT * FROM replies WHERE subId = '{$sub['id']}'");
        $answers = $db->query("SELECT * FROM answers WHERE formId = '{$form['id']}'");
        $ans = [];
        $curr = 0;
        while($a = $answers->fetch_assoc()) {
            $ans[$curr] = $a['answer'];
            $curr++;
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> - <?php echo $siteInfo['siteName'] ?></title>
    <meta name="description" content="<?php echo $siteInfo['siteDescription'] ?>">
    <link rel="icon" type="image/png" href="<?php echo $siteInfo['siteLogo'] ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://kit.fontawesome.com/eb544e6cc4.js" crossorigin="anonymous"></script>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Qwitcher+Grypen&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>  
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../assets/js/main.js" defer></script>
    <link rel="stylesheet" type="text/css" href="../assets/css/main.css" />
	<meta name="theme-color" content="<?php echo $siteInfo['siteThemeColor'] ?>">
	<meta property="og:url" content="<?php echo $domain ?>">
	<meta property="og:title" content="Form Creator - <?php echo $siteInfo['siteName'] ?>">
	<meta property="og:description" content="<?php echo $siteInfo['siteDescription'] ?>">
	<meta property="og:image" content="<?php echo $siteInfo['siteLogo'] ?>">
</head>
<body>
    <style>
        body,html {
            background-image: url('<?php echo $siteInfo['siteBackground'] ?>');
        }
        :root {
            --main-color: <?php echo $siteInfo['siteThemeColor'] ?>
        }
    </style>
    
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="../"><img src="<?php echo $siteInfo['siteLogo'] ?>" class='siteImg' alt=""><?php echo $siteInfo['siteName'] ?></a>
            <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="../">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="../creator">Create Form</a>
                </li>
                <!-- <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Applications
                </a>
                <ul class="dropdown-menu bg-dark text-white">
                    <li><a class="dropdown-item" href="#">App name</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">App name</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">App name</a></li>
                    <li><hr class="dropdown-divider"></li> 
                </ul>
                </li> -->
            </ul>
            <div class="d-flex userInfo">
                <?php if(isset($_SESSION['id'])) {?>
                <button class="userBtn" data-bs-toggle="modal" data-bs-target="#userModal" type="button"><i class="fa-solid fa-user-gear"></i></button>
                <?php } else { ?>
                <form method="POST">
                    <button type="submit" name="login" class="loginBtn">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    </button>
                </form>
                <?php } ?>
            </div>
            </div>
        </div>
    </nav>

    <div class="container text-white mx-auto" id="creatorCon">
        <div class="form mx-auto text-center">
            <div class="formHead" style="border-bottom: 1px solid white; margin-bottom:20px">
                <h2><?php echo $form['formName'] ?></h2>
                <p id="saveFormErrorText" style="color: red"></p>
                <div class="userInfoForm">
                    <img src="<?php echo $_SESSION['avatar'] ?>" alt="User Avatar">
                    <span>Submitter: <?php echo $_SESSION['username']."#". $_SESSION['discriminator'] ?></span>
                </div>
            </div>
                    <?php
                        if ($questions->num_rows > 0) {
                            $curr2 = 0;
                            while($q = $questions->fetch_assoc()) { ?>
                                    <div class="mb-3">
                                    <label for="q" class="form-label"><?php echo $q['question'] ?></label><br>
                                    <input type="text" name="answers[]" class="bg-transparent inputField" id="q" placeholder="Enter an answer..." disabled value="<?php echo $ans[$curr2] ?>">
                                </div>
                            <?php $curr2++; } ?>

                     <?php } ?>
                     <br>
                     <?php if($isStaff === true) { ?>
                    <div class="staffStatus" style="border-top: 1px solid white;">
                        <form id="subForm">
                            <div class="mb-3 mt-3">
                                <label for="status" class="fomr-label">Update the submissions status</label><br>
                                <select name="status" id="status" class="typeSelect">
                                    <option value="recieved" <?php if ($sub['status'] == "recieved") {  ?> selected <?php } else { }  ?>>Recieved</option>
                                    <option value="pending" <?php if ($sub['status'] == "pending") {  ?> selected <?php } else { }  ?>>Pending</option>
                                    <option value="accept" <?php if ($sub['status'] == "accept") {  ?> selected <?php } else { }  ?>>Accept</option>
                                    <option value="deny" <?php if ($sub['status'] == "deny") {  ?> selected <?php } else { }  ?>>Deny</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <button type="submit" id="saveBtn" style="width: 30%;">Save</button>
                            </div>
                        </form>
                    </div>
                    <?php } ?>
                    <div class="replyHead" style="border-bottom: 1px solid white;"><h4 class="mt-3 mb-2" style="margin-top: 5px; margin-bottom: 10px;">Replies</h4></div>
                    <div id="replies1" class="replies mt-3 d-block">
                    <!-- <img style="width: 3.6em; height: 3.6em; display: inline-block; margin-right: 1em; border-radius: 50%; vertical-align: middle;" src="<?php echo $_SESSION['avatar'] ?>"> -->
                        <!-- <?php
                    if($replies->num_rows < 1) {
                        echo "No replies...";
                        // echo "<br>";     
                         } else {
                        while($reply = $replies->fetch_assoc()) { 
                            $userI = $db->query("SELECT * FROM users WHERE discordID = '{$reply['userid']}' LIMIT 1");
                            if($userI->num_rows > 0) {
                                $userI = $userI->fetch_assoc();
                            ?>
                        <div class="reply">
                        <span style="font-size: 1em; margin-top:5px">By: <a target="_blank" href="https://discord.com/users/<?php echo $userI['discordID'] ?>" style="text-decoration: none; "><?php echo $userI['name'] ?></a>  <span style="color: <?php echo $siteInfo['siteThemeColor'] ?>"></span>| <span style="color: <?php echo $siteInfo['siteThemeColor'] ?>; font-size: 14px;"><?php echo $reply['date'] ?></span></span>
                        <br>
                        <p id="text02"><?php echo $reply['reply'] ?></p>
                        </div> -->
                        <!-- <span style="font-size: 1em; margin-top:5px">By: <a href="https://discord.com/users/<?php echo $userI['discordID'] ?>" style="text-decoration: none;"><?php echo $userI['name'] ?></a> (<code style="font-size: .7em; vertical-align: middle;  margin-top:5px; color: <?php echo $siteInfo['siteThemeColor'] ?>"><?php echo $userI['discordID'] ?></code>) <span style="color: <?php echo $siteInfo['siteThemeColor'] ?>">|</span> </span>
                        <div class="info" style="display:inline;">
                            <p id="text03" style=""><?php echo $reply['date'] ?></p>
                            <p id="text02"><?php echo $reply['reply'] ?></p>    
                        </div>
                        <hr id="divider02">
                        <br> -->
                    <!-- <?php }
                        }
                    }
                ?> -->

                </div>
                <div class="sendReply mt-3" style="border-top: 1px solid white;">
                    <form id="replyForm">
                        <div class="mb-3 mt-5">
                            <p id="sendReplyErrorText" style="color: red"></p>
                            <textarea type="text" class="inputField bg-transparent" name="rep" id="rep" placeholder="Send a reply" style="margin-bottom: 15px; height: 4em"></textarea>
                            <button type="submit" id="repBtn">Send</button>
                        </div>
                    </form>
                </div>
        </div>
    </div>                
    

    <!-- Modals -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Account Options</h5>
            <button type="button" class="bg-transparent" data-bs-dismiss="modal" aria-label="Close" style="border: none;"><i class="fa-solid fa-x" style="color: white; font-size: 2.5vh"></i></button>
        </div>
        <div class="modal-body">
            <div class="info">
                <img src="<?php echo $_SESSION['avatar'] ?>" alt="User Image"><br>
                <span><?php echo $_SESSION['username'] . '#' . $_SESSION['discriminator'] ?></span>
            </div>
            <a href="../account" style="text-decoration: none;" class="text-white"><button class='oBtns text-white mb-3' style="border: none; background: blue;"><i class="fa-solid fa-gear text-white" style="padding-right: 6px;"></i>Account</button></a>
            <form method="post">
                <button type="submit" name="logout" class='oBtns text-white mb-3' style="border: none; background: red;"><i class="fa-solid fa-arrow-right-from-bracket text-white" style="padding-right: 4px;"></i>Logout</button>
            </form>
        </div>
        <div class="modal-footer">
        </div>
        </div>
    </div>
    </div>
    <script>
    $("html, body").animate({ scrollTop: 9000 }, 600);
    </script>
        <?php include_once("../_footer.php") ?>
</body>
</html>
