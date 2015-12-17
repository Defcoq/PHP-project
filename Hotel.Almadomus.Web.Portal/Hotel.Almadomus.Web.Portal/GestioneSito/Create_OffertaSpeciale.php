<?php
include('HeaderSession.php');
?>
<?php 

require 'database.php';

?>
                <script type="text/javascript">
                
                var isEventCreated = false;
                 var isEventTestataCreated = false;
                var isEventDescriptionInsert = false;

               </script>
    <?php
    if (!empty($_POST)) {

        // keep track validation errors

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
        $offertaSpeciale_id = null;

        if (!empty($_GET['offertaSpeciale_id'])) {

            $offertaSpeciale_id = $_REQUEST['offertaSpeciale_id'];

        }
        else if(!empty($_SESSION['offertaSpeciale_id'])) 
        {
            
            $offertaSpeciale_id = $_SESSION['offertaSpeciale_id'];
            
    ?>
                <script type="text/javascript">
                
                isEventCreated = true;

               </script>
           <?php
        }
        
        if(isset($_POST['Crea_Evento']))
        {
            $place = $_POST['code'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $breftitle = $_POST['breftitle'];
            
            $date_start = DateTime::createFromFormat('d/m/Y',$start_date);
            $start_date = $date_start->format("Y-m-d");

            $date_end = DateTime::createFromFormat('d/m/Y',$end_date);
            $end_date = $date_end->format("Y-m-d");

            $valid = true;

            
            
            if (empty($place)) {

                $placeError = 'inserire il codice offerta';

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

                $sql = "INSERT INTO OffertaSpeciale (title,code,start_date, end_date,user_id) values(?,?,?,?,?)";
                try
                {
                    $q = $pdo->prepare($sql);
                    $q->execute(array(htmlentities($breftitle),htmlentities($place),$start_date,$end_date,$user_id));
                    $event_Insert_OK = $q->rowCount();
                    if( $event_Insert_OK)
                    {
                        $offertaSpeciale_id = $pdo->lastInsertId();
                        $_SESSION['offertaSpeciale_id'] = $offertaSpeciale_id;  
           ?>
                <script type="text/javascript">
                
                 isEventCreated = true;
                 isEventTestataCreated = true;

               </script>
                <?php


                        
                    }

                    Database::disconnect();
                }
                catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); } 
                //header("Location: Create_Eventi.php?event_id=".$event_id);

            }
        }

        if(isset($_POST['Crea_Descrizione_Evento']))
        {

            $place = $_POST['code'];
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

                $sql = "INSERT INTO OffertaSpecialeLingua (offertaSpeciale_id,lingua_id,title,description) values(?, ?, ?,?)";
                try
                {
                    $q = $pdo->prepare($sql);
                    $q->execute(array($offertaSpeciale_id,$lingua_id, htmlentities($title),htmlentities($description)));
                ?>
                <script type="text/javascript">
                
                isEventDescriptionInsert = true;

               </script>
              <?php
                    Database::disconnect();
                }
                catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage(). "con event_id=".$event_id); } 
                //header("Location: Gestion_Eventi.php");

            }
        }

        
        // insert data

        

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
                        <h1>Creazione Nuova Offerta</h1>
                         <p>
                           Questa pagina viene utilizzata per la creazione di un'offerta speciale nel sito, inserire i dati dell'offerta ed anche possibile inserire un immagine oppure vari link collegati all'offerta'
                        </p>
                    </div>
                </div>
            </div>

             <form class="form-horizontal" action="Create_OffertaSpeciale.php" method="post">

                    <div class="row">
                      <div class="form-group <?php echo !empty($BreftitleError)?'error':'';?>">
                
                        <label class="control-label col-md-3">Titolo Testata Offerta</label>
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

                        <label class="control-label col-md-3">Codice Offerta</label>

                        <div class="col-md-6">

                            <input name="code" type="text"  class="form-control"  placeholder="codice evento" value="<?php echo !empty($place)?$place:'';?>">

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
                          <button type="submit" name="Crea_Evento" id="Crea_Evento" class="btn btn-success col-md-offset-4 ">Crea Testata Offerta</button>
                         
                        </div>
                     </div>
                      <br />
                      <br/>

                        <div class="row">
                    <div class="col-md-12">
                    <div class="panel panel-default" id="Panel_Descrizione_Eventi">
                        <div class="panel-heading">
                            Descrizioni in lingue associate all''offerta corrente
                        </div>
                        <div class="panel-body">
                          

                        <div class="row">
                           <div class="form-group ">
                          <button type="submit" class="btn btn-success fa fa-plus col-md-offset-4" id="btn_Insert_New">Inserisci nuova descrizione</button>
                           <a class="btn btn-primary" href="Gestione_Offerte_Speciali.php">Visualizza tutte le offerte</a>
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
                          <a class="btn btn-primary" href="Gestione_Offerte_Speciali.php">Visualizza tutti gli eventi</a>
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
                      $sql = 'SELECT E.offertaSpeciale_id,EL.title,EL.description as descrizioneEvento, L.description as linguaEvento, L.lingua_id FROM OffertaSpeciale as E inner join OffertaSpecialeLingua as EL on E.offertaSpeciale_id = EL.offertaSpeciale_id inner join Lingua as L on EL.lingua_id=L.lingua_id where E.offertaSpeciale_id='.$offertaSpeciale_id;
                      if(!empty($offertaSpeciale_id))
                      {
                          foreach ($pdo->query($sql) as $row) {
                              
                              $content = html_entity_decode(stripslashes($row['descrizioneEvento'] ));
                              $content = preg_replace("/<img[^>]+\>/i", "", $content); 
                              
                              echo '<tr>';

                              echo '<td>'. html_entity_decode(stripslashes($row['title'])) . '</td>';

                              echo '<td>'.trim(html_entity_decode(substr($content,0,200))).'......' .'</td>';
                              echo '<td>'.html_entity_decode(stripslashes( $row['linguaEvento'] )). '</td>';

                              echo '<td width=250>';

                              echo '<a class="btn btn-primary" href="read_OffertaSpeciale_Descrizione.php?current_active_menu=4&event_id='.$row['offertaSpeciale_id'].'&lingua_id='.$row['lingua_id'].'">legge</a>';

                              echo ' ';

                              echo '<a class="btn btn-success" href="update_OffertaSpeciale_Descrizione.php?current_active_menu=3&event_id='.$row['offertaSpeciale_id'].'&lingua_id='.$row['lingua_id'].'">aggiorna</a>';

                              echo ' ';

                              echo '<a class="btn btn-danger" href="delete_OffertaSpeciale_Descrizione.php?current_active_menu=3&event_id='.$row['offertaSpeciale_id'].'&lingua_id='.$row['lingua_id'].'">Elimina</a>';

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
         
         $( "#btn_Insert_New" ).prop( "disabled", true );
         if(isEventCreated)
         {
           $( "#btn_Insert_New" ).prop( "disabled", false );
          $('#Crea_Evento').hide();
         }


          if(isEventTestataCreated)
         {
          toastr.success("Testata Offerta creata con successo, inserire ora le descrizione in lingua associato all'offerta");
          
         }
         if(isEventDescriptionInsert)
         {
          toastr.success("Descrizione per l'offerta inserita con sucesso");
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
