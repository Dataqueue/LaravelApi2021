
<?php
define('DIR', '../');
require_once DIR . 'config.php';
$admin = new Admin();

 
$special=$_GET['q'];
$adc=$admin->ret("SELECT * FROM  `degrees` where specialization like '".$special."%'"); ?> 
      
          <?php  
          while ($row = $adc->fetch(PDO::FETCH_ASSOC)){
            echo
            '<div class="col-md-4">
            <div class="card flex-md-row mb-4 box-shadow h-md-200">
              <div class="card-body d-flex flex-column align-items-start">
                <h3 class="mb-0">
                  <a class="text-dark" href="#">'.$row['specialization'].'</a>
                </h3>
                <p class="card-text mb-auto">Find the right family Doctor nearby.</p>
                <button value="'.$row['specialization'].'" onclick="Searchspecial(this.value)" class="btn btn-sm btn-outline-success">Search>></a>
              </div>
              <img class="card-img-right flex-auto d-none d-md-block" src="images/phisician.jpg" alt="Card image cap">
            </div>
          </div>';    
          }
          ?>
      