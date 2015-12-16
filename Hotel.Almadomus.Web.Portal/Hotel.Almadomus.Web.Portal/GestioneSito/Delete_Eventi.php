<?php
include('HeaderSession.php');
?>
<?php 

require 'database.php';

$event_id = 0;

if ( !empty($_GET['event_id'])) {

    $event_id = $_REQUEST['event_id'];

}

if (!empty($_POST)) {

    // keep track post values

    $event_id = $_POST['event_id'];

    // delete data

    $pdo = Database::connect();

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "DELETE FROM Eventi  WHERE event_id = ?";

    $q = $pdo->prepare($sql);

    $q->execute(array($event_id));

    Database::disconnect();

    header("Location: Gestion_Eventi.php");
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
                        <h1>Eliminazione di un evento del sito</h1>
                         <p>
                           Questa pagina viene utilizzata per eliminare dal sito un evento dal sito
                        </p>
                    </div>
                </div>
            </div>

            <form class="form-horizontal" action="Delete_Eventi.php" method="post">

                      <input type="hidden" name="event_id" id="event_id" value="<?php echo $event_id;?>"/>

                      <div class="alert alert-danger">
                              Sei sicuro di volere eliminare definitivamente l'evento dal sito ?
                       </div>
                     

                      <div class="form-actions">

                          <button type="submit" class="btn btn-danger">Si</button>

                          <a class="btn btn-primary" href="Gestion_Eventi.php">No</a>

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
