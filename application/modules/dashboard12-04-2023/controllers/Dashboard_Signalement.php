 <?php
  // rapport:Dashboard Signalement
  // MANIRATUNGA ERIC
  // maniratunga.eric@mediabox.bi
  // le 12/01/2023
class Dashboard_Signalement extends CI_Controller 
{
  function index()
  { 
    $data['title']='siganalement des incidents';
    $data['statut']=$this->Model->getRequete('SELECT `ID_ALERT_STATUT`, `NOM` FROM `civil_alerts_statuts` WHERE 1');      
      $this->load->view('Dashboard_Signalement_View',$data);
  }
    //Fonction get_rapport
  function get_rapport() 
  {
    $date1=$this->input->post('DATE1');
    $date2=$this->input->post('DATE2');
    $statut=$this->input->post('STATUT');
    $IS_FROM_AGENT =$this->input->post('SOURCE');
    $HAVE_SEE_PLAQUE =$this->input->post('PLAQUE');
    $ANNULATION =$this->input->post('ANNULATION');

    $cond1='';
    if ($IS_FROM_AGENT!='')
    {
      if ($IS_FROM_AGENT==3) {
        $cond1='';
      }
      else{
      $cond1.=" AND `si`.`IS_FROM_AGENT`=".$IS_FROM_AGENT;
      } 
    }
     
      $cond_plaque='';

    if ($HAVE_SEE_PLAQUE!='')
    { 
      if ($HAVE_SEE_PLAQUE==3) {
     $cond_plaque='';

    }
    else{
      $cond_plaque.=" AND `si`.`HAVE_SEE_PLAQUE`=".$HAVE_SEE_PLAQUE;
    }
    }
 
      $critere_statut="";
    if(!empty($statut))
    {
      $critere_statut="AND `si`.`ID_ALERT_STATUT`=".$statut;
    }

    $critere_annul="";
    if($ANNULATION!='')
    {
      if ($ANNULATION==3) 
      {
         $critere_annul="";
      }
      else
      {
         $critere_annul="AND `si`.`IS_ANNULE`=".$ANNULATION;
      }
    }    
      $critere21="";
   if(!empty($date1) AND !empty($date2) )
   {
      $critere21=" AND date_format(si.DATE_SIGNAL,'%Y-%m-%d') BETWEEN '".$date1."' AND '".$date2."'" ;
   }

  $Signal_TC=$this->Model->getRequete("SELECT `civil_alerts_types`.`ID_TYPE` AS ID ,`civil_alerts_types`.`DESCRIPTION`,COUNT(si.ID_SIGNALEMENT_NEW) as NBRE_TC FROM `signalement_civil_agent_new` si JOIN civil_alerts_types ON civil_alerts_types.ID_TYPE=si.ID_CATEGORIE_SIGNALEMENT WHERE 1 ".$critere21." ".$critere_statut." ".$cond1." ".$cond_plaque." ".$critere_annul." GROUP BY ID,`civil_alerts_types`.`DESCRIPTION`");

    $donnees3="";
    $total1=0; 
    foreach ($Signal_TC as  $value)
    {
      $key_id1=($value['ID']>0) ? $value['ID'] : "0" ;
      $somme=($value['NBRE_TC']>0) ? $value['NBRE_TC'] : "0" ;
      $donnees3.="{name:'".str_replace("'","\'", $value['DESCRIPTION'])." : ". $somme."', y:". $value['NBRE_TC'].",key1:'". $key_id1."'},";
         $total1=$total1+ $somme;    
    } 

    $rapp1="<script type=\"text/javascript\">
  Highcharts.chart('container1', {
    chart: {
      type: 'pie'
    },
    title: {
      text: '<b>signalements par catégorie</b><br>Le ".date('d-m-Y')."'
      
    },
    subtitle: {
      text: 'Total: ".$total1."',
      
    },
    plotOptions: {
      pie: {
        innerSize: 100,
        depth: 45,
        point:{
      events: {
           click: function()
           {
         $(\"#titre1\").html(\"liste des signalements par catégorie\");
            
      $(\"#myModal1\").modal();
      var row_count ='1000000';
      $(\"#mytable1\").DataTable({
      \"processing\":true,
      \"serverSide\":true,
      \"bDestroy\": true,
      \"oreder\":[],
      \"ajax\":{
      url:\"".base_url('dashboard/Dashboard_Signalement/detail_Signal_TC')."\",
      type:\"POST\",
      data:{        
      key1:this.key1,
      DATE1:$('#DATE1').val(),
      DATE2:$('#DATE2').val(),
      STATUT:$('#STATUT').val(),
      SOURCE:$('input[type=radio][name=SOURCE]:checked').val(),
      PLAQUE:$('input[type=radio][name=PLAQUE]:checked').val(),
      ANNULATION:$('input[type=radio][name=ANNULATION]:checked').val(),
      }
      },
      lengthMenu: [[10,50, 100, row_count], [10,50, 100, \"All\"]],
      pageLength: 10,
      \"columnDefs\":[{
       \"targets\":[],
       \"orderable\":false
         }],

            dom: 'Bfrtlip',
            buttons: [
            'excel', 'print','pdf'
            ],
            language: {
                \"sProcessing\":     \"Traitement en cours...\",
                \"sSearch\":         \"Rechercher&nbsp;:\",
                \"sLengthMenu\":     \"Afficher _MENU_ &eacute;l&eacute;ments\",
                \"sInfo\":           \"Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments\",
                \"sInfoEmpty\":      \"Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment\",
                \"sInfoFiltered\":   \"(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)\",
                \"sInfoPostFix\":    \"\",
                \"sLoadingRecords\": \"Chargement en cours...\",
                \"sZeroRecords\":    \"Aucun &eacute;l&eacute;ment &agrave; afficher\",
                \"sEmptyTable\":     \"Aucune donn&eacute;e disponible dans le tableau\",
                \"oPaginate\": {
                  \"sFirst\":      \"Premier\",
                  \"sPrevious\":   \"Pr&eacute;c&eacute;dent\",
                  \"sNext\":       \"Suivant\",
                  \"sLast\":       \"Dernier\"
                },
          \"oAria\": {
            \"sSortAscending\":  \": activer pour trier la colonne par ordre croissant\",
            \"sSortDescending\": \": activer pour trier la colonne par ordre d&eacute;croissant\"
          }
      }  
      });
        }
      }
      },
      showInLegend: false
       }
   },

      credits: {
    enabled: true,
    href: \"\",
    text: \"Mediabox\"
  },  
    series: [{
      name: '',
      colorByPoint: true,
      data: [".$donnees3." ]
      }]
  });
  </script>";

    $Incident_vehicules=$this->Model->getRequete("SELECT q.ID_CONTROLES_QUESTIONNAIRES as IDP, COUNT(au.ID_CONTROLES_QUESTIONNAIRES) as nbr,SUM(q.MONTANT) as montant, q.INFRACTIONS as name FROM signalement_civil_agent_new si JOIN autres_controles au on si.ID_AUTRE_CONTROL=au.ID_AUTRES_CONTROLES JOIN autres_controles_questionnaires q on au.ID_CONTROLES_QUESTIONNAIRES=q.ID_CONTROLES_QUESTIONNAIRES WHERE si.ID_CATEGORIE_SIGNALEMENT=1 ".$critere21." ".$critere_statut." ".$cond1." ".$cond_plaque." ".$critere_annul." GROUP by IDP,name"); 

    $total2=0;
    $donnees_inc_veh="";
    $MONTANT=0;
      $donnees_inc_veh1="";
    foreach ($Incident_vehicules as  $value)  
    {
      
      $key_id1=($value['IDP']>0) ? $value['IDP'] : "0" ;
      $somme=($value['nbr']>0) ? $value['nbr'] : "0" ;
      $MONTANT=number_format($value['montant'],0, ' ', ' ');
      $donnees_inc_veh.="{name:'".str_replace("'","\'", $value['name'])."', y:". $somme.",key:".$key_id1."},";

      $donnees_inc_veh1.="{name:'".str_replace("'","\'", $value['name'])."', y:".$value['montant'].",key:".$key_id1."},";
        $total2=$total2+$value['nbr']; 
        // print_r($MONTANT);die(); 
    }

    $rapp2="<script type=\"text/javascript\">
    Highcharts.chart('container2', {
      chart: {
        type: 'line'
      },
      title: {
        text: '<b>signalements sur les véhicules</b><br>Le ".date('d-m-Y')."'
      },
      subtitle: {
        text: ''
      },
       xAxis: 
      {
        type: 'category',
        crosshair: true
      },
      yAxis: {
        title: {
          text: ''
        }
      },
      plotOptions: 
    {
      line:
      {
        pointPadding: 0.2,
        borderWidth: 0,
        depth: 40,
        cursor:'pointer',
        point:
        {
          events:
               {
                click: function()
                {
                  $(\"#titre2\").html(\"liste des signalements des incidents sur les véhicules \");
                  $(\"#myModal2\").modal();
                  var row_count ='1000000';
                  $(\"#mytable2\").DataTable({
                  \"processing\":true,
                  \"serverSide\":true,
                  \"bDestroy\": true,
                  \"oreder\":[],
                  \"ajax\":{
                  url:\"".base_url('dashboard/Dashboard_Signalement/detail_Inc_veh')."\",
                  type:\"POST\",
                  data:{
                  key:this.key,
                  DATE1:$('#DATE1').val(),
                  DATE2:$('#DATE2').val(),
                  STATUT:$('#STATUT').val(),
                  SOURCE:$('input[type=radio][name=SOURCE]:checked').val(),
                  PLAQUE:$('input[type=radio][name=PLAQUE]:checked').val(),
                  ANNULATION:$('input[type=radio][name=ANNULATION]:checked').val(),
                  
                }
               },
              lengthMenu: [[10,50, 100, row_count], [10,50, 100, \"All\"]],
              pageLength: 10,
              \"columnDefs\":
              [{
                \"targets\":[],
                \"orderable\":false
              }],
              dom: 'Bfrtlip',
              buttons: [
              'excel', 'print','pdf'
              ],
              language: {
              \"sProcessing\":     \"Traitement en cours...\",
              \"sSearch\":         \"Rechercher&nbsp;:\",
              \"sLengthMenu\":     \"Afficher _MENU_ &eacute;l&eacute;ments\",
              \"sInfo\":           \"Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments\",
              \"sInfoEmpty\":      \"Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment\",
              \"sInfoFiltered\":   \"(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)\",
              \"sInfoPostFix\":    \"\",
              \"sLoadingRecords\": \"Chargement en cours...\",
              \"sZeroRecords\":    \"Aucun &eacute;l&eacute;ment &agrave; afficher\",
              \"sEmptyTable\":     \"Aucune donn&eacute;e disponible dans le tableau\",
              \"oPaginate\": {
              \"sFirst\":      \"Premier\",
              \"sPrevious\":   \"Pr&eacute;c&eacute;dent\",
              \"sNext\":       \"Suivant\",
              \"sLast\":       \"Dernier\"
              },
              \"oAria\":
               {
              \"sSortAscending\":  \": activer pour trier la colonne par ordre croissant\",
              \"sSortDescending\": \": activer pour trier la colonne par ordre d&eacute;croissant\"
              }
          }

        });

        }
      }
    },
    dataLabels: {
    enabled: true,
    format: '{point.y:f}'
    },
    showInLegend: true
    }
    }, 
    credits: 
    {
      enabled: true,
      href: \"\",
      text: \"Mediabox\"
    },
       series: 
        [{
          name: 'Incidents '+' (".$total2.")',
          color: '#557EB2',
          data: [".$donnees_inc_veh."]
        },
        {
          name: 'AMANDES'+' (".$MONTANT.")',
          color: '#D57171',
          data: [".$donnees_inc_veh1."]
        }]
    });
    </script>";
   
    $Inc_agent=$this->Model->getRequete("SELECT au.ID_CONTROLES_QUESTIONNAIRES as IDP, COUNT(au.ID_CONTROLES_QUESTIONNAIRES) as nbr,SUM(q.MONTANT) as montant, q.INFRACTIONS as name FROM signalement_civil_agent_new si JOIN autres_controles au on si.ID_AUTRE_CONTROL=au.ID_AUTRES_CONTROLES JOIN autres_controles_questionnaires q on au.ID_CONTROLES_QUESTIONNAIRES=q.ID_CONTROLES_QUESTIONNAIRES WHERE si.ID_CATEGORIE_SIGNALEMENT=2 ".$critere21." ".$critere_statut." ".$cond1." ".$cond_plaque." ".$critere_annul." GROUP by IDP,name"); 
      $total3=0;
      $donnees_inc_agent="";
      $donnees_mont="";
      $MONTANT=0;
      $categorie_eta="";
        
      foreach ($Inc_agent as  $value)  
      {   
        $key_id1=($value['IDP']>0) ? $value['IDP'] : "0" ;
        $somme=($value['nbr']>0) ? $value['nbr'] : "0" ;
        $MONTANT=number_format($value['montant'],0, ' ', ' ');
        $categorie_eta.="'";
      $name = (!empty($value['name'])) ? $value['name'] : "0" ;

            $rappel1=str_replace("'", "\'", $name);
            
            $categorie_eta.= $rappel1."',";

        $donnees_inc_agent.="{name:'".str_replace("'","\'", $value['name'])."', y:". $somme.",key:".$key_id1."},";
        $donnees_mont.="{name:'".str_replace("'","\'", $value['name'])."', y:". $value['montant'].",key:".$key_id1."},";

        $total3=$total3+$value['nbr'];   
      }

      $rapp3="<script type=\"text/javascript\">
       Highcharts.chart('container3', {
        chart: {
          type: 'column'
        },
        title: {
          text: '<b>signalements sur les agents</b><br>Le ".date('d-m-Y')."'
        },
        xAxis: 
        {
          categories: [".$categorie_eta."],
          crosshair: true
        },
        yAxis: {
          allowDecimals: false,
          min: 0,
          title: {
            text: 'Total: ".$total3."'
          }
        },
        tooltip: {
          formatter: function () {
            return '<b>' + this.x + '</b><br/>' +
              this.series.name + ': ' + this.y + '<br/>' +
              'Total: ' + this.point.stackTotal;
          }
        },
      plotOptions: 
      {
        column:
        {
          pointPadding: 0.2,
          borderWidth: 0,
          depth: 40,
          stacking:'normal',
          cursor:'pointer',
          point:
          {
                events:
                 {
                  click: function()
                  {
                    $(\"#titre3\").html(\"liste des signalements des incidents sur les agents\");
                    $(\"#myModal3\").modal();
                    var row_count ='1000000';
                    $(\"#mytable3\").DataTable({
                    \"processing\":true,
                    \"serverSide\":true,
                    \"bDestroy\": true,
                    \"oreder\":[],
                    \"ajax\":{
                    url:\"".base_url('dashboard/Dashboard_Signalement/detail_Inc_agent')."\",
                    type:\"POST\",
                    data:{
                    key:this.key,
                    DATE1:$('#DATE1').val(),
                    DATE2:$('#DATE2').val(),
                    STATUT:$('#STATUT').val(),
                    SOURCE:$('input[type=radio][name=SOURCE]:checked').val(),
                    PLAQUE:$('input[type=radio][name=PLAQUE]:checked').val(),
                    ANNULATION:$('input[type=radio][name=ANNULATION]:checked').val(),
                  }
                 },
                lengthMenu: [[10,50, 100, row_count], [10,50, 100, \"All\"]],
                pageLength: 10,
                \"columnDefs\":
                [{
                  \"targets\":[],
                  \"orderable\":false
                }],
                dom: 'Bfrtlip',
                buttons: [
                'excel', 'print','pdf'
                ],
                language: {
                \"sProcessing\":     \"Traitement en cours...\",
                \"sSearch\":         \"Rechercher&nbsp;:\",
                \"sLengthMenu\":     \"Afficher _MENU_ &eacute;l&eacute;ments\",
                \"sInfo\":           \"Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments\",
                \"sInfoEmpty\":      \"Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment\",
                \"sInfoFiltered\":   \"(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)\",
                \"sInfoPostFix\":    \"\",
                \"sLoadingRecords\": \"Chargement en cours...\",
                \"sZeroRecords\":    \"Aucun &eacute;l&eacute;ment &agrave; afficher\",
                \"sEmptyTable\":     \"Aucune donn&eacute;e disponible dans le tableau\",
                \"oPaginate\": {
                \"sFirst\":      \"Premier\",
                \"sPrevious\":   \"Pr&eacute;c&eacute;dent\",
                \"sNext\":       \"Suivant\",
                \"sLast\":       \"Dernier\"
                },
                \"oAria\":
                 {
                \"sSortAscending\":  \": activer pour trier la colonne par ordre croissant\",
                \"sSortDescending\": \": activer pour trier la colonne par ordre d&eacute;croissant\"
                }
            }

          });

          }
        }
      },
      dataLabels: {
      enabled: true,
      format: '{point.y:f}'
      },
      showInLegend: true
      }
      }, 
      credits: 
      {
        enabled: true,
        href: \"\",
        text: \"Mediabox\"
      },
         series: 
          [{
            name: 'Incidents '+' (".$total3.")',
            color: '#800080',    
               data: [".$donnees_inc_agent."]
          }]
      });
      </script>";

    $Inc_autr=$this->Model->getRequete("SELECT au.ID_CONTROLES_QUESTIONNAIRES as IDP,COUNT(au.ID_CONTROLES_QUESTIONNAIRES) as nbr,SUM(q.MONTANT) as montant, q.INFRACTIONS as name FROM signalement_civil_agent_new si JOIN autres_controles au on si.ID_AUTRE_CONTROL=au.ID_AUTRES_CONTROLES JOIN autres_controles_questionnaires q on au.ID_CONTROLES_QUESTIONNAIRES=q.ID_CONTROLES_QUESTIONNAIRES WHERE si.ID_CATEGORIE_SIGNALEMENT=3 ".$critere21." ".$critere_statut." ".$cond1." ".$cond_plaque." ".$critere_annul." GROUP by IDP,name");

      $total4=0;
      $donnees_Inc_autr="";
      $MONTANT4=0;
      $donnees_montant_autr="";
        
        foreach ($Inc_autr as  $value)  
        {
          $key_id1=($value['IDP']>0) ? $value['IDP'] : "0" ;
          $somme=($value['nbr']>0) ? $value['nbr'] : "0" ;
          $MONTANT4=number_format($value['montant'],'0', '', '');
          $donnees_Inc_autr.="{name:'".str_replace("'","\'", $value['name'])."', y:". $somme.",key:".$key_id1."},";

         $donnees_montant_autr.="{name:'".str_replace("'","\'", $value['name'])."', y:". $value['montant'].",key:".$key_id1."},";
        
            $total4.=$total4+$value['nbr'];   
    }

    
  $rapp4="<script type=\"text/javascript\">
  Highcharts.chart('container4', {
    chart: {
      type: 'columnpyramid'
    },
    title: {
      text: '<b>autres signalements</b><br> Le ".date('d-m-Y')."'

    },
    subtitle: {
          text: 'Total: ".$total4."'
      },
    colors: ['#C79D6D', '#B5927B', '#CE9B84', '#B7A58C', '#C7A58C'],
    xAxis: {
      crosshair: true,
      labels: {
        style: {
          fontSize: '14px'
        }
      },
      type: 'category'
    },
    yAxis: {
      min: 0,
      title: {
        text: ''
      }
    },
    tooltip: {
    headerFormat: '<span style=\"font-size:10px\">{point.key}</span><table>',
    pointFormat: '<tr><td style=\"color:{series.color};padding:0\">{series.name}: </td>' +
    '<td style=\"padding:0\"><b>{point.y:.f} </b></td></tr>',
    footerFormat: '</table>',
    shared: true,
    useHTML: true
  },
  plotOptions: 
  {
    columnpyramid:
    {
      pointPadding: 0.2,
      borderWidth: 0,
      depth: 40,
      cursor:'pointer',
      point:
      {
            events:
             {
              click: function()
              {
                 $(\"#titre4\").html(\"liste des autres signalements\");
                      $(\"#myModal4\").modal();
                      var row_count ='1000000';
                      $(\"#mytable4\").DataTable({
                      \"processing\":true,
                      \"serverSide\":true,
                      \"bDestroy\": true,
                      \"oreder\":[],
                      \"ajax\":{
                      url:\"".base_url('dashboard/Dashboard_Signalement/detail_Inc_autr')."\",
                      type:\"POST\",
                      data:{
                      key:this.key,
                      DATE1:$('#DATE1').val(),
                      DATE2:$('#DATE2').val(),
                      STATUT:$('#STATUT').val(),
                      SOURCE:$('input[type=radio][name=SOURCE]:checked').val(),
                      PLAQUE:$('input[type=radio][name=PLAQUE]:checked').val(),
                      ANNULATION:$('input[type=radio][name=ANNULATION]:checked').val(),

              }
             },
            lengthMenu: [[10,50, 100, row_count], [10,50, 100, \"All\"]],
            pageLength: 10,
            \"columnDefs\":
            [{
              \"targets\":[],
              \"orderable\":false
            }],
            dom: 'Bfrtlip',
            buttons: [
            'excel', 'print','pdf'
            ],
            language: {
            \"sProcessing\":     \"Traitement en cours...\",
            \"sSearch\":         \"Rechercher&nbsp;:\",
            \"sLengthMenu\":     \"Afficher _MENU_ &eacute;l&eacute;ments\",
            \"sInfo\":           \"Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments\",
            \"sInfoEmpty\":      \"Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment\",
            \"sInfoFiltered\":   \"(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)\",
            \"sInfoPostFix\":    \"\",
            \"sLoadingRecords\": \"Chargement en cours...\",
            \"sZeroRecords\":    \"Aucun &eacute;l&eacute;ment &agrave; afficher\",
            \"sEmptyTable\":     \"Aucune donn&eacute;e disponible dans le tableau\",
            \"oPaginate\": {
            \"sFirst\":      \"Premier\",
            \"sPrevious\":   \"Pr&eacute;c&eacute;dent\",
            \"sNext\":       \"Suivant\",
            \"sLast\":       \"Dernier\"
            },
            \"oAria\":
             {
            \"sSortAscending\":  \": activer pour trier la colonne par ordre croissant\",
            \"sSortDescending\": \": activer pour trier la colonne par ordre d&eacute;croissant\"
            }
        }

      });

      }
    }
  },
  dataLabels: {
  enabled: true,
  format: '{point.y:f}'
  },
  showInLegend: true
  }
  }, 
  credits: 
  {
    enabled: true,
    href: \"\",
    text: \"Mediabox\"
  },
    
    series: [{
     
       name: 'Total des acteurs'+'(".$total4.")',
      color: '#A52A2A',
      data: [".$donnees_Inc_autr."],
      showInLegend: false
    }]
  });
  </script>";
      echo json_encode(array('rapp1'=>$rapp1,'rapp2'=>$rapp2,'rapp3'=>$rapp3,'rapp4'=>$rapp4));
  }
    //fonction détail de signalement par type de categories
  function detail_Signal_TC()
  {
    $KEY=$this->input->post('key1');
    $date1=$this->input->post('DATE1');
    $date2=$this->input->post('DATE2');
    $statut=$this->input->post('STATUT');
    $IS_FROM_AGENT =$this->input->post('SOURCE');
    $HAVE_SEE_PLAQUE =$this->input->post('PLAQUE');
    $ANNULATION =$this->input->post('ANNULATION');

    $cond1='';
    if ($IS_FROM_AGENT!='')
    {
      if ($IS_FROM_AGENT==3) {
        $cond1='';
      }
      else{
      $cond1.=" AND `si`.`IS_FROM_AGENT`=".$IS_FROM_AGENT;
      } 
    }
     
      $cond_plaque='';

    if ($HAVE_SEE_PLAQUE!='')
    { 
      if ($HAVE_SEE_PLAQUE==3) {
     $cond_plaque='';

    }
    else{
      $cond_plaque.=" AND `si`.`HAVE_SEE_PLAQUE`=".$HAVE_SEE_PLAQUE;
    }
    }
 
      $critere_statut="";
    if(!empty($statut))
    {
      $critere_statut="AND `si`.`ID_ALERT_STATUT`=".$statut;
    }

    $critere_annul="";
    if($ANNULATION!='')
    {
      if ($ANNULATION==3) 
      {
         $critere_annul="";
      }
      else
      {
         $critere_annul="AND `si`.`IS_ANNULE`=".$ANNULATION;
      }
    }     
        $critere21="";
     if(!empty($date1) AND !empty($date2) )
     {
        $critere21=" AND date_format(si.DATE_SIGNAL,'%Y-%m-%d') BETWEEN '".$date1."' AND '".$date2."'" ;
     }  
      $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

      $query_principal="SELECT ID_SIGNALEMENT_NEW,`profil`.`STATUT` as PROFIL,`utilisateurs`.`PSR_ELEMENT_ID`,`utilisateurs`.`NOM_CITOYEN`,`utilisateurs`.`PRENOM_CITOYEN`,`psr_elements`.`NOM`,`psr_elements`.`PRENOM`, `si`.`DATE_SIGNAL`, si.IMAGE_UNE,si.IMAGE_DEUX,si.IMAGE_TROIS,`si`.`PLAQUE_NUMERO` FROM `signalement_civil_agent_new` si JOIN `utilisateurs` ON `utilisateurs`.`ID_UTILISATEUR`=`si`.`ID_UTILISATEUR` LEFT JOIN psr_elements ON utilisateurs.PSR_ELEMENT_ID = psr_elements.ID_PSR_ELEMENT LEFT JOIN profil ON `utilisateurs`.`PROFIL_ID`=`profil`.`PROFIL_ID` WHERE 1 ".$critere21." ".$critere_statut." ".$cond1." ".$cond_plaque." ".$critere_annul."";

      //print_r($query_principal);die();

      $limit='LIMIT 0,10';
      if($_POST['length'] != -1){
      $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
      }
      $order_by='';
      if($_POST['order']['0']['column']!=0){
      $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY NOM   DESC';
      }

      $search = !empty($_POST['search']['value']) ? (" AND ( `utilisateurs`.`NOM_UTILISATEUR` LIKE '%$var_search%' OR `si`.`DATE_SIGNAL` LIKE '%$var_search%' OR `si`.`PLAQUE_NUMERO` LIKE '%$var_search%')") : '';

      $critere=' AND `si`.`ID_CATEGORIE_SIGNALEMENT`='.$KEY;
      
      $query_secondaire=$query_principal.' '.$critere.' '.$search.' '.$order_by.'   '.$limit;
      $query_filter=$query_principal.' '.$critere.' '.$search;

      $fetch_data = $this->Model->datatable($query_secondaire);

      $u=0;
      $data = array();
      foreach ($fetch_data as $info)  {

              $u++;
              $post=array();
              $post[]=$u;
              $imag1="";
        $imag2="";
        $imag3="";

        if (!empty($info->IMAGE_UNE)) 
        {
          $imag1="<a href=".$info->IMAGE_UNE." target='_blank'><img alt='Avtar' style='border-radius:50%;width:30px;height:30px' src='".$info->IMAGE_UNE."'></a>";
         }else{
          $imag1="";
         };
         if (!empty($info->IMAGE_DEUX)) 
        {
          $imag2="<a href=".$info->IMAGE_DEUX." target='_blank'><img alt='Avtar' style='border-radius:50%;width:30px;height:30px' src='".$info->IMAGE_DEUX."'></a>";
         }else{
          $imag2="";
         };
        if (!empty($info->IMAGE_TROIS)) 
        {
          $imag3="<a href=".$info->IMAGE_TROIS." target='_blank'><img alt='Avtar' style='border-radius:50%;width:30px;height:30px' src='".$info->IMAGE_TROIS."'></a>";
         }else{
          $imag3="";
         };
        $post[]=$imag1.' '.$imag2.' '.$imag3;


          if ($info->PSR_ELEMENT_ID>0) {
           $post[]=$info->NOM.' '.$info->PRENOM; 
          }
          else{
             $post[]=$info->NOM_CITOYEN.' '.$info->PRENOM_CITOYEN; 
          };

           $post[]=$info->PROFIL; 

              $post[] =$info->PLAQUE_NUMERO;
              $post[]=$info->DATE_SIGNAL; 
               $data[] = $post;
                }
            $output = array(
              "draw" => intval($_POST['draw']),
              "recordsTotal" =>$this->Model->all_data($query_principal),
              "recordsFiltered" => $this->Model->filtrer($query_filter),
              "data" => $data
            );

            echo json_encode($output);
  }    
    //Detail rapport Signalements des incidents sur les Véhicules
  function detail_Inc_veh()
  {
    $KEY=$this->input->post('key');
    $date1=$this->input->post('DATE1');
    $date2=$this->input->post('DATE2');
    $statut=$this->input->post('STATUT');
    $IS_FROM_AGENT =$this->input->post('SOURCE');
    $HAVE_SEE_PLAQUE =$this->input->post('PLAQUE');
    $ANNULATION =$this->input->post('ANNULATION');

    $cond1='';
    if ($IS_FROM_AGENT!='')
    {
      if ($IS_FROM_AGENT==3) {
        $cond1='';
      }
      else{
      $cond1.=" AND `si`.`IS_FROM_AGENT`=".$IS_FROM_AGENT;
      } 
    }
     
      $cond_plaque='';

    if ($HAVE_SEE_PLAQUE!='')
    { 
      if ($HAVE_SEE_PLAQUE==3) {
     $cond_plaque='';

    }
    else{
      $cond_plaque.=" AND `si`.`HAVE_SEE_PLAQUE`=".$HAVE_SEE_PLAQUE;
    }
    }
 
      $critere_statut="";
    if(!empty($statut))
    {
      $critere_statut="AND `si`.`ID_ALERT_STATUT`=".$statut;
    }

    $critere_annul="";
    if($ANNULATION!='')
    {
      if ($ANNULATION==3) 
      {
         $critere_annul="";
      }
      else
      {
         $critere_annul="AND `si`.`IS_ANNULE`=".$ANNULATION;
      }
    }

     
      $critere21="";
   if(!empty($date1) AND !empty($date2) )
   {
      $critere21=" AND date_format(si.DATE_SIGNAL,'%Y-%m-%d') BETWEEN '".$date1."' AND '".$date2."'" ;
   }
             
    $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

    $query_principal="SELECT q.INFRACTIONS,q.MONTANT ,q.DESCRIPTION,si.IMAGE_UNE,si.IMAGE_DEUX,si.IMAGE_TROIS,`profil`.`STATUT` as PROFIL,`utilisateurs`.`PSR_ELEMENT_ID`,`utilisateurs`.`NOM_CITOYEN`,`utilisateurs`.`PRENOM_CITOYEN`,`psr_elements`.`NOM`,`psr_elements`.`PRENOM`,utilisateurs.NOM_UTILISATEUR,si.DATE_SIGNAL,si.PLAQUE_NUMERO FROM signalement_civil_agent_new si JOIN autres_controles au on si.ID_AUTRE_CONTROL=au.ID_AUTRES_CONTROLES JOIN autres_controles_questionnaires q on au.ID_CONTROLES_QUESTIONNAIRES=q.ID_CONTROLES_QUESTIONNAIRES LEFT JOIN utilisateurs ON si.ID_UTILISATEUR=utilisateurs.ID_UTILISATEUR LEFT JOIN psr_elements ON utilisateurs.PSR_ELEMENT_ID = psr_elements.ID_PSR_ELEMENT LEFT JOIN profil ON `utilisateurs`.`PROFIL_ID`=`profil`.`PROFIL_ID` WHERE si.ID_CATEGORIE_SIGNALEMENT=1 ".$critere21." ".$critere_statut." ".$cond1." ".$cond_plaque." ".$critere_annul."";

    $limit='LIMIT 0,10';
    if($_POST['length'] != -1){
    $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
    }
    $order_by='';
    if($_POST['order']['0']['column']!=0){
    $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY NOM   DESC';
    }

    $search = !empty($_POST['search']['value']) ? (" AND (q.INFRACTIONS LIKE '%$var_search%' OR q.MONTANT LIKE '%$var_search%' OR q.DESCRIPTION LIKE '%$var_search%' OR utilisateurs.NOM_UTILISATEUR LIKE '%$var_search%' OR si.DATE_SIGNAL LIKE '%$var_search%' OR si.PLAQUE_NUMERO LIKE '%$var_search%')") : '';

    $CRITERE =" and q.ID_CONTROLES_QUESTIONNAIRES=".$KEY;

    $query_secondaire=$query_principal.' '.$search.' '.$CRITERE .' '.$order_by.'   '.$limit;
    $query_filter=$query_principal.' '.$CRITERE .' '.$search;

    $fetch_data = $this->Model->datatable($query_secondaire);

    $u=0;
    $data = array();
    foreach ($fetch_data as $info)  
      {
        $u++;
        $post=array();
        $post[]=$u;
        $imag1="";
        $imag2="";
        $imag3="";

        if (!empty($info->IMAGE_UNE)) 
        {
          $imag1="<a href=".$info->IMAGE_UNE." target='_blank'><img alt='Avtar' style='border-radius:50%;width:30px;height:30px' src='".$info->IMAGE_UNE."'></a>";
         }else{
          $imag1="";
         };
         if (!empty($info->IMAGE_DEUX)) 
        {
          $imag2="<a href=".$info->IMAGE_DEUX." target='_blank'><img alt='Avtar' style='border-radius:50%;width:30px;height:30px' src='".$info->IMAGE_DEUX."'></a>";
         }else{
          $imag2="";
         };
        if (!empty($info->IMAGE_TROIS)) 
        {
          $imag3="<a href=".$info->IMAGE_TROIS." target='_blank'><img alt='Avtar' style='border-radius:50%;width:30px;height:30px' src='".$info->IMAGE_TROIS."'></a>";
         }else{
          $imag3="";
         };
        $post[]=$imag1.' '.$imag2.' '.$imag3;

        if ($info->PSR_ELEMENT_ID>0) {
               $post[]=$info->NOM.' '.$info->PRENOM; 
              }
              else{
                 $post[]=$info->NOM_CITOYEN.' '.$info->PRENOM_CITOYEN; 
              };

              $post[]=$info->PROFIL; 
     
        $post[]=$info->DATE_SIGNAL;
        $post[]=$info->PLAQUE_NUMERO;
        $post[]=$info->DESCRIPTION;
        $post[] =$info->MONTANT; 

         $data[] = $post;
      }

      $output = array(
        "draw" => intval($_POST['draw']),
        "recordsTotal" =>$this->Model->all_data($query_principal),
        "recordsFiltered" => $this->Model->filtrer($query_filter),
        "data" => $data
      );
      echo json_encode($output);
  }
    //Detail Signalements des incidents sur les agents
  function detail_Inc_agent()
  {
    $KEY=$this->input->post('key');
    $date1=$this->input->post('DATE1');
    $date2=$this->input->post('DATE2');
    $statut=$this->input->post('STATUT');
    $IS_FROM_AGENT =$this->input->post('SOURCE');
    $HAVE_SEE_PLAQUE =$this->input->post('PLAQUE');
    $ANNULATION =$this->input->post('ANNULATION');

    $cond1='';
    if ($IS_FROM_AGENT!='')
    {
      if ($IS_FROM_AGENT==3) {
        $cond1='';
      }
      else{
      $cond1.=" AND `si`.`IS_FROM_AGENT`=".$IS_FROM_AGENT;
      } 
    }
     
      $cond_plaque='';

    if ($HAVE_SEE_PLAQUE!='')
    { 
      if ($HAVE_SEE_PLAQUE==3) {
     $cond_plaque='';

    }
    else{
      $cond_plaque.=" AND `si`.`HAVE_SEE_PLAQUE`=".$HAVE_SEE_PLAQUE;
    }
    }
 
      $critere_statut="";
    if(!empty($statut))
    {
      $critere_statut="AND `si`.`ID_ALERT_STATUT`=".$statut;
    }

    $critere_annul="";
    if($ANNULATION!='')
    {
      if ($ANNULATION==3) 
      {
         $critere_annul="";
      }
      else
      {
         $critere_annul="AND `si`.`IS_ANNULE`=".$ANNULATION;
      }
    }    
      $critere21="";
   if(!empty($date1) AND !empty($date2) )
   {
      $critere21=" AND date_format(si.DATE_SIGNAL,'%Y-%m-%d') BETWEEN '".$date1."' AND '".$date2."'" ;
   }
          
          $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

          $query_principal="SELECT q.INFRACTIONS,q.MONTANT ,q.DESCRIPTION,si.IMAGE_UNE,si.IMAGE_DEUX,si.IMAGE_TROIS,`profil`.`STATUT` as PROFIL,ID_SIGNALEMENT_NEW,`utilisateurs`.`PSR_ELEMENT_ID`,`utilisateurs`.`NOM_CITOYEN`,`utilisateurs`.`PRENOM_CITOYEN`,`psr_elements`.`NOM`,`psr_elements`.`PRENOM`,si.DATE_SIGNAL,si.PLAQUE_NUMERO FROM signalement_civil_agent_new si JOIN autres_controles au on si.ID_AUTRE_CONTROL=au.ID_AUTRES_CONTROLES JOIN autres_controles_questionnaires q on au.ID_CONTROLES_QUESTIONNAIRES=q.ID_CONTROLES_QUESTIONNAIRES LEFT JOIN utilisateurs ON si.ID_UTILISATEUR=utilisateurs.ID_UTILISATEUR LEFT JOIN psr_elements ON utilisateurs.PSR_ELEMENT_ID = psr_elements.ID_PSR_ELEMENT LEFT JOIN profil ON `utilisateurs`.`PROFIL_ID`=`profil`.`PROFIL_ID` WHERE si.ID_CATEGORIE_SIGNALEMENT=2 ".$critere21." ".$critere_statut." ".$cond1." ".$cond_plaque." ".$critere_annul."";

          $limit='LIMIT 0,10';
          if($_POST['length'] != -1){
          $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
          }
          $order_by='';
          if($_POST['order']['0']['column']!=0){
          $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY NOM   DESC';
          }

          $search = !empty($_POST['search']['value']) ? ("AND (q.INFRACTIONS LIKE '%$var_search%' OR q.MONTANT LIKE '%$var_search%' OR q.DESCRIPTION LIKE '%$var_search%' OR utilisateurs.NOM_UTILISATEUR LIKE '%$var_search%' OR si.DATE_SIGNAL LIKE '%$var_search%' OR si.PLAQUE_NUMERO LIKE '%$var_search%')") : '';

          
          $query_secondaire=$query_principal.' '.$search.' '.$order_by.'   '.$limit;
          $query_filter=$query_principal.' '.$search;

          $fetch_data = $this->Model->datatable($query_secondaire);

          $u=0;
          $data = array();
          foreach ($fetch_data as $info)  {

                  $u++;
                  $post=array();
                  $post[]=$u;
        $imag1="";
        $imag2="";
        $imag3="";

        if (!empty($info->IMAGE_UNE)) 
        {
          $imag1="<a href=".$info->IMAGE_UNE." target='_blank'><img alt='Avtar' style='border-radius:50%;width:30px;height:30px' src='".$info->IMAGE_UNE."'></a>";
         }else{
          $imag1="";
         };
         if (!empty($info->IMAGE_DEUX)) 
        {
          $imag2="<a href=".$info->IMAGE_DEUX." target='_blank'><img alt='Avtar' style='border-radius:50%;width:30px;height:30px' src='".$info->IMAGE_DEUX."'></a>";
         }else{
          $imag2="";
         };
        if (!empty($info->IMAGE_TROIS)) 
        {
          $imag3="<a href=".$info->IMAGE_TROIS." target='_blank'><img alt='Avtar' style='border-radius:50%;width:30px;height:30px' src='".$info->IMAGE_TROIS."'></a>";
         }else{
          $imag3="";
         };
        $post[]=$imag1.' '.$imag2.' '.$imag3;

                  
              if ($info->PSR_ELEMENT_ID>0) {
               $post[]=$info->NOM.' '.$info->PRENOM; 
              }
              else{
                 $post[]=$info->NOM_CITOYEN.' '.$info->PRENOM_CITOYEN; 
              };

              $post[]=$info->PROFIL; 
                  $post[]=$info->DATE_SIGNAL;
                  $post[]=$info->DESCRIPTION;
                   $data[] = $post;
                    }
                $output = array(
                  "draw" => intval($_POST['draw']),
                  "recordsTotal" =>$this->Model->all_data($query_principal),
                  "recordsFiltered" => $this->Model->filtrer($query_filter),
                  "data" => $data
                );

                echo json_encode($output);
            }
           //Detail rapport Autres Signalements des incidents
           function detail_Inc_autr()
           {

    $KEY=$this->input->post('key');
    $date1=$this->input->post('DATE1');
    $date2=$this->input->post('DATE2');
    $statut=$this->input->post('STATUT');
    $IS_FROM_AGENT =$this->input->post('SOURCE');
    $HAVE_SEE_PLAQUE =$this->input->post('PLAQUE');
    $ANNULATION =$this->input->post('ANNULATION');

    $cond1='';
    if ($IS_FROM_AGENT!='')
    {
      if ($IS_FROM_AGENT==3) {
        $cond1='';
      }
      else{
      $cond1.=" AND `si`.`IS_FROM_AGENT`=".$IS_FROM_AGENT;
      } 
    }
     
      $cond_plaque='';
    if ($HAVE_SEE_PLAQUE!='')
    { 
      if ($HAVE_SEE_PLAQUE==3) {
     $cond_plaque='';

    }
    else{
      $cond_plaque.=" AND `si`.`HAVE_SEE_PLAQUE`=".$HAVE_SEE_PLAQUE;
    }
    }
 
      $critere_statut="";
    if(!empty($statut))
    {
      $critere_statut="AND `si`.`ID_ALERT_STATUT`=".$statut;
    }

    $critere_annul="";
    if($ANNULATION!='')
    {
      if ($ANNULATION==3) 
      {
         $critere_annul="";
      }
      else
      {
         $critere_annul="AND `si`.`IS_ANNULE`=".$ANNULATION;
      }
    }
      $critere21="";
   if(!empty($date1) AND !empty($date2) )
   {
      $critere21=" AND date_format(si.DATE_SIGNAL,'%Y-%m-%d') BETWEEN '".$date1."' AND '".$date2."'" ;
   }     
          $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
          $query_principal="SELECT q.INFRACTIONS,q.MONTANT ,q.DESCRIPTION,si.IMAGE_UNE,si.IMAGE_DEUX,si.IMAGE_TROIS,`profil`.`STATUT` as PROFIL,ID_SIGNALEMENT_NEW,`utilisateurs`.`PSR_ELEMENT_ID`,`utilisateurs`.`NOM_CITOYEN`,`utilisateurs`.`PRENOM_CITOYEN`,`psr_elements`.`NOM`,`psr_elements`.`PRENOM`,si.DATE_SIGNAL,si.PLAQUE_NUMERO FROM signalement_civil_agent_new si JOIN autres_controles au on si.ID_AUTRE_CONTROL=au.ID_AUTRES_CONTROLES JOIN autres_controles_questionnaires q on au.ID_CONTROLES_QUESTIONNAIRES=q.ID_CONTROLES_QUESTIONNAIRES LEFT JOIN utilisateurs ON si.ID_UTILISATEUR=utilisateurs.ID_UTILISATEUR LEFT JOIN psr_elements ON utilisateurs.PSR_ELEMENT_ID = psr_elements.ID_PSR_ELEMENT  LEFT JOIN profil ON `utilisateurs`.`PROFIL_ID`=`profil`.`PROFIL_ID` WHERE si.ID_CATEGORIE_SIGNALEMENT=3 ".$critere21." ".$critere_statut." ".$cond1." ".$cond_plaque." ".$critere_annul."";

          $limit='LIMIT 0,10';
          if($_POST['length'] != -1){
          $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
          }
          $order_by='';
          if($_POST['order']['0']['column']!=0){
          $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY NOM   DESC';
          }

          $search = !empty($_POST['search']['value']) ? ("AND (q.INFRACTIONS LIKE '%$var_search%' OR q.MONTANT LIKE '%$var_search%' OR q.DESCRIPTION LIKE '%$var_search%' OR utilisateurs.NOM_UTILISATEUR LIKE '%$var_search%' OR si.DATE_SIGNAL LIKE '%$var_search%' OR si.PLAQUE_NUMERO LIKE '%$var_search%')") : '';

          $query_secondaire=$query_principal.' '.$search.' '.$order_by.'   '.$limit;
          $query_filter=$query_principal.' '.$search;

          $fetch_data = $this->Model->datatable($query_secondaire);

          $u=0;
          $data = array();
          foreach ($fetch_data as $info)  {

          $u++;
          $post=array();
          $post[]=$u;
          $imag1="";
          $imag2="";
          $imag3="";

        if (!empty($info->IMAGE_UNE)) 
        {
          $imag1="<a href=".$info->IMAGE_UNE." target='_blank'><img alt='Avtar' style='border-radius:50%;width:30px;height:30px' src='".$info->IMAGE_UNE."'></a>";
         }
         else
         {
          $imag1="";
         };
         if (!empty($info->IMAGE_DEUX)) 
        {
          $imag2="<a href=".$info->IMAGE_DEUX." target='_blank'><img alt='Avtar' style='border-radius:50%;width:30px;height:30px' src='".$info->IMAGE_DEUX."'></a>";
         }else{
          $imag2="";
         };
        if (!empty($info->IMAGE_TROIS)) 
        {
          $imag3="<a href=".$info->IMAGE_TROIS." target='_blank'><img alt='Avtar' style='border-radius:50%;width:30px;height:30px' src='".$info->IMAGE_TROIS."'></a>";
         }
         else
         {
          $imag3="";
         };
        $post[]=$imag1.' '.$imag2.' '.$imag3;
            if ($info->PSR_ELEMENT_ID>0) {
               $post[]=$info->NOM.' '.$info->PRENOM; 
              }
              else{
                 $post[]=$info->NOM_CITOYEN.' '.$info->PRENOM_CITOYEN; 
              };
            $post[]=$info->PROFIL; 
            $post[]=$info->DATE_SIGNAL;
            $post[]=$info->PLAQUE_NUMERO;
            $post[]=$info->DESCRIPTION;
             $data[] = $post;
              }
          $output = array(
            "draw" => intval($_POST['draw']),
            "recordsTotal" =>$this->Model->all_data($query_principal),
            "recordsFiltered" => $this->Model->filtrer($query_filter),
            "data" => $data
          );
      echo json_encode($output);
  }
}
?>