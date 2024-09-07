<?php
include 'secure.php';
include 'header.php';
 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Welcome to Smart Home</title>
     <script src='https://kit.fontawesome.com/a076d05399.js'></script>
     <link rel="stylesheet" href="css/login_success_css.css">
   </head>
   <body>
     <header class="header-ls">
       <h2 class="header-h">
         Welcome to Smart Home
         <span class="header-span"><?php echo $_SESSION["username"]; ?></span>
       </h2>
     </header>
     <div class="div-body">
      <span class="div-item">
         <a class="icon-link" href="displayhome.php"><i class='fas fa-home' id="i-icon" ></i></a>
       </span>

       <span class="div-item">
         <i class='fas fa-fish' id="i-icon" ></i>
       </span>
     </div>
   </body>
 </html>
