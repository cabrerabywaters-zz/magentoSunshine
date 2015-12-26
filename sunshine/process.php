





<?php

header("content-type:application/json");


////////////////////////////////////////////////////////////////////////////////////
//Receive Json from file
////////////////////////////////////////////////////////////////////////////////////
$string = file_get_contents("datos.js");
	$data= json_decode($string, true);



////////////////////////////////////////////////////////////////////////////////////
//Calculates de acomulate sum of every Personal Point
////////////////////////////////////////////////////////////////////////////////////

function acumular ($data){
    
 			$acumulado = 0;
            $nivel = 100;
            $grupo = 1;

            foreach ($data as $key => $arreglo) {

            	   foreach ($arreglo as $llave=> $persona) {

  

  					if($persona["id_grupo"] == $grupo) {



                        if($persona["Level_Number"] < $nivel) {
                        
                      
                            $persona["acumulado"]= $persona["Personal_Points"] + $acumulado;
                            $data[$key][$llave]["acumulado"]= $persona["Personal_Points"] + $acumulado;
                            $acumulado = $persona["acumulado"];


                           

                        }
                    } else {
                    
                   
                        $acumulado = 0;
                        $nivel = $persona["Level_Number"];
                        $grupo = $persona["id_grupo"];

                       
                            $persona["acumulado"] = $persona["Personal_Points"] + $acumulado;
                            $data[$key][$llave]["acumulado"]= $persona["Personal_Points"] + $acumulado;
                            $acumulado = $persona["acumulado"];



                    }



                 }

             }
            
			$new_DATA = array();
			foreach($data as $value) {
			    $new_DATA += $value;
			}


			return $new_DATA;

}

  $new_DATA = acumular($data);


////////////////////////////////////////////////////////////////////////////////////
//Search for Liders with more than 1600 Group Points in each group
////////////////////////////////////////////////////////////////////////////////////

function search_liders ($Data){

	$Lideres = [];
	foreach ($Data as $key => $persona) {

		

   				if($persona["Level_Number"] == 1 and $persona["acumulado"] >= 1600)
   				{
   							array_push($Lideres,$persona["id_grupo"]) ;
   							$Data[$key]["isLider"]= true;


   				}
   				else
   			    {
   			    		$Data[$key]["isLider"]= false;

   			    }



          }

         return $Lideres;

}

function tag_liders ($Data){

	$Lideres = [];
	foreach ($Data as $key => $persona) {

		

   				if($persona["Level_Number"] == 1 and $persona["acumulado"] >= 1600)
   				{
   							
   							$Data[$key]["isLider"]= true;


   				}
   				else
   			    {
   			    		$Data[$key]["isLider"]= false;

   			    }



          }

         return $Data;

}

 $lideres = search_liders($new_DATA) ;

 $new_DATA = tag_liders($new_DATA);
 $cantidadDeLideres = count($lideres);







foreach ($new_DATA as $key => $persona) {

					foreach ($lideres as $llave => $value) {
						$new_DATA[$key]["sumar"] = true;

						$new_DATA[$key]["liderAmount"] = $cantidadDeLideres;

						if($persona["id_grupo"] == $value)
						{

							$new_DATA[$key]["acumulado"] = 0;
							$new_DATA[$key]["sumar"] = false;
						}
					}



          }


echo json_encode($new_DATA);



 ?>
