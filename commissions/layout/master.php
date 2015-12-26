<!DOCTYPE>
<html lang="en">

<head>
    <title>Cálculo Comisiones Sunshine</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="generator" content="Geany 1.23.1" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

	<script src="http://cdn.jsdelivr.net/typeahead.js/0.9.3/typeahead.min.js"></script>
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">

	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

 <!-- stylesheets -->
    <link rel="stylesheet" href="Treant.css" type="text/css"/>

     <!-- javascript -->
    <script src="vendor/raphael.js"></script>
    <script src="Treant.min.js"></script>
   
</head>
<style>


body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td { margin:0; padding:0; }
table { border-collapse:collapse; border-spacing:0; }
fieldset,img { border:0; }
address,caption,cite,code,dfn,em,strong,th,var { font-style:normal; font-weight:normal; }
caption,th { text-align:left; }
h1,h2,h3,h4,h5,h6 { font-size:100%; font-weight:normal; }
q:before,q:after { content:''; }
abbr,acronym { border:0; }

body { background: #fff; }
/* optional Container STYLES */
.chart { height: 500px; margin: 5px; width: 100%; }
.Treant > .node {  }
.Treant > p { font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; font-weight: bold; font-size: 12px; }
.node-name { font-weight: bold;}

.nodeExample1 {
    padding: 2px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    background-color: #ffffff;
    border: 1px solid #000;
    width: 200px;
    font-family: Tahoma;
    font-size: 12px;
}

.nodeExample1 img {
    margin-right:  10px;
}

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

.panelData{

	text-align: center;
    background-color: #63A70A;
    border: white;
    border-radius: 30px;
    min-height: 60px;
    color: white;
    font-size: -webkit-xxx-large;
    font-weight: 500;
}
.panelTitulo{
	text-align: center;

    font-size: large;
    font-weight: 200;

}

.panelID{
	text-align: center;
	font-size: -webkit-xxx-large;

}

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
        name : 'sear',
        remote: {
            url : 'connection.php?query=%QUERY'
        }
        
    });
});
</script>


<body>
<div>
    <?php
        include "layout/_navbar.php";
    ?>
</div>
<div><?php include($page_content);?></div>

</body>




</html>

