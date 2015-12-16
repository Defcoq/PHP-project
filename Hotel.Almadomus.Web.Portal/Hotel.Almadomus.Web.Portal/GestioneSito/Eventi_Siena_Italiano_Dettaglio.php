<?php
include('../GestioneSito/HeaderSession.php');
?>
<?php include("GestioneHeaderSito.php");?>
<?php
include('HeaderCssGestioneSito.php');
?>
<?php 

require '../GestioneSito/database.php';

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


<div class="main-outer-wrapper no-titlebar">
    <div class="main-wrapper container">
        <div class="row row-wrapper">
            <div class="page-outer-wrapper">
                <div class="page-wrapper twelve columns no-sidebar b0">

                    
                        <div class="twelve columns b0">
                            <div class="page-title-wrapper">

                                <br />
                                <h1 class="page-title left">Dettaglio evento selezionato</h1>
                                <div class="page-title-alt right">
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>

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
                          <a class="btn btn-primary col-md-offset-4" href="Eventi_Siena_Italiano.php">Torna all'elenco degli eventi</a>

                        </div>
                     </div>
                    </div>




                        <div class="sidebar right-sidebar-wrapper four columns">

                          
                        </div>
                        <div class="clear"></div>
                    </div> <!-- END .row -->

                </div> <!-- END .page-wrapper -->
                <div class="clear"></div>

            </div> <!-- END .page-outer-wrapper -->
        </div>
    </div> <!-- END .main-wrapper -->




</div> <!-- END .main-outer-wrapper -->
<?php include("footerIt.php");?>


    </div><!-- END .body-wrapper -->
</div><!-- END .body-outer-wrapper -->
<!-- Javascript -->
<?php include("scriptIt.php");?>

 <?php 
 include('GestioneFooterSito.php');
 ?>


     <script>
         console.log('jquery init');
         var jQuery1_10_2 = jQuery.noConflict(true);
         jQuery1_10_2(document).ready(function () {
         //jQuery1_10_2('#table_Gestione_Eventi_Sito').dataTable();

             jQuery1_10_2('#EventDate').datepicker({});
            });


    </script>

</body>
</html>