<?php
function ActiveIfIsOnPage($requestUri)
{

  $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");
  $isActive = false;
  foreach ($requestUri as $key => $value) {
     if ($current_file_name == $value)
     {
        $isActive = true;
     }
  }

      if($isActive)
      {
        echo 'class="active"';
      }
}


?>

<nav class="navbar navbar-inverse navbar-fixed-top" >
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Sunshine Andina.</a>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li <?php ActiveIfIsOnPage(array('commissionSearch','commissionResults'))?>><a href="commissionSearch.php">Nuevo Cálculo</a></li>
        <li <?php ActiveIfIsOnPage(array('couponSearch','couponResults'))?>><a href="couponSearch.php">Buscar Cupón</a></li>
        
      </ul>
      </div><!--/.nav-collapse -->
    </div>
  </nav>