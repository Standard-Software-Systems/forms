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
    $submissions = $connection->prepare("SELECT * FROM submissions WHERE userid = :userid");
    $submissions->execute(
        array(
            "userid" => $_SESSION['id'],

        ),
    );
    $forms = $connection->prepare("SELECT * FROM forms WHERE userid = :userid");
    $forms->execute(
        array(
            "userid" => $_SESSION['id'],

        ),
    );

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account - <?php echo $siteInfo['siteName'] ?></title>
    <meta name="description" content="<?php echo $siteInfo['siteDescription'] ?>">
    <link rel="icon" type="image/png" href="<?php echo $siteInfo['siteLogo'] ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://kit.fontawesome.com/eb544e6cc4.js" crossorigin="anonymous"></script>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>  
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../assets/js/main.js" defer></script>
    <link rel="stylesheet" type="text/css" href="../assets/css/main.css" />
	<meta name="theme-color" content="<?php echo $siteInfo['siteThemeColor'] ?>">
	<meta property="og:url" content="<?php echo $domain ?>">
	<meta property="og:title" content="Account - <?php echo $siteInfo['siteName'] ?>">
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
        <div class="submissions">
            <div class="subHeader mb-4" style="border-bottom: 1px solid white;">
                <h3>Submissions</h3>
            </div>
        <div class="customDiv">
        <table class="table table-striped text-white" style="border: 1px solid white;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Application</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    while($row = $submissions->fetch(PDO::FETCH_ASSOC)){
                        $thisForm = $connection->prepare("SELECT * FROM forms WHERE id = :id LIMIT 1");
                        $thisForm->execute(
                            array(
                                "id" => $row['formId'],
                            ),
                        );
                        $thisForm = $thisForm->fetch(PDO::FETCH_ASSOC);
                        $status1;
                        $status = $row['status'];
                        if($status === "recieved") {
                            $status1 = "Recieved";
                        } else if($status === "accept") {
                            $status1 = "Accepted";
                        } else if($status === "deny") {
                            $status1 = "Denied";
                        } else if($status === "pending") {
                            $status1 = "Pending";
                        }
                ?>
                    <tr class="text-white">
                        <td class="text-white"><?php echo $row['id'] ?></td>
                        <td class="text-white"><?php echo $thisForm['formName'] ?></td>
                        <td class="text-white"><?php echo $status1 ?></td>
                        <td class="text-white">
                            <a href="../submissions/index.php?id=<?php echo $row['id'] ?>" style="text-decoration: none;">View</a>
                        </td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>
        </div>
      </div>
      <div class="forms mt-5">
    <div class="formHeader mb-3" style="border-bottom: 1px solid white;">
        <h3>Forms</h3>
        </div>
        <div class="customDiv">
        <table class="table table-striped text-white" style="border: 1px solid white;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Webhook</th>
                    <th>Date</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    while($f = $forms->fetch(PDO::FETCH_ASSOC)){
                    $string = strlen($f['webhook']) <= 60 ? $f['webhook'] : substr($f['webhook'], 0, 60) . "...";
                ?>
                    <tr class="text-white">
                        <form id="webhookUpdate">
                        <td class="text-white"><?php echo $f['id'] ?></td>
                        <td class="text-white"><?php echo $f['formName'] ?></td>
                        <td class="text-white" style="">
                        <?php echo $string ?>
                        </td>
                        <td class="text-white"><?php echo $f['date'] ?></td>
                        <td class="text-white">
                            <a style="text-decoration: none;" href="../editor/index.php?id=<?php echo $f['id'] ?>">Edit</a>
                        </td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>
     </div>
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
            <button class='oBtns text-white mb-3' style="border: none; background: blue;"><a href="/account" style="text-decoration: none;" class="text-white"><i class="fa-solid fa-gear text-white" style="padding-right: 6px;"></i>Account</a></button>
            <form method="post">
                <button type="submit" name="logout" class='oBtns text-white mb-3' style="border: none; background: red;"><i class="fa-solid fa-arrow-right-from-bracket text-white" style="padding-right: 4px;"></i>Logout</button>
            </form>
        </div>
        <div class="modal-footer">
        </div>
        </div>
    </div>
    </div>
    <?php include_once("../_footer.php") ?>
</body>
</html>
