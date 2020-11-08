<?php
    if (!count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS))) {//проверка родительского файла
        exit();
    }
    
    if(isset($_GET["apikey"])){
        $apiKey = $_GET["apikey"];
        
        $fb = sendSelectQuery("SELECT `id`, `name`, `city`, `photoUrl`, `email`, `phone`, `password`, `type`, `publishedCourses`, `payedCourses`, `favouriteCourses`, `apiKey` FROM `users` WHERE apiKey='$apiKey'");
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
            $id = $fb[0]["id"];
            $name = $fb[0]["name"];
            $city = $fb[0]["city"];
            $photoUrl = $fb[0]["photoUrl"];
            $email = $fb[0]["email"];
            $phone = $fb[0]["phone"];
            $type = $fb[0]["type"];
            $publishedCourses = $fb[0]["publishedCourses"];
            $payedCourses = $fb[0]["payedCourses"];
            $favouriteCourses = $fb[0]["favouriteCourses"];
            echo "{
                \"status\": $enabled,
                \"id\": $id,
                \"name\":\"$name\",
                \"city\":\"$city\",
                \"photoUrl\":\"$photoUrl\",
                \"email\":\"$email\",
                \"phone\":\"$phone\",
                \"type\":\"$type\",
                \"publishedCourses\":\"$publishedCourses\",
                \"payedCourses\":\"$payedCourses\",
                \"favouriteCourses\":\"$favouriteCourses\"
            }";
            exit();
        }

    }
    else if(isset($_GET["id"])){
        $id = $_GET["id"];
        if(!is_numeric($id)){
            echo "{
                \"status\": $enabled,
                \"error\": \"idError\",
                \"help\": \"Full documentation on \"http://$_SERVER[HTTP_HOST]/api.php?request=help\"\"
            }";
            exit();
        }
        $fb = sendSelectQuery("SELECT `id`, `name`, `city`, `photoUrl`, `email`, `phone`, `password`, `type`, `publishedCourses`, `payedCourses`, `favouriteCourses`, `apiKey` FROM `users` WHERE id=$id");
        //print_r($fb);
        if(!$fb || $fb[0]["id"]=="")
        {
            echo "{
                \"status\": $enabled,
                \"error\": \"idNotExists\",
                \"help\": \"Full documentation on \"http://$_SERVER[HTTP_HOST]/api.php?request=help\"\"
            }";
            exit();
        }
        else //все норм
        {
            $id = $fb[0]["id"];
            $name = $fb[0]["name"];
            $city = $fb[0]["city"];
            $photoUrl = $fb[0]["photoUrl"];
            $email = $fb[0]["email"];
            $phone = $fb[0]["phone"];
            $type = $fb[0]["type"];
            $publishedCourses = $fb[0]["publishedCourses"];
            $payedCourses = $fb[0]["payedCourses"];
            $favouriteCourses = $fb[0]["favouriteCourses"];
            echo "{
                \"status\": $enabled,
                \"id\": $id,
                \"name\":\"$name\",
                \"city\":\"$city\",
                \"photoUrl\":\"$photoUrl\",
                \"email\":\"$email\",
                \"phone\":\"$phone\",
                \"type\":\"$type\",
                \"publishedCourses\":\"$publishedCourses\",
                \"payedCourses\":\"$payedCourses\",
                \"favouriteCourses\":\"$favouriteCourses\"
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