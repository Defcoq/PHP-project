<?php
    include('HeaderSession.php');
?>
<?php 

    require 'database.php';

    if ( !empty($_POST)) {

        // keep track validation errors

        $nameError = null;

        $emailError = null;

        $mobileError = null;
		$eventDateError = null;

        // keep track post values

        $name = $_POST['name'];

        $email = $_POST['email'];

        $valid = true;

        if (empty($name)) {

            $nameError = 'Please enter Name';

            $valid = false;

        }
        if (empty($email)) {

            $emailError = 'Please enter Email Address';

            $valid = false;

        } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {

            $emailError = 'Please enter a valid Email Address';

            $valid = false;

        }



        // insert data

        if ($valid) {

          $pdo = Database::connect();
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //check if username and email is already taken
         // Check if the username is already taken
        $query = " 
            SELECT 
                1 
            FROM users 
            WHERE 
                username = :username 
        "; 
        $query_params = array( ':username' => $_POST['name'] ); 
        try { 
            $stmt = $pdo->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex)
        { 
        die("Failed to run query: " . $ex->getMessage()); 
        } 
        $row = $stmt->fetch(); 
        if($row){ 
                 $nameError = "Utente già esistente inserire un nuovo utente";
                 die("Utente già esistente inserire un nuovo utente"); 
               } 
        $query = " 
            SELECT 
                1 
            FROM users 
            WHERE 
                email = :email 
        "; 
        $query_params = array( 
            ':email' => $_POST['email'] 
        ); 
        try { 
            $stmt = $pdo->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage());} 
        $row = $stmt->fetch(); 
        if($row){ 
           $emailError = "Email già esistente, inserire un nuovo email";
           die("Email già esistente, inserire un nuovo email"); 
           } 
         


        //----- end check username and email

          

            $sql = "INSERT INTO users (username,password,salt,email) values(
                :username, 
                :password, 
                :salt, 
                :email )";

            $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
            $password = hash('sha256', $_POST['password'] . $salt); 

            for($round = 0; $round < 65536; $round++){ $password = hash('sha256', $password . $salt); } 
           $query_params = array( 
            ':username' => $_POST['name'], 
            ':password' => $password, 
            ':salt' => $salt, 
            ':email' => $_POST['email'] 
        ); 

         try {  
             $q = $pdo->prepare($sql);

            $q->execute($query_params);

            Database::disconnect();
        } 
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); } 
      
            header("Location: Gestion_Utenti.php");
           // die("Redirecting to estion_Utenti.php"); 

        }

    }

?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Almadomus Admin</title>
	<?php
    include('HeaderCss.php');
    ?>

</head>
<body>
    <div id="wrapper">
      <?php
       include('AdminHeader.php');
       ?>
        <div id="page-wrapper" >
            <div id="page-inner">
             <div class="row">
                <div class="col-md-12">
                    <div class="jumbotron">
                        <h1>Creazione Nuovo Utente Amministrazione</h1>
                         <p>
                           Questa pagina viene utilizzata per la creazione di un  utente amministratore del sito, inserire i dati del nuovo utente che si desidera creare
                        </p>
                    </div>
                </div>
            </div>

             <form class="form-horizontal" action="create_Admin_User.php" method="post">

                      <div class="row">
                      <div class="form-group <?php echo !empty($nameError)?'error':'';?>">
                
                        <label class="control-label col-md-3">Nome Login</label>
                           <div class="col-md-6">
                            <input class="form-control" name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">

                            <?php if (!empty($nameError)): ?>

                                <span class="help-inline"><?php echo $nameError;?></span>

                            <?php endif; ?>
                            </div>

                      </div>
                    </div>

                     <div class="row">
                      <div class="form-group <?php echo !empty($emailError)?'error':'';?>">

                        <label class="control-label col-md-3">Indirizzo di posta</label>

                        <div class="col-md-6">

                            <input name="email" class="form-control"  type="text" placeholder="Email Address" value="<?php echo !empty($email)?$email:'';?>">

                            <?php if (!empty($emailError)): ?>

                                <span class="help-inline"><?php echo $emailError;?></span>

                            <?php endif;?>

                        </div>

                      </div>
                      </div>

                     <div class="row">
                      <div class="form-group <?php echo !empty($mobileError)?'error':'';?>">

                        <label class="control-label col-md-3">Password</label>

                        <div class="col-md-6">

                            <input name="password" type="password"  class="form-control"  placeholder="password" value="<?php echo !empty($mobile)?$mobile:'';?>">

                            <?php if (!empty($mobileError)): ?>

                                <span class="help-inline"><?php echo $mobileError;?></span>

                            <?php endif;?>

                        </div>

                      </div>
					  </div>

                      <br />
                      <br/>
                       <div class="row">
                      <div class="form-group ">

                          <button type="submit" class="btn btn-success col-md-offset-4">Crea Utente</button>

                          <a class="btn btn-primary" href="Gestion_Utenti.php">Indietro</a>

                        </div>
                     </div>
                    </form>



             </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
     <!-- /. WRAPPER  -->
   <?php 
   include('AdminFooter.php');
   ?>

    	<script>
	$(document).ready(function()
	{
	    //alert("Jquery funziona");
		$('#EventDate').datepicker({
         });
	});


	</script>


</body>
</html>
