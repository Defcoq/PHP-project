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
    		<div class="row">
    			<h3>Hotel Almadomus Gestione Utenti Sito</h3>
    		</div>
                
                <div class="row">
				<p>
					<a href="create_Admin_User.php?current_active_menu=2" class="btn btn-success">Crea Nuovo Utente</a>
				</p>
                 </div>
			<div class="row">
                  <div class="table-responsive">
				<table id="table_Gestione_Utenti_Sito" class="table table-striped table-bordered table-hover">
		              <thead>
		                <tr>
		                  <th>Nome Accesso</th>

                          <th>Indirizzo di posta</th>

                          <th>Azione</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   include 'database.php';
					   $pdo = Database::connect();
					   $sql = 'SELECT * FROM users ORDER BY username DESC';
	 				    foreach ($pdo->query($sql) as $row) {

                                echo '<tr>';

                                echo '<td>'. $row['username'] . '</td>';

                                echo '<td>'. $row['email'] . '</td>';

                                echo '<td width=250>';

                                echo '<a class="btn btn-primary" href="read_Admin_User.php?current_active_menu=2&id='.$row['id'].'">Legge</a>';

                                echo ' ';

                                echo '<a class="btn btn-success" href="update_Admin_User.php?current_active_menu=2&id='.$row['id'].'">Aggiorna</a>';

                                echo ' ';

                                echo '<a class="btn btn-danger" href="delete_Admin_User.php?current_active_menu=2&id='.$row['id'].'">Elimina</a>';

                                echo '</td>';

                                echo '</tr>';

                       }
					   Database::disconnect();
                      ?>
				      </tbody>
	            </table>
            </div>
    	</div>
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
                $('#table_Gestione_Utenti_Sito').dataTable();

                $('#EventDate').datepicker({});
            });


    </script>



</body>
</html>
