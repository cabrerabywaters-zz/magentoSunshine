<!DOCTYPE>
<html lang="en">

<head>
    <title>Calculo Comision</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="generator" content="Geany 1.23.1" />
</head>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script src="http://cdn.jsdelivr.net/typeahead.js/0.9.3/typeahead.min.js"></script>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">

<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<style>

.navbar-inverse .navbar-nav>.active>a, .navbar-inverse .navbar-nav>.active>a:hover, .navbar-inverse .navbar-nav>.active>a:focus {
    color: #49692D;
    background-color: #BDB8B8;
}
.navbar-inverse .navbar-nav>li>a {
    color: white;
}

.navbar-inverse .navbar-brand {
    color: white;
}

.navbar-inverse {
    background-color: #63A70A;
    border-color: #63A70A;
    color: white;
}
span.twitter-typeahead {
    width: 100%;
}

input.tt-hint {
  color:transparent;
}

.tt-dropdown-menu {
    width: 422px;
    margin-top: 12px;
    padding: 8px 0;
    background-color: #fff;
    border: 1px solid #ccc;
    border: 1px solid rgba(0, 0, 0, 0.2);
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    border-radius: 8px;
    -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
    -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
    box-shadow: 0 5px 10px rgba(0,0,0,.2);
}

.tt-suggestion {
    padding: 3px 20px;
    font-size: 18px;
    line-height: 24px;
}

.tt-suggestion.tt-is-under-cursor {
    color: #fff;
    background-color: #0097cf;

}
</style>
<script>
$(document).ready(function(){
    $("#search").typeahead({

  
        name : 'search',
        remote: {
            url : 'connection.php?query=%QUERY'
        }
       
    });
});
</script>
<body>

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
            <li class="active"><a href="buscador.php">Nuevo Cálculo</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container" style="margin-top:100px">
      <div class="col-md-12">
  
         <form method="GET" action="commissionResults.php">
         
            <div class="form-group">
               
              <label for="exampleInputEmail1">Buscar</label>
                    <input type="text" class="form-control" name="search" id="search" placeholder="Comienza a buscar por Mail o Nombre">
             </div>
           

            <button type="submit" class="btn btn-success btn-lg btn-block">CALCULAR COMISION</button>
        </form>

       
       </div>
      

    </div><!-- /.container -->


</body>




</html>