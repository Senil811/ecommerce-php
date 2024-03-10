<html>
   
   <head>
      <style>
         .error {color: #FF0000;}
      </style>
	  <title>PROG2070 Assingment #1</title>
	  
   </head>
   
   <body>
      <?php
         // define variables and set to empty values
         $firstnameErr = $lastnameErr = $emailErr = $genderErr = $websiteErr = "";
         $firstname = $lastname = $email = $gender = $comment = $website = "";
         
         if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["firstname"])) {
               $firstnameErr = "Last name is required";
            }else {
               $firstname = test_input($_POST["firstname"]);
            }
			
			if (empty($_POST["lastname"])) {
               $lastnameErr = "Lsat Name is required";
            }else {
               $lastname = test_input($_POST["lastname"]);
            }
            
            if (empty($_POST["email"])) {
               $emailErr = "Email is required";
            }else {
               $email = test_input($_POST["email"]);
               
               // check if e-mail address is well-formed
               if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                  $emailErr = "Invalid email format"; 
               }
            }
            
            if (empty($_POST["website"])) {
               $website = "";
            }else {
               $website = test_input($_POST["website"]);
            }
            
            if (empty($_POST["comment"])) {
               $comment = "";
            }else {
               $comment = test_input($_POST["comment"]);
            }
            
            if (empty($_POST["gender"])) {
               $genderErr = "Gender is required";
            }else {
               $gender = test_input($_POST["gender"]);
            }
         }
         
         function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
         }
      ?>
     
      <h2>PROG2070 - Winter 2024</h2>
     
      <p><span class = "error">* required field.</span></p>
     
      <form method = "post" action = "<?php 
         echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
         <table>
            <tr>
               <td>FirstName:</td>
               <td><input type = "text" name = "firstname">
                  <span class = "error">* <?php echo $firstnameErr;?></span>
               </td>
            </tr>
			
			<tr>
               <td>Last Name:</td>
               <td><input type = "text" name = "lastname">
                  <span class = "error">* <?php echo $lastnameErr;?></span>
               </td>
            </tr>
           
            <tr>
               <td>E-mail: </td>
               <td><input type = "text" name = "email">
                  <span class = "error">* <?php echo $emailErr;?></span>
               </td>
            </tr>
           
            <tr>
               <td>StudentID: (seven digits only)</td>
               <td> <input type = "text" name = "website">
                  <span class = "error"><?php echo $websiteErr;?></span>
               </td>
            </tr>
            
            <tr>
               <td>Classes:</td>
               <td> <textarea name = "comment" rows = "5" cols = "40"></textarea></td>
            </tr>
            
            <tr>
               <td>Gender:</td>
               <td>
                  <input type = "radio" name = "gender" value = "male">Female
                  <input type = "radio" name = "gender" value = "female">Male
				  <input type = "radio" name = "gender" value = "Other">Other
                  <span class = "error">* <?php echo $genderErr;?></span>
               </td>
            </tr>
				
            <td>
               <input type = "submit" name = "submit" value = "Submit"> 
            </td>
			
			 <td>
               <input type = "submit" name = "home" value = "Home"> 
            </td>
				
         </table>
			
      </form>
      
      <?php
         echo "<h2>Your given values are as follows:</h2>";
         echo $lastname;
         echo "<br>";
		 
		 echo "Hello: ";
		 echo $firstname;
         echo "<br>";
         
         echo $email;
         echo "<br>";
         
         echo $website;
         echo "<br>";
         
         echo $comment;
         echo "<br>";
         
         echo $gender;
		 
		 		 
		 function sub()
			{
				$sub=6-1;
			echo "The answer is = ".$sub;
			}
			div();
      ?>
   
   </body>
</html>