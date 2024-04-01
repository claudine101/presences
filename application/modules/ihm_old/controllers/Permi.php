<?php
class Permis extends CI_Controller
{

        function index($id=0)
        {

                $Permis=$this->Modele->getRequeteOne("SELECT `ID_PERMIS`, `NUMERO_PERMIS`, `NOM_PROPRIETAIRE`, `CATEGORIES`, `DATE_NAISSANCE`, `DATE_DELIVER`, `DATE_EXPIRATION` FROM `chauffeur_permis` WHERE ID_PERMIS=".$id);


                $rapport = $this->Modele->getRequete("SELECT SUM(`MONTANT`) AS AMANDE, DATE_FORMAT(h.DATE_INSERTION, '%d-%m-%Y') AS JOURS FROM historiques h  WHERE NUMERO_PERMIS='".$Permis['NUMERO_PERMIS']."' GROUP by DATE_FORMAT(h.DATE_INSERTION, '%d-%m-%Y')");



                $nombre=0;

                $donne = "";
                $catego = "";
                $datas = "";

                if (!empty($rapport)) {

                        foreach ($rapport as  $value) 
                        {
                            $mm = !empty($value['AMANDE']) ? $value['AMANDE'] : 0;
                            $date  =  !empty($value['JOURS']) ? $value['JOURS'] : date('d-m-Y');
                            $catego.= "'".$date."',";
                            $datas .=  $mm.",";
                            $nombre+=$value['AMANDE'];

                    }

            }else{

                    $mm = 0;
                    $date  =   date('d-m-Y');
                    $catego.= "'".$date."',";
                    $datas .=  $mm.",";
                    $nombre+=$mm;
            }

            $catego.= "@";
            $catego= str_replace(",@", "", $catego);

            $datas.= "@";
            $datas = str_replace(",@", "", $datas);


            $donne .="{
                name: 'Amande',
                data: [".$datas."]
        },";





        $data['catego'] = $catego;
        $data['donne'] = $donne;
        $data['total'] = $nombre;



        $data['title']= "Permis Utilisateur";
        $data['Permis']=$Permis;
        $data=$this->load->view('Permis_View',$data);

}





}
?>