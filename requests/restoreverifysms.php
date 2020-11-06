<?php
    if (!count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS))) {//проверка родительского файла
        exit();
    }
    
    if(isset($_GET["smscode"]) && isset($_GET["phone"]) && isset($_GET["password"])){
        $smsCode = $_GET["smscode"];
        $phone = $_GET["phone"];
        $password = $_GET["password"];
        
        $fb = sendSelectQuery("SELECT `phone` FROM `users` WHERE `phone`=$phone");
        
        if($fb && $fb[0]["phone"]!="")
        {
            if($smsCode != sendSelectQuery("SELECT `smsCode` FROM `tempUsers` WHERE `phone`=$phone")[0]["smsCode"]){
                echo "{
                    \"status\": $enabled,
                    \"error\": \"wrongSms\",
                    \"help\": \"Full documentation on \"http://$_SERVER[HTTP_HOST]/api.php?request=help\"\"
                }";
                exit();
            }

            $apiKey = implode('', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 20), 6));
            
            if(sendQuery("UPDATE `users` SET `password`='".md5($password)."', `apiKey`='$apiKey' WHERE `phone` = $phone")){
                if(!sendQuery("UPDATE `tempUsers` SET `smsCode`=NULL WHERE `phone` = $phone")){
                    echo "{
                        \"status\": false
                    }";
                    exit();
                }
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