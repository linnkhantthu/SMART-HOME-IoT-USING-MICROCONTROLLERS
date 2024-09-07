<?php ob_start();
session_start();
	include 'dbconfig.php';
  $msg ="";
try
{
	if (isset($_POST["btnsubmit"])) {
		$sql="select * from admin where username=:username and password=:password";
			$statement = $connect->prepare($sql);
			$statement->execute(
				array(
					'username' => $_POST["username"],
					'password' => $_POST["password"]
				)
			);
			$count = $statement -> rowCount();
if ($count>0) {$_SESSION["username"] = $_POST["username"];header("location:login_success.php");ob_end_flush();}
			else {
				$msg = "<span class='fa fa-info-circle'></span>";
			}
	}
}
	catch(Exception $e)
	{
		echo "Failed to connect...<br>" . $e -> getMessage();
	}
 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>SW| Login</title>
		 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <link rel="stylesheet" href="css/form.css">
   </head>
   <body>
     <div class="welcome-div">
       <span class="div-span">
         <span class="div-span-span1">Welcome to Smart World</span>
         <span class="div-span-span2">Dimensions</span>
       </span>
     </div>
     <form class="loginForm" action="loginForm.php" method="post">
       <h2 class="loginForm-heading">Login to Your Smart World</h2>
       <span class="loginForm-span">
         <label for="un">Username</label>
          <span><input class="input-box" id="un" type="text" name="username" size="1px"><span class="error"><?php echo "$msg"; ?></span></span>
        </span>
        <span class="loginForm-span">
          <label for="pw">Password</label>
            <span><input class="input-box" id="pw" type="password" name="password"><span class="error"><?php echo "$msg"; ?></span></span>
        </span>
        <input class="input-btn" type="submit" name="btnsubmit" value="Login">
     </form>
   </body>
 </html>
