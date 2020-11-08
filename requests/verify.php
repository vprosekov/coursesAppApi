<?php
    if (!count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS))) {//проверка родительского файла
        exit();
    }
    
    if(isset($_GET["emailcode"]) && isset($_GET["email"]) && isset($_GET["name"]) && isset($_GET["city"]) && isset($_GET["password"]) && isset($_GET["type"])){
        $emailCode = $_GET["emailcode"];
        $email = $_GET["email"];
        $name = $_GET["name"];
        $city = $_GET["city"];
        $password = $_GET["password"];
        $type = $_GET["type"];
        
        if(strpos($email, '@') == false){
            echo "{
                \"status\": $enabled,
                \"error\": \"emailError\",
                \"help\": \"Full documentation on \"http://$_SERVER[HTTP_HOST]/api.php?request=help\"\"
            }";
            exit();
        }

        $fb = sendSelectQuery("SELECT `email` FROM `users` WHERE `email`='$email'");
        
        if($fb && $fb[0]["email"]!="")
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
            if($emailCode != sendSelectQuery("SELECT `emailCode` FROM `tempUsers` WHERE `email`='$email'")[0]["emailCode"]){
                echo "{
                    \"status\": $enabled,
                    \"error\": \"wrondCode\",
                    \"help\": \"Full documentation on \"http://$_SERVER[HTTP_HOST]/api.php?request=help\"\"
                }";
                exit();
            }

            $apiKey = implode('', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 20), 6));

            if(sendSelectQuery("SELECT `id` FROM `users` WHERE `apiKey`='$apiKey'")){
                //echo sendSelectQuery("SELECT `id` FROM `users` WHERE `apiKey`='$apiKey'")."<br>";
                echo "{
                    \"status\": false,
                    \"error\": \"Repeat again\"
                }";
                exit();
            }

            $publishedCourses = "";
            $payedCourses = "";
            $favouriteCourses = "";
            $query = "INSERT INTO `users` (`name`, `city`, `email`, `password`, `type`, `publishedCourses`, `payedCourses`, `favouriteCourses`, `apiKey`) VALUES ('$name', '$city', '$email', '".md5($password)."','$type', '$publishedCourses', '$payedCourses', '$favouriteCourses', '$apiKey')";
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