<?php
    include('HeaderSession.php');
?>
<?php 

    require 'database.php';
    $id = null;

    if ( !empty($_GET['id'])) {

        $id = $_REQUEST['id'];
    }
    if ( null==$id ) {

        header("Location: Gestion_Utenti.php");

    }
    if ( !empty($_POST)) {

        // keep track validation errors

        $nameError = null;

        $emailError = null;

        $mobileError = null;

         

        // keep track post values

        $name = $_POST['name'];

        $email = $_POST['email'];

        $mobile = $_POST['password'];

         

        // validate input

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

         

        if (empty($mobile)) {

            $mobileError = 'Please enter Mobile Number';

            $valid = false;

        }
        // update data

        if ($valid) {

            $pdo = Database::connect();

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

             // Check if the username is already taken
        $query = " 
            SELECT 
                1 
            FROM users 
            WHERE 
                username = :username and id <> :id
        "; 
        $query_params = array( ':username' => $_POST['name'],':id' => $id); 
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
                email = :email and id <> :id
        "; 
        $query_params = array( 
            ':email' => $_POST['email'] ,
            ':id' => $id
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

            $sql = "UPDATE users set username = :username, password =:password, salt =:salt, email = :email WHERE id = :id";

             $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
            $password = hash('sha256', $mobile. $salt); 

            for($round = 0; $round < 65536; $round++){ $password = hash('sha256', $password . $salt); } 
           $query_params = array( 
            ':username' => $name, 
            ':password' => $password, 
            ':salt' => $salt, 
            ':email' => $email,
            ':id' => $id
             ); 

            $q = $pdo->prepare($sql);

            $q->execute($query_params);

            Database::disconnect();

            header("Location: Gestion_Utenti.php");

        }

    } else {

        $pdo = Database::connect();

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM users where id = ?";

        $q = $pdo->prepare($sql);

        $q->execute(array($id));

        $data = $q->fetch(PDO::FETCH_ASSOC);

        $name = $data['username'];

        $email = $data['email'];

        $mobile = $data['password'];

        Database::disconnect();

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
                        <h1>Aggiorna dati per l'utente selezionato</h1>
                         <p>
                           Questa pagina viene utilizzata per l'aggiornamenti dei dati dell' utente selezionato
                        </p>
                    </div>
                </div>
            </div>

             <form class="form-horizontal" action="update_Admin_User.php?id=<?php echo $id?>" method="post">

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

                          <button type="submit" class="btn btn-success col-md-offset-4">Aggiorna</button>

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
