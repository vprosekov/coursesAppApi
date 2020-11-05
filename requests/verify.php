<?php
    if (!count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS))) {//проверка родительского файла
        exit();
    }
    
    if(isset($_GET["smscode"]) && isset($_GET["phone"]) && isset($_GET["name"]) && isset($_GET["city"]) && isset($_GET["password"]) && isset($_GET["type"])){
        $smsCode = $_GET["smscode"];
        $phone = $_GET["phone"];
        $name = $_GET["name"];
        $city = $_GET["city"];
        $password = $_GET["password"];
        $type = $_GET["type"];
        //echo "getgood<br>";
        $fb = sendSelectQuery("SELECT `phone` FROM `users` WHERE `phone`=$phone");
        //print_r($fb);
        if($fb && $fb[0]["phone"]!="")
        {
            echo "{
                \"status\": $enabled,
                \"error\": \"userExists\",
                \"help\": \"Full documentation on \"http://$_SERVER[HTTP_HOST]/api.php?request=help\"\"
            }";
            exit();
        }
        else //все норм
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

            if(sendSelectQuery("SELECT `id` FROM `users` WHERE `apiKey`='$apiKey'")){
                //echo sendSelectQuery("SELECT `id` FROM `users` WHERE `apiKey`='$apiKey'")."<br>";
                echo "{
                    \"status\": false
                }";
                exit();
            }

            $publishedCourses = "";
            $payedCourses = "";
            $favouriteCourses = "";
            $query = "INSERT INTO `users` (`name`, `city`, `phone`, `password`, `type`, `publishedCourses`, `payedCourses`, `favouriteCourses`, `apiKey`) VALUES ('$name', '$city', $phone, '".md5($password)."','$type', '$publishedCourses', '$payedCourses', '$favouriteCourses', '$apiKey')";
            //echo ($query)."<br>";
            if(sendQuery($query)){
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

    }else{
        echo "{
            \"status\": $enabled,
            \"error\": \"noData\",
            \"help\": \"Full documentation on \"http://$_SERVER[HTTP_HOST]/api.php?request=help\"\"
        }";
        exit();
    }
    
?>