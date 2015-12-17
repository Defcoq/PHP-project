<?php
?>
<link href="assets/css/siteNews.css" rel="stylesheet" type="text/css" />
<div class="panel panel-default">
    <div class="panel-heading">
        <span class="glyphicon glyphicon-list-alt"></span><b>eventi a Siena leggi tutti <a href="Eventi_Siena_Italiano.php">qui</a></b>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12">
                <ul style="overflow-y: hidden; height: 300px;" class="demo1">

                    <?php 
                   // include '../GestioneSito/database.php';
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
                            $titolo_news = html_entity_decode(stripslashes($row['title']));
                            $luogo_news = html_entity_decode(stripslashes( $row['place'] ));
                            $news_content = "";
                            $news_content ="<strong>Dal: ".$start_date."<br />"."Al: ". $end_date."<br /></strong>";
                            $news_content ="<strong>".$news_content.$titolo_news."<br /></strong>";
                            $news_content = "<strong>".$news_content."Luogo: ".$luogo_news."<br /><br/></strong>";
                            $news_content = $news_content.trim(html_entity_decode(stripslashes(substr($content,0,100) )))." ";
                            $news_content = $news_content."<a  href=\"Eventi_Siena_Italiano_Dettaglio.php?&event_id=".$row['event_id']."&lingua_id=".$row['lingua_id']."\">Dettaglio...</a>";
                    ?>
                       <li style="" class="news-item">
                           <table cellpadding="4">
                                       <tbody>
                                          <tr>
                                           <td><img src="assets/images/5.png" class="img-circle" width="60"></td>
                                           <td><?php echo $news_content?></td>
                                         </tr>
                                       </tbody>
                          </table>
                        </li>  
                    <?php
                        }
                    }
                  
                    else
                    {
                        ?>
                       <li style="" class="news-item">
                           <table cellpadding="4">
                                       <tbody>
                                          <tr>
                                           <td><img src="assets/images/5.png" class="img-circle" width="60"></td>
                                           <td>Nessuno evento per siena presente in questo sito</td>
                                         </tr>
                                       </tbody>
                          </table>
                        </li>  
                    <?php
                    }
                    Database::disconnect();
                    ?>
                    
                </ul>
            </div>
        </div>
    </div>
    <div class="panel-footer"> </div>
 </div>
 