<?php
    include('HeaderSession.php');
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
              <div class="container">
    		<div class="row">
    			<h3>Hotel Almadomus Gestione Eventi Sito</h3>
    		</div>
			<div class="row">
				<p>
					<a href="Create_Eventi.php" class="btn btn-success">Crea Nuovo Evento</a>
				</p>
				
                  <div class="table-responsive">
				<table id="table_Gestione_Eventi_Sito" class="table table-striped table-bordered table-hover">
		              <thead>
		                <tr>
		                  <th>Titolo</th>

                          <th>Luogo</th>

                          <th>Data inizio</th>
						  
						   <th>Data fine</th>

                          <th>Inserito da</th>
                          <th>Data inserimento</th>
                          <th>Data aggiornamento</th>

                         

                          <th>Azione</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   include 'database.php';
					   $pdo = Database::connect();
					   $sql = 'SELECT E.event_id, E.title,E.description,E.place,E.start_date,E.end_date,E.created_date,E.update_date,U.username FROM Eventi as E inner join users as U on E.user_id = U.id ORDER BY E.start_date DESC';
	 				    foreach ($pdo->query($sql) as $row) {
                                $date_start = DateTime::createFromFormat('Y-m-d',$row['start_date']);
                                $start_date = $date_start->format("d/m/Y");

                               $date_end = DateTime::createFromFormat('Y-m-d',$row['end_date']);
                                $end_date = $date_end->format("d/m/Y");

                               $date_created = DateTime::createFromFormat('Y-m-d H:i:s',$row['created_date']);
                                $created_date = $date_created->format("d/m/Y");

                               $date_update = DateTime::createFromFormat('Y-m-d H:i:s',$row['update_date']);
                                $update_date = $date_start->format("d/m/Y");

                                echo '<tr>';

                                echo '<td>'. html_entity_decode(stripslashes($row['title'])) . '</td>';

                                echo '<td>'.html_entity_decode(stripslashes( $row['place'] )). '</td>';

                                echo '<td>'. $start_date . '</td>';
								
								 echo '<td>'. $end_date . '</td>';

                                 echo '<td>'. html_entity_decode(stripslashes($row['username'] )). '</td>';

                                echo '<td>'. $created_date . '</td>';
								
								 echo '<td>'. $update_date . '</td>';
                                 

                                echo '<td width=250>';

                                echo '<a class="btn btn-primary" href="read_Eventi.php?event_id='.$row['event_id'].'">legge</a>';

                                echo ' ';

                                echo '<a class="btn btn-success" href="read_Eventi.php?event_id='.$row['event_id'].'">aggiorna</a>';

                                echo ' ';

                                echo '<a class="btn btn-danger" href="read_Eventi.php?event_id='.$row['event_id'].'">Elimina</a>';

                                echo '</td>';

                                echo '</tr>';

                       }
					   Database::disconnect();
					  ?>
				      </tbody>
	            </table>
            </div>
    	</div>
    </div> <!-- /container -->
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
        console.log('jquery init');
            $(document).ready(function () {
                $('#table_Gestione_Eventi_Sito').dataTable();

                $('#EventDate').datepicker({});
            });


    </script>

	</script>

</body>
</html>
