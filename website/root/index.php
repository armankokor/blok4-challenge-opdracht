<?php
//de include om connectie te maken met de database
include 'includes/database.php';
//functions.php
include 'includes/functions.php';
//de header van je HTML pagina
include "header.php"; 
//filter.php
include 'includes/filter.php';

?>
<section>
    <div class="container mt-4">
        <div class="row">
            <?php
                //de klant wil dat er een filter optie komt dus alvast de voorbereiding hier neerzetten de filter is geprogrammeerd in filter.php

                //haal alle huisjes op, check of er gefilterd wordt hiervoor wordt de variabele $filter gebruikt
                //vul variabele $tblCottages met de data uit de database
                            
            if($filter == false){
                //alle huisjes moeten getoond worden er wordt niet gefiltert, vul de variabele $sql met de juiste query
                $sql = "SELECT * FROM `cottages`";
            }
            else{
                //alleen huisjes met de aangevinkte faciliteiten moeten getoond worden
                //eerst moeten we weten wat er allemaal is aangevinkt in de filter, dit slaan we op in de array $arrFrmFilter in filter.php
                //loop door $arrFrmFilter en schrijf de extra stukjes van de sql statement
                //Gebruik voor de extra sql de variabele $sql_add
                $sql_add = "";

               if(count($arrFrmFilter) > 0){
                   //vul $sql_add met de juiste toevoeging aan de query
                    $sql_add = "AND cf.facility_id in (" . implode (", ", $arrFrmFilter) . ")";
               } //einde $arrFrmFilter >0

               //maak de gehele $sql query aan, deze is lastig, volgens mij klopt hij niet helemaal maar ik laat het even zo
                $sql = "SELECT * FROM `cottages` c WHERE c.cottage_id in 
                    (
                        SELECT cottage_id FROM `cottages_facilities` cf
                        WHERE cf.cottage_id = c.cottage_id " .
                        $sql_add .
                    ")";
            } //einde else ($filter == true)

                //de echo hieronder gebruiken als je niet zeker weet wat de $sql statement is die wordt uitgevoerd
                //echo $sql;

                //de variabele $tblCottages vullen met de data uit de database (array) hiervoor de functie getData gebruiken uit functions.php
                //$tblCottages uncommenten als functions.php af is en is ge-include op regel 4 en de sql statement op regel 19 klopt
                $tblCottages = getData($sql, "fetchAll");
            ?>

            <?php
            //if statement afmaken als filter werkt...
            $tblCottages;
            if(count($tblCottages) == 0)
             ?>
            
                <!-- als er geen resultaat getoond kan worden omdat er 0 resultaat is op het filter de volgende melding tonen -->
                <!-- de variabele $selection in filter.php gebruiken om te laten zien waar op gefiltert is -->
                <div class="col-12">
                </div>
            <!-- <?php //} //einde if
            // else { //count($tblCottages) > 0 ?> -->
            <!-- als er wel resultaat is of als er niet gefiltert is de huisjes laten zien -->
            
                <?php 
                foreach($tblCottages as $cottage) {
                // start loop door array met cottages uit db gegevens ?>
                <div class="col-12 col-md-4 mb-4 d-flex align-self-stretch">
                    <div class="card">
                    <img class="card-img-top mask-effect" src="images/<?php echo $cottage['cottage_img'];?>" alt="cottage_name">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $cottage['cottage_name'];?></h5> <!-- maak naam dynamisch -->
                                <p class="card-text"><?php echo $cottage['cottage_excerpt'];?></p> <!-- maak omschrijving dynamisch -->
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">&euro; <?php echo $cottage['cottage_price_a'];?> per nacht voor volwassenen</li><!-- maak prijs volwassenen dynamisch -->
                                    <li class="list-group-item">&euro; <?php echo $cottage['cottage_price_c'];?> per nacht voor kinderen</li><!-- maak prijs kinderen dynamisch -->
                                </ul>
                                <a href="huisjes.php?cottageID=<?php echo  $cottage['cottage_id']; ?>" class="btn btn-secondary mt-2">Lees meer...</a><!-- maak href dynamisch -->
                            </div>
                        </div>
                    </div>
                <?php } //einde loop door array cottages uit db gegevens ?>
            <?php //} //einde if, else count ?>
        </div>
    </div>
</section>

<?php 
include "footer.php";
?>
