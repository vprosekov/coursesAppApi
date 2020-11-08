<?php
    if (!count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS))) {//проверка родительского файла
        exit();
    }
    
    if(isset($_GET["email"])){
        $email = $_GET["email"];
        if(strpos($email, '@') == false){
            echo "{
                \"status\": $enabled,
                \"error\": \"emailError\",
                \"help\": \"Full documentation on \"http://$_SERVER[HTTP_HOST]/api.php?request=help\"\"
            }";
            exit();
        }
        
        $emailCode = rand(1000,9999);
        
        /*
            отправка email с кодом
        */





        $to = $email;
        $subject = "Регистрация аккаунта";
        
        $message = '<div style="display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        width: 100%;
        height: 10vh;
        -webkit-box-pack: center;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;
        border-style: solid;
        border-width: 1px;
        border-color: #000;
        background-color: #09f;" class="div-block-3"><h1 style ="
        position: static;
        -webkit-align-self: center;
        -ms-flex-item-align: center;
        -ms-grid-row-align: center;
        align-self: center;
        -webkit-box-ordinal-group: 2;
        -webkit-order: 1;
        -ms-flex-order: 1;
        order: 1;
        -webkit-box-flex: 0;
        -webkit-flex: 0 auto;
        -ms-flex: 0 auto;
        flex: 0 auto;" class="heading">Регистрация аккаунта</h1></div>';
        $message .= "<br><h1>Код для подтверждения регистрации аккаунта: $emailCode</h1><br><h1>Никому не пересылайте этот код.</h1>";
        
        $header = "From: your-domain@your.domain \r\n";
        //$header .= "Cc:afgh@somedomain.com \r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";
        
        $retval = mail ($to,$subject,$message,$header);
        
        if( $retval != true ) {
            echo "{
                \"status\": false,
                \"extra\": \"emailSendError\"
            }";
            exit();
        }







        $query="INSERT INTO `tempUsers` (`email`, `emailCode`) VALUES ('$email', $emailCode)";
        if(!sendQuery($query)){
            $query="UPDATE `tempUsers` SET `emailCode`= $emailCode WHERE `email`='$email'";
            if(!sendQuery($query)){
                echo "{
                    \"status\": false,
                    \"extra\": \"db error\"
                }";
                exit();
            }
        }
        
        echo "{
            \"status\": $enabled,
            \"extra\": \"emailCode sent to $email\"
        }";
        exit();
    }
    else{
        echo "{
            \"status\": $enabled,
            \"error\": \"noEmail\",
            \"help\": \"Full documentation on \"http://$_SERVER[HTTP_HOST]/api.php?request=help\"\"
        }";
    }
    exit();
?>