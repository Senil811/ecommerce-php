<html>
    <header>
        <title> First PHP Greeting page </title >
    </header>
    <body>
        <center>PROG8186</center>
        <br></br>
        <div>
            <form method="Post" action=""> 
                <input type="text" name="username"/>
                <br/>
                <input type="submit" name="Submit"/>
            </form>
        </div>
        <?php
        if($_POST) {
            $username = $_POST['username'];
            echo '<h2> Welcome to the class' . $username . '</h2>';     
        }  
        ?>    
    </body>
</html>
