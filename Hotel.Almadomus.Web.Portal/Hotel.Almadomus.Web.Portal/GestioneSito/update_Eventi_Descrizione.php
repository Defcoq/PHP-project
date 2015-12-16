<?php
include('HeaderSession.php');
?>
<?php 
require 'database.php';
$event_id = null;
$lingua_id  = null;
$description = null;

if ( !empty($_GET['event_id'])) {

    $event_id = $_REQUEST['event_id'];
}
if ( !empty($_GET['lingua_id'])) {

    $lingua_id = $_REQUEST['lingua_id'];

}
if ( null==$event_id || null==$lingua_id ) {

    header("Location: Gestion_Eventi.php");

}
if (!empty($_POST)) {

    $titleError = null;

    $descriptionError = null;
   
    $row_user_from_session =  $_SESSION['user'] ;
    $user_id = $row_user_from_session['id'];

    
    $title = $_POST['title'];
    $description = $_POST['txtEditorContent'];
  
    $valid = true;
    if (empty($title)) {

        $titleError = 'inserire un titolo  Evento';

        $valid = false;

    }

    if (empty($description)) {

        $descriptionError = 'inserire una descrizione Evento';

        $valid = false;

    }

 
    if ($valid) {

        $pdo = Database::connect();

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $sql = "UPDATE EventiLingua set title =:title, description =:description WHERE event_id = :event_id && lingua_id=:lingua_id";

        try
        {
            $q = $pdo->prepare($sql);
            $q->execute(array(
                'title' =>htmlentities($title),
                'description' =>htmlentities($description),
                'event_id' =>$event_id, 
                'lingua_id' =>$lingua_id
                ));
         
            Database::disconnect();
        }
        catch(PDOException $ex){ die("Failed to run query: title".htmlentities($title)."///Description".htmlentities($description)."////event_id".$event_id."///Lingua". $lingua_id."////error message". $ex->getMessage()); } 
        header("Location: Update_Eventi.php?current_active_menu=3&event_id=".$event_id);

    }

} else {

    $pdo = Database::connect();

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT E.title as titoloTestata, E.place, E.start_date, E.end_date, EL.title as titoloEvento, EL.description,  L.description as linguaEvento FROM Eventi as E inner join EventiLingua as EL on E.event_id =EL.event_id inner join Lingua as L on EL.lingua_id=L.lingua_id where E.event_id = ? and EL.lingua_id=?";

    $q = $pdo->prepare($sql);

    $q->execute(array($event_id,$lingua_id));

    $data = $q->fetch(PDO::FETCH_ASSOC);
    $title = $data['titoloEvento'];
    $description = $data['description'];


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
                        <h1>Aggiorna evento selezionato</h1>
                         <p>
                           Questa pagina viene utilizzata per l'aggiornamenti dei dati per l'evento selezionato'
                        </p>
                    </div>
                </div>
            </div>

             <form class="form-horizontal" action="update_Eventi_Descrizione.php?current_active_menu=3&event_id=<?php echo $event_id;?>&lingua_id=<?php echo $lingua_id; ?>" method="post">

                     
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
                                if($date_start != null)
                                {
                                      $start_date = $date_start->format("d/m/Y");
                                      echo $start_date;
                                }
                              
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
                                if($date_end != null)
                                {
                                          $end_date = $date_start->format("d/m/Y");
                                         echo $end_date;
                                }
                            
                            ?>
                            </div>

                        </div>

                      </div>
                      </div>

                        <div class="row">
                      <div class="form-group">

                        <label class="control-label col-md-3">Lingua Evento</label>

                        <div class="col-md-6">

                          <div class="form-control">
                             <?php echo html_entity_decode(stripslashes($data['linguaEvento']));?>
                            </div>

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
                          <button type="submit" name="Crea_Descrizione_Evento" id="Crea_Descrizione_Evento" class="btn btn-success col-md-offset-4">Aggiorna Evento</button>
                          <a class="btn btn-primary" href="Gestion_Eventi.php">Visualizza tutti gli eventi</a>
                          </div>
                       </div>
                     </div>
                      <textarea id="txtEditorContent" name="txtEditorContent" hidden=""></textarea>
                      <div id="descrizioneContentHTML" style='display:none'><?php echo $description; ?>
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
	       $("#description").Editor();
         var jsonVar = <?php echo stripslashes(html_entity_decode(json_encode($description))); ?>;
         //alert(jsonVar);
         $("#description").Editor("setText", jsonVar);

       
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
