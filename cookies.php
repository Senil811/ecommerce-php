<?php
$cookie_name = "username";
$cookie_value = "Senil";
setcookie($cookie_name, $cookie_value);
?>
<html>
    <body>
        <?php
        if(isset($_COOKIE[$cookie_name])) {
            echo 'Cookie named ' . $cookie_name . 'is set with value ' . $_COOKIE[$cookie_name];
        } else {
            echo 'Cookie named ' . $cookie_name . ' is not set';
        }
        ?>
        <!-- SQL Test -->
        <?php
        try {
            $url = "mysql:host=localhost;dbname=resr_api_demo";
            $user = "root";
            $passwd = "";
            $db =new PDO($url, $user, $passwd);
            echo '<br />DB Connection Test Succesful';

            $statement = 'SELECT * FROM users WHERE users.username=:username';
            $sql = $db->prepare($statement);
            $sql->bindValue(':username', $_COOKIE[$cookie_name]);
            $sql->execute();

            if ($user = $sql->fetch(PDO::FETCH_ASSOC)) {
                $message = "User found";
            }else {
                $message = "User with username " . $_COOKIE[$cookie_name]   . " not found in records";
            }
            
            echo '<br /> ' . $message;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        ?>
</body>
</html>