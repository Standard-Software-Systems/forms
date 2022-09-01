<?php 
    require("config.php");
    require("resources.php");
    require("session.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - <?php echo $siteInfo['siteName'] ?></title>
    <meta name="description" content="<?php echo $siteInfo['siteDescription'] ?>">
    <link rel="icon" type="image/png" href="<?php echo $siteInfo['siteLogo'] ?>">
	<script src="https://kit.fontawesome.com/eb544e6cc4.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>  
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script type="text/javascript" src="assets/js/main.js" defer></script>
    <link rel="stylesheet" type="text/css" href="assets/css/main.css" />
	<meta name="theme-color" content="<?php echo $siteInfo['siteThemeColor'] ?>">
	<meta property="og:url" content="<?php echo $domain ?>">
	<meta property="og:title" content="Home - <?php echo $siteInfo['siteName'] ?>">
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
            <a class="navbar-brand" href=""><img src="<?php echo $siteInfo['siteLogo'] ?>" class='siteImg' alt=""><?php echo $siteInfo['siteName'] ?></a>
            <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="./">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="creator">Create Form</a>
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
    <hr style='color: white'>

    <div class="container text-white text-center" style="margin-top: 10vh">
        <h3>Welcome to <?php echo $siteInfo['siteName'] ?></h3>
        <p style='font-size: 2vh'><?php echo $siteInfo['siteDescription'] ?></p>
        <hr style="width: 100%; margin: auto;" class="mb-4">
        <!-- <div class="images align-items-center justify-content-center mx-auto">
            <img src="https://cdn.discordapp.com/attachments/999090891631382620/1014647042116681788/unknown.png" alt="pic1" style="margin-right: 30%;">
            <img src="https://cdn.discordapp.com/attachments/999090891631382620/1014647044213833888/unknown.png" alt="pic2">
        </div> -->
        <a href="creator" class="gSBtn">Get Started</a>
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
            <a href="account" style="text-decoration: none;" class="text-white"><button class='oBtns text-white mb-3' style="border: none; background: blue;"><i class="fa-solid fa-gear text-white" style="padding-right: 6px;"></i>Account</button></a>
            <form method="post">
                <button type="submit" name="logout" class='oBtns text-white mb-3' style="border: none; background: red;"><i class="fa-solid fa-arrow-right-from-bracket text-white" style="padding-right: 4px;"></i>Logout</button>
            </form>
        </div>
        <div class="modal-footer">
        </div>
        </div>
    </div>
    </div>

    <?php include_once("_footer.php") ?>
</body>
</html>
