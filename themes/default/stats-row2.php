<?php
    include('db.php');

    $query = "SELECT    sum(total_ht) AS 'S'                         
                FROM ccs
                WHERE year(ccs.date)=" . Date('Y') ;
    $res = mysql_query( $query );
    while( $i = mysql_fetch_assoc($res) ){
        if( $i['S'] > 1000000 )
            $annee = number_format( $i['S'] / 1000000,2,'.',' ' ) . 'M DA';
        else if( $i['S'] > 1000 )
            $annee = number_format( $i['S'] / 1000,1,'.',' ' ) . 'K DA';
        else
            $annee = number_format( $i['S'] ,0,'.',' ' ) . 'M DA';
    }

    $query = "SELECT    sum(total_ht) AS 'S'                         
                FROM ccs
                WHERE year(ccs.date)=" . Date('Y') . " AND month(ccs.date)=" . Date('m') ;
    $res = mysql_query( $query );
    while( $i = mysql_fetch_assoc($res) ){
        if( $i['S'] > 1000000 )
            $mois = number_format( $i['S'] / 1000000,2,'.',' ' ) . 'M DA';
        else if( $i['S'] > 1000 )
            $mois = number_format( $i['S'] / 1000,1,'.',' ' ) . 'K DA';
        else
            $mois = number_format( $i['S'] ,0,'.',' ' ) . 'M DA';
    }

?>

  <div class="col-md-6">
    <div class="row">
      <div class="col-md-6">
                          <div class="widget widget-fullwidth widget-small">
                            <div class="widget-head">
                              <div class="tools"><span class="value"><?php echo $annee; ?></span></div><span class="title">Total des cmds de l'année</span>
                            </div>
                            <div class="chart-container">
                              <div id="linechart-mini1" style="height: 92px;"></div>
                            </div>
                          </div>
                          <div class="widget widget-fullwidth widget-small">
                            <div class="widget-head">
                              <div class="tools"><span class="value"><?php echo $mois; ?></span></div><span class="title">Total des cmds du mois</span>
                            </div>
                            <div class="chart-container">
                              <div id="barchart-mini1" style="height: 92px;"></div>
                            </div>
                          </div>
      </div>
      <div class="col-md-6">
        <div class="widget widget-radar">
          <div class="widget-head">
            <div class="tools"><span class="icon s7-upload"></span><span class="icon s7-edit"></span></div><span class="title">Ventes des derniers mois</span>
          </div>
          <div class="chart-container">
            <canvas id="radar-chart1" height="180px"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>


            <div class="col-md-6 last_10_cmds">
              <div class="widget widget-pie widget-pie-stats">
                <div class="widget-head"><span class="title">5 dernières cmds</span></div>
                <div class="row chart-container">
                <?php
                    include("db.php");
                    
                    $query = "SELECT    codeclient,
                                        date,
                                        raison, 
                                        total_ht, 
                                        etat_web 
                                FROM ccs
                                ORDER BY date DESC 
                                LIMIT 5 ";
                    
                ?>    
                  <table class="display responsive table table-condensed table-hover table-fw-widget">
                      <thead>
                          <tr class="">
                            <th>Date</th>
                            <th>Raison</th>
                            <th>Etat</th>
                            <th style="text-align:center;">Total HT</th>
                          </tr>      
                      </thead>
                      <tbody>
                          <?php
                            $res = mysql_query( $query );
                            while( $i = mysql_fetch_assoc($res) ){
                          ?>
                          <tr class="">
                            <td><?php echo Date("d-m-Y", strtotime($i['date']) ); ?></td>
                            <td><?php echo $i['raison']; ?></td>    
                            <td><?php echo $i['etat_web']; ?></td>  
                            <td style="text-align:right;"><?php echo number_format( $i['total_ht'], 2, ',', ' ') ; ?></td>      
                          </tr>  
                          <?php
                            }//end while
                          ?>
                      </tbody>
                  </table>          
                    
                </div>   
                  
              </div>
            </div>
