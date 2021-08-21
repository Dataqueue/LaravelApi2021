<?php
define('DIR', '../');
require_once DIR . 'config.php';
$admin = new Admin();
 //$control->getCSS(DIR); ?>
<?php
$special=$_GET['q'];
$adc=$admin->ret("SELECT * FROM `doctors` inner join
`degrees` on `doctors`.drid=`degrees`.drid and specialization like '".$special."%'"); ?> 
      
          <?php  
          while ($row = $adc->fetch(PDO::FETCH_ASSOC)){
            echo
            '<div class="col-md-4">
            <div class="card flex-md-row mb-4 box-shadow h-md-200">
              <div class="card-body d-flex flex-column align-items-start">
                <h3 class="mb-0">
                  <a class="text-dark" href="#">'.$row['dname'].'</a>
                </h3>
                <p class="card-text mb-auto">Find the right family Doctor nearby.</p>
                <a href="" onclick="Searchspecial('.$row['specialization'].')">Search>></a>
              </div>
              <img class="card-img-right flex-auto d-none d-md-block" src="images/phisician.jpg" alt="Card image cap">
            </div>
          </div>';    
          }
          ?>
