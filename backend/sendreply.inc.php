<?php
    require("../config.php");
    require("../resources.php");
    require("../session.php");
    if(!isset($_SESSION['id'])) {
        header("Location: ../");
    }
    if(!isset($_POST['rep'])) {
        $json = [
            "error" => true,
            "message" => "All inputs must be filled out.",
        ];
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        
        echo json_encode($json);
    } else {
        if(!isset($_GET['id'])) {
            header("Location: ../");
        }
        if(!empty($_POST['rep'])){
            $id = $_GET['id'];
            $date = date("F j, Y, g:i a");
            $sql2 = "SELECT * FROM submissions WHERE id = :id";
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
                $save = $db->prepare("INSERT INTO replies (subId, userid, reply, date) VALUES (?, ?, ?, ?)");
                $save->bind_param("ssss", $id, $_SESSION['id'], $_POST['rep'], $date);
                $save->execute();
                $json = [
                    "error" => false,
                    "message" => "Sent",
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