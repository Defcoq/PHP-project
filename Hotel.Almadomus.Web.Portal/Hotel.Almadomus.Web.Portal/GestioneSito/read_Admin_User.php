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

    } else {

        $pdo = Database::connect();

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM users where id = ?";

        $q = $pdo->prepare($sql);

        $q->execute(array($id));

        $data = $q->fetch(PDO::FETCH_ASSOC);

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
                        <h1>Dettaglio sull'utente selezionato</h1>
                         <p>
                           Questa pagina viene utilizzata per fornire dettagli sull'utente selezionato
                        </p>
                    </div>
                </div>
            </div>

             <form class="form-horizontal" action="create_Admin_User.php" method="post">

                      <div class="row">
                      <div class="form-group">
                
                        <label class="control-label col-md-3">Nome Login</label>
                           <div class="col-md-6">
                            <div class="form-control">
                             <?php echo $data['username'];?>
                            </div>
                            </div>

                      </div>
                    </div>

                     <div class="row">
                      <div class="form-group">

                        <label class="control-label col-md-3">Indirizzo di posta</label>

                        <div class="col-md-6">

                          
                             <div class="form-control">
                             <?php echo $data['email'];?>
                            </div>

                        </div>

                      </div>
                      </div>

                     <div class="row">
                      <div class="form-group">

                        <label class="control-label col-md-3">Password</label>

                        <div class="col-md-6">

                          <div class="form-control">
                             <?php echo $data['password'];?>
                            </div>

                        </div>

                      </div>
					  </div>

                      <br />
                      <br/>
                       <div class="row">
                      <div class="form-group ">
                          <a class="btn btn-primary col-md-offset-4" href="Gestion_Utenti.php">Indietro</a>

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
