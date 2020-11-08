<?php
    if (!count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS))) {//проверка родительского файла
        exit();
    }
    
    if(isset($_GET["emailcode"]) && isset($_GET["email"]) && isset($_GET["password"])){
        $emailCode = $_GET["emailcode"];
        $email = $_GET["email"];
        $password = $_GET["password"];
        
        $fb = sendSelectQuery("SELECT `email` FROM `users` WHERE `email`='$email'");
        
        if($fb && $fb[0]["email"]!="")
        {
            if($smsCode != sendSelectQuery("SELECT `emailCode` FROM `tempUsers` WHERE `email`='$email'")[0]["emailCode"]){
                echo "{
                    \"status\": $enabled,
                    \"error\": \"wrongCode\",
                    \"help\": \"Full documentation on \"http://$_SERVER[HTTP_HOST]/api.php?request=help\"\"
                }";
                exit();
            }

            $apiKey = implode('', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 20), 6));
            
            if(sendQuery("UPDATE `users` SET `password`='".md5($password)."', `apiKey`='$apiKey' WHERE `email` = '$email'")){
                sendQuery("UPDATE `tempUsers` SET `emailCode`=NULL WHERE `email` = '$email'");
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
        else {
            echo "{
                \"status\": $enabled,
                \"error\": \"userNotExists\",
                \"help\": \"Full documentation on \"http://$_SERVER[HTTP_HOST]/api.php?request=help\"\"
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