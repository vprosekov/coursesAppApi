<?php
    if (!count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS))) {//проверка родительского файла
        exit();
    }
    
    if(isset($_GET["phone"])){
        $phone = $_GET["phone"];
        if(!is_numeric($phone)){
            echo "{
                \"status\": $enabled,
                \"error\": \"phoneError\",
                \"help\": \"Full documentation on \"http://$_SERVER[HTTP_HOST]/api.php?request=help\"\"
            }";
            exit();
        }
        
        $smsCode = rand(1000,9999);
        
        /*
            отправка смс
        */

        $query="INSERT INTO `tempUsers` (`phone`, `smsCode`) VALUES ($phone, $smsCode)";
        if(!sendQuery($query)){
            $query="UPDATE `tempUsers` SET `smsCode`= $smsCode WHERE `phone`=$phone";
            if(!sendQuery($query)){
                //echo $smsCode;
                echo "{
                    \"status\": false,
                    \"extra\": \"db error\"
                }";
                exit();
            }
        }
        
        echo "{
            \"status\": $enabled,
            \"extra\": \"smsCode sent to $phone\"
        }";
        exit();
    }
    else{
        echo "{
            \"status\": $enabled,
            \"error\": \"noPhone\",
            \"help\": \"Full documentation on \"http://$_SERVER[HTTP_HOST]/api.php?request=help\"\"
        }";
    }
    exit();
?>