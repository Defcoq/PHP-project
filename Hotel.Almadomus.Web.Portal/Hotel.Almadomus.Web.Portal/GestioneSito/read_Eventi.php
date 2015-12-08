<?php
    include('HeaderSession.php');
?>
<?php 

    require 'database.php';

    $id = null;

    if ( !empty($_GET['event_id'])) {

        $id = $_REQUEST['event_id'];

    }
    if ( null==$id ) {

        header("Location: Gestion_Eventi.php");

    } else {

        $pdo = Database::connect();

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM Eventi where event_id = ?";

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
                             <?php echo html_entity_decode(stripslashes($data['title']));?>
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

                      
                     <div id="tabelle_Descrizione_Associati">
                       <div class="table-responsive">
				<table id="table_Gestione_Eventi_Associati_Sito" class="table table-striped table-bordered table-hover">
		              <thead>
		                <tr>
		                  <th>Titolo</th>
                          <th>Descrizone breve</th>
                          <th>Lingua</th>
                          <th>Azione</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php
					   $pdo = Database::connect();
					   $sql = 'SELECT E.event_id,EL.title,EL.description as descrizioneEvento, L.description as linguaEvento, L.lingua_id FROM Eventi as E inner join EventiLingua as EL on E.event_id = EL.event_id inner join Lingua as L on EL.lingua_id=L.lingua_id where E.event_id='.$id;
                       if(!empty($id))
                       {
	 				    foreach ($pdo->query($sql) as $row) {
                               
                                $content = html_entity_decode(stripslashes($row['descrizioneEvento'] ));
                                $content = preg_replace("/<img[^>]+\>/i", "", $content); 
                               
                                echo '<tr>';

                                echo '<td>'. html_entity_decode(stripslashes($row['title'])) . '</td>';

                                echo '<td>'.trim(html_entity_decode(substr($content,0,200))).'......' .'</td>';
                                echo '<td>'.html_entity_decode(stripslashes( $row['linguaEvento'] )). '</td>';

                                echo '<td width=250>';

                                echo '<a class="btn btn-primary" href="read_Eventi_Descrizione.php?event_id='.$row['event_id'].'&lingua_id='.$row['lingua_id'].'">legge</a>';

                                echo ' ';

                                echo '<a class="btn btn-success" href="update_Eventi_Descrizione.php?event_id='.$row['event_id'].'&lingua_id='.$row['lingua_id'].'">aggiorna</a>';

                                echo ' ';

                                echo '<a class="btn btn-danger" href="delete_Eventi_Descrizione.php?event_id='.$row['event_id'].'&lingua_id='.$row['lingua_id'].'">Elimina</a>';

                                echo '</td>';

                                echo '</tr>';

                       }
                       }
					   Database::disconnect();
					  ?>
				      </tbody>
	            </table>
            </div>
                     </div>

                      <br />
                      <br/>
                       <div class="row">
                      <div class="form-group ">
                          <a class="btn btn-primary col-md-offset-4" href="Gestion_Eventi.php">Torna all'elenco degli eventi</a>

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
		$('#EventDate').datepicker({});
         $('#table_Gestione_Eventi_Associati_Sito').dataTable();
	});


	</script>


</body>
</html>
