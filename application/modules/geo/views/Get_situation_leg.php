
 
  <div class="row" style="">
    <div class="col-md-9">
      <label>Catégories</label>
      <select class="form-control"  onchange="getMaps()" name="ID_CATEGORIE" id="ID_CATEGORIE">
       <option value="">Sélectionner</option>
      <?php

      foreach ($categorie as $value){
      if ($value['ID_CATEGORIE'] == set_value('ID_CATEGORIE'))
      {?>
      <option value="<?=$value['ID_CATEGORIE']?>" selected><?=$value['DESCRIPTION']?></option>
      <?php } else{ 
       ?>
      <option value="<?=$value['ID_CATEGORIE']?>" ><?=$value['DESCRIPTION']?></option>
      <?php } } ?>
            </select>
    </div>
    <div class="col-md-3">
      <br>
      <button title="Autre filtre" onclick="getModal()" style="margin-top: 6px" type="button" class="btn btn-secondary btn-block"> <i class="fa fa-filter"></i> </button>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <!-- <label>Elément de la RECECA-INKINGI</label> -->
      <form id="form_data">
      <div class="input-group">


      <div class="input-group-prepend">
       <!--  <span class="input-group-text">
          <i id="default_loading" class="fa fa-search" aria-hidden="true"></i>
          <i id="loading"></i>
        </span> -->
        
      </div>
    </div>
    </form>
     <!--  <span class="result"></span> -->
    </div>
  </div>
  <div>

                           
  </div>

            <div>
    

       
  </div><br>
             <strong>Dix dernières vérifications</strong>
  <hr>
            <div id="demo" class="carousel slide" data-ride="carousel">

  <!-- Indicators -->
  <ul class="carousel-indicators">
    <li data-target="#demo" data-slide-to="0" class="active"></li>
    <li data-target="#demo" data-slide-to="1"></li>
    <li data-target="#demo" data-slide-to="2"></li>
  </ul>

  <!-- The slideshow -->
  <div class="carousel-inner">


    <?php 

    $i=0;
    foreach ($dernier_2 as $key => $value) {

     $i++;
     $indic=0;
     $active='';
     
     if ($i==1) {
     $active='active';
     }

    //$indic='Vérification dernière N° '.$i;
    $indic='Dernier contrôle '.$i.'/10';
    
    $middle = strtotime($value['DATE_INSERTION']);           

    $new_date = date('d-m-Y H:i', $middle);
     
     ?>
    <div class="carousel-item <?=$active?>">

      <div class="card-body text-center">
      
      <h5 class="trans"><?=$indic?></h5> Poste: <?= $value['LIEU_EXACTE']?><br>
      <?=$value['DESCRIPTION']?> <br>Agent <?= $value['NOM']?> <?= $value['PRENOM']?><br>
      <?=$value['NUMERO']?><br>
      N° matricule <?= $value['NUMERO_MATRICULE'] ?>.<br>
       <?= $new_date ?><br>
      
      </div>

      
    </div>

   <?php  }  ?>
    
  </div>
 

  <!-- Left and right controls margin-left: -80px -->
  <a  class="carousel-control-prev" href="#demo" data-slide="prev">
    <span style="background-color: black;" class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#demo" data-slide="next">
    <span style="background-color: black;"  class="carousel-control-next-icon"></span>
  </a>

</div>
<br>
             
          
      <div id='legend' style='background: transparent;'>
  <strong>Légende</strong>
  <hr>
  <nav class='legend'>
     
     <table class="" width="100%">

        <?= $labels?>

     
         
          <tr>
         <td width="100%"><span style='background:#848484;width: 15px;height: 15px;border-radius: 10px;'></span>
         &emsp;<input type="checkbox" checked  name="opt4">  Contrôle annulé (<a href="#" onclick="getincident(4)"><?=number_format($Scan,0,',',' ')?></a>)</td>
         </tr>

         <!-- <tr>
         <td><label style='background:#37AC02;width: 16px;height: 15px;border-radius: 10px;'></label></td>
         <td>&emsp;Dernier incident (<a href="#" onclick="getincident(4)"><?=number_format($fermenonavere,0,',',' ')?></a>)</td>
         </tr> -->
         
            
       
     </table>
    
     
    <small>Source: <a href="#link to source">MediaBox</a></small>
  </nav>
</div>  
<br> 


    
    <button type="button" class="btn btn-primary form-control"><a href="<?php echo base_url();?>/PSR/Historique" style="color:#fff"> Historiques >></a> </button>
 
</div>
</div>


