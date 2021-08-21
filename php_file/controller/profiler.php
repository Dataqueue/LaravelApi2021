<?php
define('DIR', '../');
require_once DIR . 'config.php';
$admin = new Admin();
 //$control->getCSS(DIR); ?>
<?php
$special=$_GET['q'];
$adc=$admin->ret('SELECT `doctors`.`drid`, `dname`, `demail`, `contact`, `place`, `password`, `dob`, `gender`,`deid`, `dename`, `ststate`, `collage`, `university`, `yearcomp`, `certificate`, `specialization`,`afid`, `state`, `mrno`, `mrcouncil`, `mrcertificate`,(YEAR(CURDATE())-mryear) as exp FROM `doctors` inner join
`degrees` on `doctors`.drid=`degrees`.drid and `doctors`.drid='.$special.' inner join `affiliation` on `doctors`.drid=`affiliation`.drid and `doctors`.drid='.$special); 

?> 
   
          <?php  
          while ($row = $adc->fetch(PDO::FETCH_ASSOC)){
            echo
            '<div class="flex-auto col-md-8">
            <div class="card flex-md-row mb-4 box-shadow h-md-200">
            <div class="mb-0">
             <img class="card-img-left d-none d-md-block" src="images/placeholder.jpg" alt="Card image cap" style="padding:25px 0 0 20px;">
             </div>
              <div class="card-body d-flex flex-column align-items-start">
                <h3 class="mb-0">
                  <a class="text-dark" href="#">Dr.'.$row['dname'].'</a>
                </h3>
                <p class="card-text mb-auto"><label>Qualifications</label> '.$row['dename'].'</p>
                <p class="card-text mb-auto"><label>Speciality</label> '.$row['specialization'].'</p>
                <p class="card-text mb-auto"><label>Experience</label> '.$row['exp'].' year</p>
                <p class="card-text mb-auto"><label>Medical Reg no.</label> '.$row['mrno'].'</p>
                <p class="card-text mb-auto"><label>Medical Council</label> '.$row['mrcouncil'].'</p>
                <span id="dots0">...</span>
                <span id="more0">
                    <p align="left" class="card-text mb-auto">Practising Location</p>
                    <p align="left" class="card-text mb-auto">Working Location</p>
                    <p align="left" class="card-text mb-auto">Practising Location</p>
                    <p align="left" class="card-text mb-auto">Practising Location</p>
                </span>
                <span onclick="myFunction(0)" id="myBtn0" style="color:#007bff;">Read more</span>
                <a href="specidoctor.php?docr='.$row['specialization'].'"><i class="fa fa-arrow-left">Back</i></a>
              </div>
            </div>
          </div><div class="flex-auto col-md-4"><div class="card flex-auto box-shadow h-md-200" "><img src="images/pedi.jpg" alt="Card image ad" style="max-height:450px;"></img></div></div>';    
          }
          ?>
