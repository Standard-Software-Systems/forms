<?php
    require("../config.php");
    require("../resources.php");
    require("../session.php");
    $questions = $db->query("SELECT * FROM questions WHERE formId = '{$_GET['formId']}'");
    $id = createSubId();
    $curr5 = 0;
    $qs = [];
    $names = [];
    while($q = $questions->fetch_assoc()) {
        $qs[$curr5] = $q['id'];
        $names[$curr5] = $q['question'];
        $curr5++;
    }

    if(!isset($_SESSION['id'])) {
        header("Location: ../");
    }
    if(!isset($_POST['answers'])) {
        $json = [
            "error" => true,
            "message" => "All inputs must be filled out.",
        ];
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        
        echo json_encode($json);

    } else {
        if(!isset($_GET['formId'])) {
            header("Location: ../");
        }
        if(!empty($_POST['answers'])){

                $sql9 = "INSERT INTO submissions (id, formId, userid, status, replies, date) VALUES (:id, :formId, :userId, 'recieved', 'none', :date)";
                $insertBruh = $connection->prepare($sql9);
                $insertBruh = $insertBruh->execute(
                    array(
                        "id" => $id,
                        "formId" => $_GET['formId'],
                        "userId" => $_SESSION['id'],
                        "date" => date("F j, Y, g:i a"),
                    ),
                );
                $sql11 = "INSERT INTO answers (formId, questionId, answer) VALUES (:fid, :qid, :a)";
                $curr = 0;
                $q = [];
                foreach ($_POST['answers'] as $bruh) {         
                        $insert1 = $connection->prepare($sql11);
                        $insert1 = $insert1->execute(
                        array(
                            "fid" => $_GET['formId'],
                            "qid" => $qs[$curr],
                            "a" => $bruh,
                        ),
                    );
                    $q[$curr] = $bruh;
                    $curr++; 
            }
                $fields = [];
                for($x = 0; $x < count($qs); $x++) {
                    $ar = [
                        "name" => $names[$x],
                        "value" => $q[$x],
                        "inline" => false
                    ];
                    array_push($fields, $ar);
                };
                $timestamp = date("c", strtotime("now"));
                $query = "SELECT * FROM forms WHERE id = :id";
                $form = $connection->prepare($query);
                $form->execute(
                    array(
                        "id" => $_GET['formId'],
                    ),
                );
                $count = $form->rowCount();
                if($count > 0) {
                    $curr2 = 0;
                    $form = $form->fetch(PDO::FETCH_ASSOC);  
                    $pjson = [
                            "error" => false,
                            "message" => "Form successfully submitted.",
                            "id" => $id,
                        ];
                        header('Access-Control-Allow-Origin: *');
                        header('Content-Type: application/json');
            
                        echo json_encode($pjson);
                    $json = json_encode([
                    "username" => $form['formName'] . " - New Submission",
                    "avatar_url" => $siteInfo['siteLogo'],
                    "embeds" => [
                        [
                            "title" => $_SESSION['username'],
                            "type" => "rich",
                            "url" => str_replace("/backend/submitform.inc.php?formId=".$_GET['formId'], "", $domain)."/submissions?subId=".$id,
                            "timestamp" => $timestamp,
                            "footer" => [
                                "icon_url" => $siteInfo['siteLogo'],
                            ],
                            "fields" => $fields,
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
            $pjson = [
                "error" => true,
                "message" => "All inputs must be filled out.",
            ];
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');

            echo json_encode($pjson);

        }
    }
?>