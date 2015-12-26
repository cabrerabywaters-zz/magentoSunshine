   

 <div class="container" style="margin-top:100px">
      <div class="col-md-12">
<?php
require_once( '../app/Mage.php' );
umask(0);

 Mage::app();




?>
  
         <form method="GET" action="commissionResults.php">
         
            <div class="form-group">
               
              <label for="exampleInputEmail1">Buscar</label>
                    <input type="text" class="form-control" name="search" id="search" placeholder="Comienza a buscar por Mail o Nombre" required>
             </div>

              <div class="form-group">
               
              <label for="month">Seleccionar Mes del Año</label>
                     <select name="month" required>
                            <option value="1">Enero</option>
                            <option value="2">Febrero</option>
                            <option value="3">Marzo</option>
                            <option value="4">Abril</option>
                            <option value="5">Mayo</option>
                            <option value="6">Junio</option>
                            <option value="7">Julio</option>
                            <option value="8">Agosto</option>
                            <option value="9">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                    </select>
             </div>
              <div class="form-group">
               
              <label for="year">Seleccionar Año</label>
                     <select name="year" required>
                            <option value="2015">2015</option>
                            <option value="2016">2016</option>
                      </select>
             </div>

            <button type="submit" class="btn btn-success btn-lg btn-block">CALCULAR COMISION</button>
        </form>

       
       </div>
      

    </div><!-- /.container -->


