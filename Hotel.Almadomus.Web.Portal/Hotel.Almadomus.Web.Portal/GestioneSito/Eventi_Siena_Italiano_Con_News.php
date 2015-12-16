<?php
include('../GestioneSito/HeaderSession.php');
?>
<?php include("GestioneHeaderSito.php");?>
<?php
include('HeaderCssGestioneSito.php');
?>
<link href="assets/css/siteNews.css" rel="stylesheet" type="text/css" />
<div class="main-outer-wrapper no-titlebar">
    <div class="main-wrapper container">
        <div class="row row-wrapper">
            <div class="page-outer-wrapper">
                <div class="page-wrapper twelve columns no-sidebar b0">
                    <div class="row">
                        <div class="eight columns">
                           <table id="table_Gestione_Eventi_Sito" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Titolo</th>

                                <th>Luogo</th>

                                <th>Data inizio</th>

                                <th>Data fine</th>

                                <th>Descrizione</th>




                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include '../GestioneSito/database.php';
                            $pdo = Database::connect();
                            $sql = "SELECT E.event_id, EL.title,EL.description,E.place,E.start_date,E.end_date, EL.lingua_id FROM Eventi as E inner join EventiLingua as EL on E.event_id = EL.event_id inner join Lingua L on EL.lingua_id=L.lingua_id where L.sigla='IT' and E.end_date >= NOW() ORDER BY E.start_date ASC";
                            $stmt = $pdo->prepare($sql);
                            $result = $stmt->execute();
                            $check_row = $stmt->fetch();
                            if($check_row)
                            {
                                foreach ($pdo->query($sql) as $row) {
                                    $date_start = DateTime::createFromFormat('Y-m-d',$row['start_date']);
                                    $start_date = $date_start->format("d/m/Y");
                                    $date_end = DateTime::createFromFormat('Y-m-d',$row['end_date']);
                                    $end_date = $date_end->format("d/m/Y");
                                    $content = html_entity_decode(stripslashes($row['description'] ));
                                    $content = preg_replace("/<img[^>]+\>/i", "", $content);
                                    echo '<tr>';
                                    echo '<td width=10%>'. html_entity_decode(stripslashes($row['title'])) . '</td>';
                                    echo '<td width=10%>'.html_entity_decode(stripslashes( $row['place'] )). '</td>';
                                    echo '<td width=10%>'. $start_date . '</td>';
                                    echo '<td width=10%>'. $end_date . '</td>';
                                    echo '<td width=50%>'.trim(html_entity_decode(stripslashes(substr($content,0,200) ))).'....'. '</td>';
                                    echo '<td width=10%>';
                                    echo '<a class="btn btn-primary" href="Eventi_Siena_Italiano_Dettaglio.php?&event_id='.$row['event_id'].'&lingua_id='.$row['lingua_id'].'">Dettaglio</a>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                            }
                            else
                            {
                            ?>
                            <tr>

                                <td colspan="6">
                                    <div class="alert alert-warning">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Attenzione!</strong> attualmente non ci sono eventi per siena su questo sito, riprovare in un secondo momento.
                                    </div>
                                </td>
                            </tr>
                            <?php
                            }
                            Database::disconnect();
                            ?>
                        </tbody>
                    </table>
                        </div>
                        <div class="four columns">
                            <div class="builder-item-wrapper builder-editor">
                                <div class="builder-title-wrapper clearfix">
                                    <h3 class="builder-item-title">Servizi</h3>
                                    <a href="Cameretariffe.php" class="view-all">Va alla pagina dei servizi →</a>
                                </div>
                                <div class="builder-item-content row">
                                    <div class="twelve columns b0">
                                        <ul class="upcoming-events">
                                            <li>

                                                <!-- <a href="Cameretariffe.php" class="event-title">Wifi Free</a>
                                 <span>visualizza la nostra pagina per la copertura wifi Free</span> -->
                                                <img src="assets/images/WifiFree.jpg" alt="">

                                            </li>
                                            <li>

                                                <!--  <a href="Cameretariffe.php" class="event-title">Bar</a>
                                  <span>visualizza la nostra pagina per i servizi al bar</span> -->

                                                <img src="assets/images/BreakFastIncluded2.jpg" alt="">

                                            </li>
                                            <li>
                                                <div id="TA_excellent162" class="TA_excellent"><ul id="RbAMlaT" class="TA_links Luf1c6"><li id="ygRx3y" class="kdJFtLYR"><a target="_blank" href="http://www.tripadvisor.it/"><img src="http://static.tacdn.com/img2/widget/tripadvisor_logo_115x18.gif" alt="TripAdvisor" class="widEXCIMG" id="CDSWIDEXCLOGO" /></a></li></ul></div>
                                                <script src="http://www.jscache.com/wejs?wtype=excellent&amp;uniq=162&amp;locationId=198751&amp;lang=it&amp;display_version=2"></script>
                                            </li>
                                            <li>

                                                <a href="Cameretariffe.php" class="event-title">Piano</a>
                                                <span>visualizza il nostro servizio per l'accesso al pianoforte</span>

                                            </li>
                                            <li>
                                           
                                            </li>
                                        </ul>

                                    </div>
                                </div>
                            </div>
                            
                                             <div class="row">
                                                    <div >
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading"> <span class="glyphicon glyphicon-list-alt"></span><b>News</b></div>
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-xs-12">
                                                                        <ul style="overflow-y: hidden; height: 300px;" class="demo1">







                                                                            <li style="" class="news-item">
                                                                                <table cellpadding="4">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td><img src="assets/images/5.png" class="img-circle" width="60"></td>
                                                                                            <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in venenatis enim... <a href="#">Read more...</a></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </li>
                                                                            <li style="" class="news-item">
                                                                                <table cellpadding="4">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td><img src="assets/images/6.png" class="img-circle" width="60"></td>
                                                                                            <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in venenatis enim... <a href="#">Read more...</a></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </li>
                                                                            <li style="" class="news-item">
                                                                                <table cellpadding="4">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td><img src="assets/images/7.png" class="img-circle" width="60"></td>
                                                                                            <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in venenatis enim... <a href="#">Read more...</a></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </li>
                                                                            <li style="display:none;" class="news-item">
                                                                                <table cellpadding="4">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td><img src="assets/images/1.png" class="img-circle" width="60"></td>
                                                                                            <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in venenatis enim... <a href="#">Read more...</a></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </li>
                                                                            <li style="display:none;" class="news-item">
                                                                                <table cellpadding="4">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td><img src="assets/images/2.png" class="img-circle" width="60"></td>
                                                                                            <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in venenatis enim... <a href="#">Read more...</a></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </li>
                                                                            <li style="display:none;" class="news-item">
                                                                                <table cellpadding="4">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td><img src="assets/images/3.png" class="img-circle" width="60"></td>
                                                                                            <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in venenatis enim... <a href="#">Read more...</a></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </li>
                                                                            <li style="display:none;" class="news-item">
                                                                                <table cellpadding="4">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td><img src="assets/images/4.png" class="img-circle" width="60"></td>
                                                                                            <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in venenatis enim... <a href="#">Read more...</a></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                           <div class="panel-footer"> </div>
                                                        </div>
                                                    </div>
                                                </div>
                        </div>
                        <div class="clear"></div>
                    </div> <!-- END .row -->


                 
                  
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

     
        <script src="assets/js/jquery.bootstrap.newsbox.min.js" type="text/javascript"></script>
        <script>
            console.log('jquery init');
            var jQuery1_10_2 = jQuery.noConflict(true);
            jQuery1_10_2(document).ready(function () {

                jQuery1_10_2(".demo1").bootstrapNews({
                    newsPerPage: 3,
                    autoplay: true,
                    pauseOnHover: true,
                    direction: 'up',
                    newsTickerInterval: 4000,
                    onToDo: function () {
                        //console.log(this);
                    }
                });


            });


        </script>
        </body>
        </html>
