<?php
include('HeaderSession.php');
?>
<?php 
require 'database.php';
?>
<script type="text/javascript">
                var isEventUpdated = false;
                var isEventTestataUpdated = false;
                var isEventDescriptionUpdated = false;
</script>
    <?php
$event_id = null;

if (!empty($_GET['event_id'])) {

    $event_id = $_REQUEST['event_id'];
}
if(null==$event_id ) {

    header("Location: Gestion_Eventi.php");

}
if (!empty($_POST)) {
    $titleError = null;

    $descriptionError = null;
    $linguaError = null;

    $placeError = null;
    $start_dateError = null;
    $end_dateError = null;

    $place = null;
    $start_date = null;
    $end_date = null;
    $title =null;
    $breftitle =null;
    $description =null;
    $lingua_id = null;

    $valid = false;
    $valid_Event_Description = false;
    $row_user_from_session =  $_SESSION['user'] ;
    $user_id = $row_user_from_session['id'];
    $event_id = null;
    if (!empty($_GET['event_id'])) {

        $event_id = $_REQUEST['event_id'];

    }
    else if(!empty($_SESSION['event_id'])) 
    {
        
        $event_id = $_SESSION['event_id'];
        
           ?>
                <script type="text/javascript">
                
                isEventUpdated = true;

               </script>
           <?php
    }
    if(isset($_POST['Aggiorna_Evento']))
    {
        $place = $_POST['place'];
		$start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $breftitle = $_POST['breftitle'];
		
		$date_start = DateTime::createFromFormat('d/m/Y',$start_date);
        $start_date = $date_start->format("Y-m-d");

        $date_end = DateTime::createFromFormat('d/m/Y',$end_date);
        $end_date = $date_end->format("Y-m-d");

        $valid = true;

        
        
        if (empty($place)) {

            $placeError = 'inserire il luogo';

            $valid = false;

        }
		
		if (empty($start_date)) {

            $start_dateError = 'inserire la data inizio';

            $valid = false;

        }

        if (empty($end_date)) {

            $end_dateError = 'inserire la data fine';

            $valid = false;

        }

        if (empty($breftitle)) {

            $breftitleError = 'inserire un titolo Testata Evento';

            $valid = false;

        }

        if ($valid) {

            $event_Insert_OK =false;
            $pdo = Database::connect();

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "update Eventi set title=:title,place=:place,start_date=:start_date,end_date=:end_date where event_id=:event_id";
            try
            {
                $q = $pdo->prepare($sql);
                $q->execute(array(
                     'title' =>htmlentities($breftitle),
                     'place' => htmlentities($place),
                     'start_date' =>$start_date,
                     'end_date' => $end_date,
                     'event_id' => $event_id
                     ));
               
           ?>
                <script type="text/javascript">
                
                 isEventTestataUpdated = true;
               </script>
                <?php

                Database::disconnect();
            }
            catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); } 
            //header("Location: Create_Eventi.php?event_id=".$event_id);

        }
    }
    if(isset($_POST['Crea_Descrizione_Evento']))
    {

        $place = $_POST['place'];
		$start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        
		
		$date_start = DateTime::createFromFormat('d/m/Y',$start_date);
        $start_date = $date_start->format("Y-m-d");

        $date_end = DateTime::createFromFormat('d/m/Y',$end_date);
        $end_date = $date_end->format("Y-m-d");

        
        $title = $_POST['title'];
        $breftitle = $_POST['breftitle'];
        $description = $_POST['txtEditorContent'];
        $lingua_id = $_POST['lingua_id'];
        $valid_Event_Description = true;

        if (empty($title)) {

            $titleError = 'inserire un titolo';

            $valid_Event_Description = false;

        }
        if (empty($description)) {

            $descriptionError = 'inserire una descripzione ';

            $valid_Event_Description = false;

        } 

        if (empty($lingua_id)) {

            $linguaError = 'inserire una lingua ';

            $valid_Event_Description = false;

        } 

        if ($valid_Event_Description) {

            $pdo = Database::connect();

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO EventiLingua (event_id,lingua_id,title,description) values(?, ?, ?,?)";
            try
            {
                $q = $pdo->prepare($sql);
                $q->execute(array($event_id,$lingua_id, htmlentities($title),htmlentities($description)));
                ?>
                <script type="text/javascript">
                
                isEventDescriptionUpdated = true;

               </script>
              <?php
                Database::disconnect();
            }
            catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage(). "con event_id=".$event_id); } 
            //header("Location: Gestion_Eventi.php");

        }
    }
} else {

    $pdo = Database::connect();

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * from Eventi  where event_id = ?";

    $q = $pdo->prepare($sql);

    $q->execute(array($event_id));

    $data = $q->fetch(PDO::FETCH_ASSOC);

    $event_id = $data['event_id'];
    $place =  $data['place'];
    $start_date =  $data['start_date'];
    $end_date =  $data['end_date'];
    $breftitle =  $data['title'];
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
                        <h1>Aggiornamento Evento</h1>
                         <p>
                           Questa pagina viene utilizzata per l'aggiornamento di un evento esistente
                        </p>
                    </div>
                </div>
            </div>

             <form class="form-horizontal" action="Update_Eventi.php?event_id=<?php echo $event_id; ?>" method="post">

                    <div class="row">
                      <div class="form-group <?php echo !empty($BreftitleError)?'error':'';?>">
                
                        <label class="control-label col-md-3">Titolo Testata Evento</label>
                           <div class="col-md-6">
                            <input class="form-control" name="breftitle" id="breftitle" type="text"  placeholder="Titolo Breve generale" value="<?php echo !empty($breftitle)?$breftitle:'';?>">

                            <?php if (!empty($BreftitleError)): ?>

                                <span class="help-inline"><?php echo ''.$BreftitleError;?></span>

                            <?php endif; ?>
                            </div>

                      </div>
                    </div>
                     
                     <div class="row">
                      <div class="form-group <?php echo !empty($placeError)?'error':'';?>">

                        <label class="control-label col-md-3">Luogo Evento</label>

                        <div class="col-md-6">

                            <input name="place" type="text"  class="form-control"  placeholder="Luogo Evento" value="<?php echo !empty($place)?$place:'';?>">

                            <?php if (!empty($placeError)): ?>

                                <span class="help-inline"><?php echo $placeError;?></span>

                            <?php endif;?>

                        </div>

                      </div>
					  </div>

                       <div class="row">
					  <div class="form-group <?php echo !empty($start_dateError)?'error':'';?>">

                        <label class="control-label col-md-3">Data inizio</label>

                        <div class="col-md-6">
                          <?php
                          if(!empty($start_date))
                          {
                              $date_start = DateTime::createFromFormat('Y-m-d',$start_date);
                              $start_date = $date_start->format("d/m/Y");
                          }
                          
                          if(!empty($end_date))
                          {
                              $date_start = DateTime::createFromFormat('Y-m-d',$end_date);
                              $end_date = $date_start->format("d/m/Y");
                          }

                          ?>
                            <input name="start_date" class="form-control" id="start_date" type="text"  placeholder="start date"  data-date-format="dd/mm/yyyy" value="<?php echo !empty($start_date)?$start_date:'';?>">

                            <?php if (!empty($start_dateError)): ?>

                                <span class="help-inline"><?php echo $start_dateError;?></span>

                            <?php endif;?>

                        </div>
                        </div>
                      </div>
                      <br />
                      <br/>

                        <div class="row">
					  <div class="form-group <?php echo !empty($end_dateError)?'error':'';?>">

                        <label class="control-label col-md-3">Data fine</label>

                        <div class="col-md-6">

                            <input name="end_date" class="form-control" id="end_date" type="text"  placeholder="end date"  data-date-format="dd/mm/yyyy" value="<?php echo !empty($end_date)?$end_date:'';?>">

                            <?php if (!empty($end_dateError)): ?>

                                <span class="help-inline"><?php echo $end_dateError;?></span>

                            <?php endif;?>

                        </div>
                        </div>
                      </div>

                       <div class="row">
                      <div class="form-group  ">
                          <button type="submit" name="Aggiorna_Evento" id="Aggiorna_Evento" class="btn btn-success col-md-offset-4 ">Aggiorna Testata Evento</button>
                         
                        </div>
                     </div>
                      <br />
                      <br/>

                        <div class="row">
                    <div class="col-md-12">
                    <div class="panel panel-default" id="Panel_Descrizione_Eventi">
                        <div class="panel-heading">
                            Descrizioni in lingue associate all''evento corrente
                        </div>
                        <div class="panel-body">
                          

                        <div class="row">
                           <div class="form-group ">
                          <button type="submit" class="btn btn-success fa fa-plus col-md-offset-4" id="btn_Insert_New">Inserisci nuova descrizione</button>
                           <a class="btn btn-primary" href="Gestion_Eventi.php">Visualizza tutti gli eventi</a>
                         </div>
                        </div>

                        <div id="descrizione_Event_Field_Group">

                        <div class="row">
                        <div class="form-group <?php echo !empty($linguaError)?'error':'';?>">
                          <label class="control-label col-md-3">Lingua</label>
                            <?php
                            $pdo_lingua = Database::connect();
                            $sql_lingua = 'SELECT * from Lingua';
                            ?>

                            <div class="col-md-6">
                             <select name="lingua_id" id="lingua_id" class="form-control">

                             <?php foreach ($pdo_lingua->query($sql_lingua) as $row) { ?>
                                <option value="<?= $row['lingua_id']; ?>"><?= $row['description']; ?></option>
                               <?php } ?>
                             </select>
                            <?php if (!empty($linguaError)): ?>

                                <span class="help-inline"><?php echo $linguaError;?></span>

                            <?php endif; ?>
                            </div>
                        </div>
                        </div>
                      <div class="row">
                      <div class="form-group <?php echo !empty($titleError)?'error':'';?>">
                
                        <label class="control-label col-md-3">Titolo</label>
                           <div class="col-md-6">
                            <input class="form-control" name="title" id="title" type="text"  placeholder="Titolo" value="<?php echo !empty($title)?$title:'';?>">

                            <?php if (!empty($titleError)): ?>

                                <span class="help-inline"><?php echo $titleError;?></span>

                            <?php endif; ?>
                            </div>

                      </div>
                    </div>

                     <div class="row">
                      <div class="form-group <?php echo !empty($descriptionError)?'error':'';?>">

                        <label class="control-label col-md-3">Descrizione</label>

                        <div class="col-md-6">

                            <textarea class="form-control" rows="5" id="description" name="description" placeholder="description" value="<?php echo !empty($description)?$description:'';?>"></textarea>
                           
                            <?php if (!empty($descriptionError)): ?>

                                <span class="help-inline"><?php echo $descriptionError;?></span>

                            <?php endif;?>

                        </div>

                      </div>
                      </div>

                         <div class="row">
                           <div class="form-group ">
                          <button type="submit" name="Crea_Descrizione_Evento" id="Crea_Descrizione_Evento" class="btn btn-success col-md-offset-4">Crea descrizione</button>
                          <a class="btn btn-primary" href="Gestion_Eventi.php">Visualizza tutti gli eventi</a>
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
                      $sql = 'SELECT E.event_id,EL.title,EL.description as descrizioneEvento, L.description as linguaEvento, L.lingua_id FROM Eventi as E inner join EventiLingua as EL on E.event_id = EL.event_id inner join Lingua as L on EL.lingua_id=L.lingua_id where E.event_id='.$event_id;
                      if(!empty($event_id))
                      {
                          foreach ($pdo->query($sql) as $row) {
                              
                              $content = html_entity_decode(stripslashes($row['descrizioneEvento'] ));
                              $content = preg_replace("/<img[^>]+\>/i", "", $content); 
                              
                              echo '<tr>';

                              echo '<td>'. html_entity_decode(stripslashes($row['title'])) . '</td>';

                              echo '<td>'.trim(html_entity_decode(substr($content,0,200))).'......' .'</td>';
                              echo '<td>'.html_entity_decode(stripslashes( $row['linguaEvento'] )). '</td>';

                              echo '<td width=250>';

                              echo '<a class="btn btn-primary" href="read_Eventi_Descrizione.php?current_active_menu=3&event_id='.$row['event_id'].'&lingua_id='.$row['lingua_id'].'">legge</a>';

                              echo ' ';

                              echo '<a class="btn btn-success" href="update_Eventi_Descrizione.php?current_active_menu=3&event_id='.$row['event_id'].'&lingua_id='.$row['lingua_id'].'">aggiorna</a>';

                              echo ' ';

                              echo '<a class="btn btn-danger" href="delete_Eventi_Descrizione.php?current_active_menu=3&event_id='.$row['event_id'].'&lingua_id='.$row['lingua_id'].'">Elimina</a>';

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
                        </div>
                    </div>
                </div>
               </div>
              <br />
              <br/>
                      
             <textarea id="txtEditorContent" name="txtEditorContent" hidden=""></textarea>
                    
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
 <script type="text/javascript">
	$(document).ready(function()
	{
    toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": true,
  "positionClass": "toast-top-center",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
   }
	    //alert("Jquery funziona");
		$('#start_date').datepicker({
         todayHighlight: true,
         "autoclose": true,});
        $('#end_date').datepicker({  
         todayHighlight: true,
         "autoclose": true,});

         $("#description").Editor();
          $('#descrizione_Event_Field_Group').hide();

        $("#btn_Insert_New").click(function(e) {
           
          $("#description").Editor("setText", "");
          $('#descrizione_Event_Field_Group').show();
          $("#title").val("");
          $("#lingua_id").val('IT');

          
           e.preventDefault();
         });

         $('#table_Gestione_Eventi_Associati_Sito').dataTable();
         
         //$( "#btn_Insert_New" ).prop( "disabled", true );
         //if(isEventCreated)
         //{
         //  $( "#btn_Insert_New" ).prop( "disabled", false );
         // $('#Crea_Evento').hide();
         //}


          if(isEventTestataUpdated)
         {
          toastr.success("Testata Evento aggiornata con successo, inserire o aggiornare le descrizione in lingua associate all'evento");
          
         }
         if(isEventDescriptionUpdated)
         {
          toastr.success("Descrizione per l'evento inserita con sucesso");
         }
	});

     $(document).submit(function()
          {
         // alert($("#description").Editor("getText"));
          console.log($("#description").Editor("getText"));
           $("#txtEditorContent").val($("#description").Editor("getText"));
         });
	</script>

</body>
</html>
