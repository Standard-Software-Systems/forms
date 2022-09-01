<?php
    require("../config.php");
    require("../resources.php");
    require("../session.php");
    if(!isset($_SESSION['id'])) {
        header("Location: ../");
    }
    if(!isset($_POST['formName']) && !isset($_POST['formDesc']) && !isset($_POST['question'][0]) && !isset($_POST['formWebhook'])) {
        $json = [
            "error" => true,
            "message" => "All inputs must be filled out.",
        ];
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        
        echo json_encode($json);
    } else {
        if(!empty($_POST['formName']) && !empty($_POST['formDesc']) && !empty($_POST['question'][0]) && !empty($_POST['formWebhook'])){
            $name = $_POST['formName'];
            $desc = $_POST['formDesc'];
            $questions = $_POST['question'];
            $webhook = $_POST['formWebhook'];
            $date = date("F j, Y, g:i a");
            $id = createPasteID();
            if(preg_match('/https:\/\/discord.com\/api\/webhooks\//', $webhook)) {
                $sql9 = "INSERT INTO forms (id, userid, formName, formDescription, date, webhook) VALUES (:id, :userid, :name, :desc, :date, :webhook)";
                $insertBruh = $connection->prepare($sql9);
                $insertBruh = $insertBruh->execute(
                    array(
                        "id" => $id,
                        "userid" => $_SESSION['id'],
                        "name" => $name,
                        "desc" => $desc,
                        "date" => $date,
                        "webhook" => $webhook,
                    ),
                );
                $sql11 = "INSERT INTO questions (formId, question, type, options) VALUES (:id, :q, :t, :o)";
                $curr = 0;
                $optionCurr = 0;
                foreach ($_POST['question'] as $bruh) {
                    $type = $_POST['type'][$curr] === "input" ? 0 : 1;
                    $option = $type === 1 ? $_POST['options'][$optionCurr] : "none";
                    $i = $connection->prepare($sql11);
                    $i = $i->execute(
                        array(
                            "id" => $id,
                            "q" => $bruh,
                            "t" => $type,
                            "o" => $option,
                        ),
                    );
                    $curr++;
                    if($option === "none") {

                    } else {
                        $optionCurr++;
                    }
                }
                $json = [
                    "error" => false,
                    "message" => "Form succesfully created. You will be redirected to the form in 5 seconds.",
                    "id" => $id,
                ];
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/json');
    
                echo json_encode($json);
                die();
            } else {
                $json = [
                    "error" => true,
                    "message" => "The webhook provided is invalid.",
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