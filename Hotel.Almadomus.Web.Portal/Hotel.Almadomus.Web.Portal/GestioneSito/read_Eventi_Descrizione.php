<?php
    include('HeaderSession.php');
?>
<?php 

    require 'database.php';

    $id = null;
    $lingua_id = null;

    if ( !empty($_GET['event_id'])) {

        $id = $_REQUEST['event_id'];

    }

     if ( !empty($_GET['lingua_id'])) {

        $lingua_id = $_REQUEST['lingua_id'];

    }
    if ( null==$id || null==$lingua_id ) {

        header("Location: Gestion_Eventi.php");

    } else {

        $pdo = Database::connect();

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT E.title as titoloTestata, E.place, E.start_date, E.end_date, EL.title as titoloEvento, EL.description FROM Eventi as E inner join EventiLingua as EL on E.event_id =EL.event_id where E.event_id = ? and EL.lingua_id=?";

        $q = $pdo->prepare($sql);
       

        $q->execute(array($id,$lingua_id));

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
                        <h1>Dettaglio sull'evento selezionato</h1>
                         <p>
                           Questa pagina viene utilizzata per fornire dettagli sull'evento selezionato
                        </p>
                    </div>
                </div>
            </div>

             <form class="form-horizontal" action="create_Admin_User.php" method="post">

                      <div class="row">
                      <div class="form-group">
                
                        <label class="control-label col-md-3">Titolo Testata</label>
                           <div class="col-md-6">
                            <div class="form-control">
                             <?php echo html_entity_decode(stripslashes($data['titoloTestata']));?>
                            </div>
                            </div>

                      </div>
                    </div>

                      <div class="row">
                      <div class="form-group">

                        <label class="control-label col-md-3">Luogo</label>

                        <div class="col-md-6">

                          <div class="form-control">
                             <?php echo html_entity_decode(stripslashes($data['place']));?>
                            </div>

                        </div>

                      </div>
					  </div>

                      
                     <div class="row">
                      <div class="form-group">

                        <label class="control-label col-md-3">Data Inizio</label>

                        <div class="col-md-6">

                          
                             <div class="form-control">
                             <?php 
 
                                $date_start = DateTime::createFromFormat('Y-m-d', $data['start_date']);
                                $start_date = $date_start->format("d/m/Y");
                            echo $start_date;
                            ?>
                            </div>

                        </div>

                      </div>
                      </div>

                       <div class="row">
                      <div class="form-group">

                        <label class="control-label col-md-3">Data Fine</label>

                        <div class="col-md-6">

                          
                             <div class="form-control">
                             <?php 
 
                                $date_end = DateTime::createFromFormat('Y-m-d', $data['end_date']);
                                $end_date = $date_start->format("d/m/Y");
                            echo $end_date;
                            ?>
                            </div>

                        </div>

                      </div>
                      </div>

                       <div class="row">
                      <div class="form-group">
                
                        <label class="control-label col-md-3">Titolo Evento in lingua</label>
                           <div class="col-md-6">
                            <div class="form-control">
                             <?php echo html_entity_decode(stripslashes($data['titoloEvento']));?>
                            </div>
                            </div>

                      </div>
                    </div>

                     <div class="row">
                      <div class="form-group">
                
                        <label class="control-label col-md-3">Descrizione</label>
                           <div class="col-md-6">
                           <p>  <?php echo html_entity_decode(stripslashes($data['description']));?> </p>
                           
                            </div>

                      </div>
                    </div>

                      <br />
                      <br/>
                       <div class="row">
                      <div class="form-group ">
                          <a class="btn btn-primary col-md-offset-4" href="read_Eventi.php?event_id=<?php echo $id ?>">Torna alla testa dell'evento</a>

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
