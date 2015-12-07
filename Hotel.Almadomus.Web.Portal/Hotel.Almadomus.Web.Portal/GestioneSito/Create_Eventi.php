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

        $mobile = $_POST['mobile'];
		$eventDate = $_POST['eventDate'];
		

		
		/*$raw = '10 . 11 . 1968';
        $date = DateTime::createFromFormat('d . m . Y', $raw);
		*/

		$date = DateTime::createFromFormat('d/m/Y',$eventDate);
        $eventDate = $date->format("Y-m-d");

		

         

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
		
		if (empty($eventDate)) {

            $eventDateError = 'Please enter Event Date';

            $valid = false;

        }

         

        // insert data

        if ($valid) {

            $pdo = Database::connect();

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO customers (name,email,mobile,EventDate) values(?, ?, ?,?)";

            $q = $pdo->prepare($sql);

            $q->execute(array($name,$email,$mobile,$eventDate));

            Database::disconnect();

            header("Location: Gestion_Utenti.php");

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

                        <label class="control-label col-md-3">Mobile Number</label>

                        <div class="col-md-6">

                            <input name="mobile" type="text"  class="form-control"  placeholder="Mobile Number" value="<?php echo !empty($mobile)?$mobile:'';?>">

                            <?php if (!empty($mobileError)): ?>

                                <span class="help-inline"><?php echo $mobileError;?></span>

                            <?php endif;?>

                        </div>

                      </div>
					  </div>

                       <div class="row">
					  <div class="form-group <?php echo !empty($eventDateError)?'error':'';?>">

                        <label class="control-label col-md-3">Event Date</label>

                        <div class="col-md-6">

                            <input name="eventDate" class="form-control" id="EventDate" type="text"  placeholder="Event Date"  data-date-format="dd/mm/yyyy" value="<?php echo !empty($eventDate)?$eventDate:'';?>">

                            <?php if (!empty($eventDate)): ?>

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

                          <a class="btn" href="Gestion_Utenti.php">Indietro</a>

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
