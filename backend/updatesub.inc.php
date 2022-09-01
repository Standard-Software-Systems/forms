<?php
    require("../config.php");
    require("../resources.php");
    require("../session.php");
    if(!isset($_SESSION['id'])) {
        header("Location: ../");
    }
    if(!isset($_POST['status'])) {
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
        if(!empty($_POST['status'])){
            $status = $_POST['status'];
            $status1;
            if($status === "recieved") {
                $status1 = "Recieved";
            } else if($status === "accept") {
                $status1 = "Accepted";
            } else if($status === "deny") {
                $status1 = "Denied";
            } else if($status === "pending") {
                $status1 = "Pending";
            }
            $id = $_GET['id'];
            $sql2 = "SELECT * FROM submissions WHERE id = :id";
            $update = $connection->prepare($sql2);
            $update->execute(
                array(
                    "id" => $id,
                ),
            );
            $count = $update->rowCount();
            $update = $update->fetch(PDO::FETCH_ASSOC);
            if($count < 1) {
                $json = [
                    "error" => true,
                    "message" => "Invalid Submission Id",
                ];
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/json');
    
                echo json_encode($json);
            } else {
                $form = $connection->prepare("SELECT * FROM forms WHERE id = :id");
                $form->execute(
                    array(
                        "id" => $update['formId'],
                    ),
                );
                $form = $form->fetch(PDO::FETCH_ASSOC);
                $save = $db->prepare("UPDATE submissions SET status = ? WHERE id = ?");
                $save->bind_param("ss", $status, $id);
                $save->execute();
                $timestamp = date("c", strtotime("now"));
                $json = [
                    "error" => false,
                    "message" => "Updated",
                ];
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/json');
    
                echo json_encode($json);
                $json = json_encode([
                    "username" => $form['formName'] . " - Updated Submission",
                    "avatar_url" => $siteInfo['siteLogo'],
                    "embeds" => [
                        [
                            "type" => "rich",
                            "description" => "The submission [" . $id . "](" . str_replace("/backend/updatesub.inc.php?id=".$id, "", $domain)."/submissions?subId=".$id . ") has been updated.\n\nUpdated By: `" . $_SESSION['username'] . "`\n\n**Status**: `" . $status1 . "`\n_To view replies please click [here](" . str_replace("/backend/updatesub.inc.php?id=".$id, "", $domain)."/submissions?subId=".$id . ")_",                            
                            "timestamp" => $timestamp,
                        ],
                    ],
                ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

                $ch = curl_init($form['webhook']);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                
                $response = curl_exec($ch);
                curl_close($ch);
                
                return $response;

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