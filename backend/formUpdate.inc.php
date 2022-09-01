<?php
    require("../config.php");
    require("../resources.php");
    require("../session.php");
    if(!isset($_SESSION['id'])) {
        header("Location: ../");
    }
    if(!isset($_POST['webhook'])) {
        $json = [
            "error" => true,
            "message" => "All inputs must be filled out.",
        ];
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        
        echo json_encode($json);
    } else {
        if(!isset($_POST['id'])) {
            header("Location: ../");
        }
        if(!empty($_POST['webhook'])){
            $id = $_POST['id'];
            $date = date("F j, Y, g:i a");
            $sql2 = "SELECT * FROM forms WHERE id = :id";
            $update = $connection->prepare($sql2);
            $update->execute(
                array(
                    "id" => $id,
                ),
            );
            $count = $update->rowCount();
            if($count < 1) {
                $json = [
                    "error" => true,
                    "message" => "Invalid Submission Id",
                ];
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/json');
    
                echo json_encode($json);
            } else {
                $save = $db->prepare("UPDATE forms SET webhook = ? WHERE id = ?");
                $save->bind_param("ss", $_POST['webhook'], $id);
                $save->execute();
                $json = [
                    "error" => false,
                    "message" => "Updated",
                ];
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/json');
    
                echo json_encode($json);
            }
        } else {
            $json = [
                "error" => true,
                "message" => "All inputs must be filled out.",
            ];
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');

            echo json_encode($json);
        }
    }
?>