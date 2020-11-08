<?php
    if (!count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS))) {//проверка родительского файла
        exit();
    }
    
    if(isset($_GET["email"]) && isset($_GET["password"])){
        $email = $_GET["email"];
        $password = md5($_GET["password"]);

        if(strpos($email, '@') == false){
            echo "{
                \"status\": $enabled,
                \"error\": \"emailError\",
                \"help\": \"Full documentation on \"http://$_SERVER[HTTP_HOST]/api.php?request=help\"\"
            }";
            exit();
        }
        
        $fb = sendSelectQuery("SELECT `apiKey` FROM `users` WHERE `email`='$email' AND `password`='$password'");
        //print_r($fb);
        if(!$fb || $fb[0]["apiKey"]=="")
        {
            echo "{
                \"status\": $enabled,
                \"error\": \"userNotExists\",
                \"help\": \"Full documentation on \"http://$_SERVER[HTTP_HOST]/api.php?request=help\"\"
            }";
            exit();
        }
        else //все норм
        {
            $apiKey = $fb[0]["apiKey"];
            echo "{
                \"status\": $enabled,
                \"apiKey\": \"$apiKey\"
            }";
            exit();
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