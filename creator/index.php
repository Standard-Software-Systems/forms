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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Creator - <?php echo $siteInfo['siteName'] ?></title>
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
        <div class="creator-form">
            <form id="createForm1">
                <div class="form-head mb-4" style="border-bottom: 1.5px solid white;">
                    <h3 class="text-center">Form Creator</h3>
                    <p id="createFormErrorText" class="text-center" style="color: red"></p>
                    <p id="createFormSuccessText" class="text-center" style="color: green"></p>
                </div>
                <div class="row g-3" style="border-bottom: 1px solid white;">
                    <div class="col-md-1"></div>
                    <div class="col-md-3 mb-4" id="formName1">
                    <label for="formName" class="form-label" style="margin-bottom: -10px">Form Name</label><br>
                    <input type="text" class="bg-transparent" id="formName" name="formName" style="border: 1px solid white; outline: none; border-radius: 3px; color: white; padding: .3vh 1vh; margin-top: -10px;">
                </div>
                <div class="col-md-3 mb-2 mx-auto" id="formDesc1">
                    <label for="formDesc" class="form-label">Form Description</label><br>
                    <textarea type="text" class="bg-transparent" id="formDesc" name="formDesc" rows="2" cols="30" style="border: 1px solid white; outline: none; border-radius: 3px; color: white; padding: .3vh 1vh; margin-top: -15px;"></textarea>
                </div>
                <div class="col-md-4 mb-3 mx-auto" id="formWeb1">
                    <label for="formWebhook" class="form-label">Form Discord Webhook</label><br>
                    <textarea type="text" class="bg-transparent" id="formWebhook" name="formWebhook" rows="2" cols="35" style="height: 55px;border: 1px solid white; outline: none; border-radius: 3px; color: white; padding: .3vh 1vh; font-size: 12px; margin-top: -15px;"></textarea>
                </div>
            </div>
                <div class="mt-4" style="margin: auto;">
                        <div id="questions" style="margin: auto; justify-content: center; align-items: center">
                            <div class="mb-3">
                                <label for="questionName" class="form-label text-center">Question 1</label><br>
                                <input type="text" class="bg-transparent inputField" id="question" name="question[]"  placeholder="Enter a question..." style="" required></input>
                                <select name="type[]" id="typeSelect" class="typeSelect" onchange="getval(this);">
                                    <option value="input">Input Field</option>
                                    <option value="select">Select Menu</option>
                                </select>
                            </div>
                        </div>
                        <br>  
                        <div class="mb-3">
                            <button id="addQuestions" class="mb-3 " onclick="addQuestion();">Add Question</button>
                            <button id="addQuestions" onclick="removeQuestion();">Remove Question</button>
                        </div>
                            
                    </div> 
                <div class="row g-3 mt-4" style="border-top: 1px solid white;">
                    <button type="submit" name="createForm" class="createBtn mt-4">Create Form</button>
                </div>
             </form>
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
    <?php include_once("../_footer.php") ?>
</body>
</html>
