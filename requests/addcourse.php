<?php
    if (!count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS))) {//проверка родительского файла
        exit();
    }
    
    if(isset($_GET["apikey"]) && isset($_GET["name"]) && isset($_GET["description"]) && isset($_GET["photourl"]) && isset($_GET["category"]) && isset($_GET["type"]) && isset($_GET["price"])){
        $apiKey = $_GET["apikey"];
        $name = $_GET["name"];
        $description = $_GET["description"];
        $photoUrl = $_GET["photourl"];
        $category = $_GET["category"];
        $type = $_GET["type"];
        $price = $_GET["price"];
        
        $fb = sendSelectQuery("SELECT * FROM `users` WHERE apiKey='$apiKey'");
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
        if($fb[0]["type"]=="student"){
            echo "{
                \"status\": $enabled,
                \"error\": \"noAccess\",
                \"help\": \"Full documentation on \"http://$_SERVER[HTTP_HOST]/api.php?request=help\"\"
            }";
            exit();
        }
        else //все норм
        {
            $creator = $fb[0]["id"];
            if(sendQuery("INSERT INTO `courses`(`name`, `description`, `photoUrl`, `creator`, `category`, `type`, `students`, `rating`, `views`, `price`) VALUES ('$name','$description','$photoUrl',$creator,'$category','$type', '', 0, 0, $price)")){
                $lselid=sendSelectQuery("SELECT LAST_INSERT_ID();")[0]["LAST_INSERT_ID()"];

                if(sendQuery("UPDATE `users` SET `publishedCourses`='".$fb[0]["publishedCourses"].$lselid.","."' WHERE `apiKey` = '$apiKey'")){
                    echo "{
                        \"status\": $enabled
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

    }
    else if(isset($_GET["apikey"]) && isset($_GET["name"]) && isset($_GET["description"]) && isset($_GET["category"]) && isset($_GET["type"]) && isset($_GET["price"])){
        $apiKey = $_GET["apikey"];
        $name = $_GET["name"];
        $description = $_GET["description"];
        $photoUrl = "NOPHOTOURL";
        $category = $_GET["category"];
        $type = $_GET["type"];
        $price = $_GET["price"];
        
        $fb = sendSelectQuery("SELECT * FROM `users` WHERE apiKey='$apiKey'");
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
        if($fb[0]["type"]=="student"){
            echo "{
                \"status\": $enabled,
                \"error\": \"noAccess\",
                \"help\": \"Full documentation on \"http://$_SERVER[HTTP_HOST]/api.php?request=help\"\"
            }";
            exit();
        }
        else //все норм
        {
            $creator = $fb[0]["id"];
            if(sendQuery("INSERT INTO `courses`(`name`, `description`, `photoUrl`, `creator`, `category`, `type`, `students`, `rating`, `views`, `price`) VALUES ('$name','$description','$photoUrl',$creator,'$category','$type', '', 0, 0, $price)")){
                
                $lselid=sendSelectQuery("SELECT LAST_INSERT_ID();")[0]["LAST_INSERT_ID()"];

                if(sendQuery("UPDATE `users` SET `publishedCourses`='".$fb[0]["publishedCourses"].$lselid.","."' WHERE `apiKey` = '$apiKey'")){
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