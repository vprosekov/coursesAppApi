<?php
    if (!count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS))) {//проверка родительского файла
        exit();
    }
    
    if(isset($_GET["apikey"]) && isset($_GET["name"]) && isset($_GET["city"])){
        $apiKey = $_GET["apikey"];
        $name = $_GET["name"];
        $city = $_GET["city"];
        
        $fb = sendSelectQuery("SELECT `id` FROM `users` WHERE apiKey='$apiKey'");
        //print_r($fb);
        if(!$fb || $fb[0]["id"]=="")
        {
            echo "{
                \"status\": $enabled,
                \"error\": \"apiNotExists\",
                \"help\": \"Full documentation on \"http://$_SERVER[HTTP_HOST]/api.php?request=help\"\"
            }";
            exit();
        }
        else //все норм
        {
            if(sendQuery("UPDATE `users` SET `name`='$name', `city`='$city' WHERE `apiKey` = '$apiKey'")){
                echo "{
                    \"status\": $enabled
                }";
                exit();
            }
            else{
                echo "{
                    \"status\": false
                }";
                exit();
            }
        }

    }
    else if(isset($_GET["apikey"]) && isset($_GET["name"])){
        $apiKey = $_GET["apikey"];
        $name = $_GET["name"];
        
        $fb = sendSelectQuery("SELECT `id` FROM `users` WHERE apiKey='$apiKey'");
        //print_r($fb);
        if(!$fb || $fb[0]["id"]=="")
        {
            echo "{
                \"status\": $enabled,
                \"error\": \"apiNotExists\",
                \"help\": \"Full documentation on \"http://$_SERVER[HTTP_HOST]/api.php?request=help\"\"
            }";
            exit();
        }
        else //все норм
        {
            if(sendQuery("UPDATE `users` SET `name`='$name' WHERE `apiKey` = '$apiKey'")){
                echo "{
                    \"status\": $enabled
                }";
                exit();
            }
            else{
                echo "{
                    \"status\": false
                }";
                exit();
            }
        }

    }
    else if(isset($_GET["apikey"]) && isset($_GET["city"])){
        $apiKey = $_GET["apikey"];
        $city = $_GET["city"];
        
        $fb = sendSelectQuery("SELECT `id` FROM `users` WHERE apiKey='$apiKey'");
        //print_r($fb);
        if(!$fb || $fb[0]["id"]=="")
        {
            echo "{
                \"status\": $enabled,
                \"error\": \"apiNotExists\",
                \"help\": \"Full documentation on \"http://$_SERVER[HTTP_HOST]/api.php?request=help\"\"
            }";
            exit();
        }
        else //все норм
        {
            if(sendQuery("UPDATE `users` SET `city`='$city' WHERE `apiKey` = '$apiKey'")){
                echo "{
                    \"status\": $enabled
                }";
                exit();
            }
            else{
                echo "{
                    \"status\": false
                }";
                exit();
            }
        }

    }
    else{
        echo "{
            \"status\": $enabled,
            \"error\": \"noData\",
            \"help\": \"Full documentation on \"http://$_SERVER[HTTP_HOST]/api.php?request=help\"\"
        }";
        exit();
    }
    
?>