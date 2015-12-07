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
    			<h3>Hotel Almadomus Gestion Utenti Sito</h3>
    		</div>
			<div class="row">
				<p>
					<a href="create.php" class="btn btn-success">Crea Nuovuo Utente</a>
				</p>
				
                  <div class="table-responsive">
				<table id="table_Gestione_Utenti_Sito" class="table table-striped table-bordered table-hover">
		              <thead>
		                <tr>
		                  <th>Name</th>

                          <th>Email Address</th>

                          <th>Mobile Number</th>
						  
						   <th>Event Date</th>

                          <th>Action</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   include 'database.php';
					   $pdo = Database::connect();
					   $sql = 'SELECT * FROM customers ORDER BY id DESC';
	 				    foreach ($pdo->query($sql) as $row) {

                                echo '<tr>';

                                echo '<td>'. $row['name'] . '</td>';

                                echo '<td>'. $row['email'] . '</td>';

                                echo '<td>'. $row['mobile'] . '</td>';
								
								 echo '<td>'. $row['EventDate'] . '</td>';

                                echo '<td width=250>';

                                echo '<a class="btn" href="read.php?id='.$row['id'].'">Read</a>';

                                echo ' ';

                                echo '<a class="btn btn-success" href="update.php?id='.$row['id'].'">Update</a>';

                                echo ' ';

                                echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Delete</a>';

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
                $('#table_Gestione_Utenti_Sito').dataTable();

                $('#EventDate').datepicker({});
            });


    </script>

	</script>

</body>
</html>
