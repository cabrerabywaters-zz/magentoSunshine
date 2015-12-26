<?php
//header('Content-type: text/html; charset=UTF-8');
$name = $_REQUEST["search"];

$JJJ= $name;
$Selected_month = $_REQUEST["month"];
$Selected_year = $_REQUEST["year"];

echo "El nombre buscado es: $name";

//////////////////////////////////////////////////////////////////
//Class 1 QueryBuilder Brings all data from Magento
//////////////////////////////////////////////////////////////////
function MysqlConnect(){

	$con = mysqli_connect('104.207.236.202','sunshin4_cabrera','todovaletodovale','sunshin4_magento');

		if (mysqli_connect_errno())
		  {
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		  }

		  return $con;

}

function AffiliatesSummary($Selected_month , $Selected_year){


		$con = MysqlConnect();


		$AccountsAndPoints="
		Select Z.id, Z.name, Y.Level, Y.email, Y.parent_id, Y.Point as Points, Y.Amount  FROM 
		
		(
			SELECT account_id as id, name, email as mail FROM 
			affiliateplus_account 
		) as Z, 
		(
			Select A.id, IFNULL(A.parent_id,0) as parent_id , 
				(IFNULL(A.Points,0) + IFNULL(B.Points,0)) as Point, 
				(IFNULL(A.Amount,0) + IFNULL(B.Amount,0)) as Amount,
				 A.email, IFNULL(A.Level,0) as Level	FROM 
				( 
					SELECT  B.account as id,  toptier_id as parent_id,  B.Points as Points, Amount, Level, email FROM 
				 	affiliatepluslevel_tier as A right join 
				 	(
				 		Select M.account, IFNULL(M.Amount,0) as Amount, M.email, IFNULL(N.Points,0) as Points from
								(
									Select AC.account_id as account,sum(O.total_paid - O.tax_amount - O.shipping_amount) as Amount, email From
									affiliateplus_account AC left join affiliateplus_transaction as T 
									on (AC.account_id = T.account_id)  
									left join sales_flat_order as O 
									on (T.order_id = O.entity_id  AND MONTH(O.created_at) = $Selected_month AND 	
									YEAR(O.created_at) = $Selected_year	AND 
		 							(O.status like 'processing'  OR O.status like 'complete' ) )
									group by AC.account_id) AS M,

								(
									Select account, IFNULL(sum(Points),0) as Points from
                                                                          (
                                      Select AC.account_id as account,  OI.product_id , (OI.qty_ordered *  PV.value) as Points FROM
 	                                  affiliateplus_account AC left join 
                                      affiliateplus_transaction as T  on (AC.account_id = T.account_id)  left join
                                      sales_flat_order as O on (T.order_id = O.entity_id  AND 
                                      MONTH(O.created_at) = $Selected_month AND 
                                      YEAR(O.created_at) = $Selected_year	AND 
                                      (O.status like 'processing'  OR O.status like 'complete' ) )  left join
                                      sales_flat_order_item as OI on (OI.order_id = O.entity_id )  left join
                                      catalog_product_entity as PE on (OI.product_id = PE.entity_id )  left join
                                     catalog_product_entity_decimal as PD on (PE.entity_id = PD.entity_id and PD.value !=0)  left join
                                     catalog_product_entity_varchar as PV on (PE.entity_id = PV.entity_id and PV.attribute_id = 166) 
                                     group by account, product_id,O.entity_id  
                                       ) as PP
                     
                                     group by account
								) AS N
								where M.account = N.account
					
		        	)  as B on(A.tier_id = B.account) 
				 	
		  		) as A, 
				(
					SELECT  B.account as id,  toptier_id as parent_id,  B.Points as Points, Amount, Level, email FROM 
				 	affiliatepluslevel_tier as A right join 
				 	(
				 		Select M.account, IFNULL(M.Amount,0) as Amount, M.email, IFNULL(N.Points,0) as Points from
								(
									Select AC.account_id as account,sum(O.total_paid - O.tax_amount - O.shipping_amount) as Amount, email From
									affiliateplus_account AC left join affiliateplusprogram_transaction as T 
									on (
										AC.account_id = T.account_id and T.order_id IN 
										(
											SELECT order_id FROM affiliateplusprogram_transaction  
											where order_id NOT IN
											(
												SELECT  order_id FROM affiliateplus_transaction 
											)
										)
										)
   
									left join sales_flat_order as O 
									on (T.order_id = O.entity_id  AND MONTH(O.created_at) = $Selected_month AND 	
									YEAR(O.created_at) = $Selected_year	AND 
		 							(O.status like 'processing'  OR O.status like 'complete' ) )
									group by AC.account_id) AS M,

								(
									Select account, IFNULL(sum(Points),0) as Points from
                                                                          (
									Select AC.account_id as account,
					    			sum(OI.qty_ordered * PV.value) as Points FROM
					  				affiliateplus_account AC left join 
									affiliateplusprogram_transaction as T 
									on (
										AC.account_id = T.account_id and T.order_id IN 
										(
											SELECT order_id FROM affiliateplusprogram_transaction  
											where order_id NOT IN
											(
												SELECT  order_id FROM affiliateplus_transaction 
											)
										)
										)  left join
									sales_flat_order as O on (T.order_id = O.entity_id  AND 
									MONTH(O.created_at) = $Selected_month AND 
		 							YEAR(O.created_at) = $Selected_year	AND 
		 							(O.status like 'processing'  OR O.status like 'complete' ) ) left join
									sales_flat_order_item as OI on (OI.order_id = O.entity_id ) left join
									catalog_product_entity as PE on (OI.product_id = PE.entity_id ) left join
									catalog_product_entity_decimal as PD on (PE.entity_id = PD.entity_id and PD.value !=0) left join
									catalog_product_entity_varchar as PV on (PE.entity_id = PV.entity_id and PV.attribute_id = 166) 
								  group by account, product_id,O.entity_id  
                                                                 ) as PP
                     
                                     group by account
								) AS N
								where M.account = N.account


		        	)  as B on(A.tier_id = B.account)  
									
		  		) as B	
                where A.id = B.id  order by id ASC



				
		) as Y
		where Z.id = Y.id order by Level DESC
		";





		$MainProgramresults = mysqli_query($con,$AccountsAndPoints);

		$data = array();
			while($row = mysqli_fetch_array($MainProgramresults))
			{
			    $data[] = $row;
			}

			return $data;

}
$data = AffiliatesSummary($Selected_month, $Selected_year) ;

function RetrieveIDByName($name)
{
	$con = MysqlConnect();

	$query = "SELECT account_id as id FROM affiliateplus_account where  name like '$name' ";

	$result = mysqli_query($con,$query);

		$id = 0;
			while($user = mysqli_fetch_object($result))
			{
			    $id = $user->id;
			}

			return $id;
}

$wantedUser = RetrieveIDByName($name);



//////////////////////////////////////////////////////////////////
//Class 2 GPCalculator. 
//////////////////////////////////////////////////////////////////

function groupByLevel ($data){

	$lastLevel =$data[0]["Level"];
	$groupedLevels= array();
	for($i = 0 ; $i <= $lastLevel; $i++)
     {

     	$groupedLevels[$i]= array();

     }

  
     foreach ($data as $key => $node) {
     					

     						array_push($groupedLevels[$node["Level"]], $node);
     				
     }
		return  array_reverse($groupedLevels,true);

}



$lastLevel =$data[0]["Level"];

$groupedData = groupByLevel($data);

foreach ($groupedData as $level => $levelNodes) {

			foreach ($levelNodes as $node => $persona) {



					//If i'm in the last level
					if($level+1 > $lastLevel)
					{
							
					   $groupedData[$level][$node]["GP"]=	$persona["Points"];
			

					}else{
							$acummulated = 0;
							
						for ($i = 0 ; $i < count($groupedData[$level+1]); $i++) {
							
									if($groupedData[$level+1][$i]["parent_id"] == $persona["id"])
									{
										//We add the GP only if the value is less than 1600
										if($groupedData[$level+1][$i]["GP"]<1600){
											$acummulated = $acummulated + $groupedData[$level+1][$i]["GP"];
										}
										
									}
									

						}

						$acummulated = $acummulated + $persona["Points"];
					$groupedData[$level][$node]["GP"] = $acummulated;


					}

				  
			}
}



function tag_liders ($groupedData){


	foreach ($groupedData as $level => $levelNodes) {

			foreach ($levelNodes as $node => $persona) {



					if($persona["Level"] == 1)
					{
						if($persona["GP"]>= 1600)
						{
							$groupedData[$level][$node]["LiderType"]= "Direct Lider";
						}else
						{

							$groupedData[$level][$node]["LiderType"]= "No Lider";
						}
							
					   
			

					}else if( $persona["Level"] == 0)
					{
						if($persona["GP"]>= 1600)
						{
							$groupedData[$level][$node]["LiderType"]= "Head Lider";
						}else
						{

							$groupedData[$level][$node]["LiderType"]= "No Lider";
						}


					}else{
							

						if($persona["GP"]>= 1600)
						{
							$groupedData[$level][$node]["LiderType"]= "Indirect Lider";
						}else
						{

							$groupedData[$level][$node]["LiderType"]= "No Lider";
						}
					

				


					}

				  
			}
	}

	return $groupedData;
}


$groupedData= tag_liders($groupedData);



function tag_underLider($groupedData)
{
		$groupedData =  array_reverse($groupedData);

		$bannedPerson = array();
		foreach ($groupedData as $level => $levelNodes) {

			foreach ($levelNodes as $node => $persona) {


					if($persona["LiderType"]=="Direct Lider")
					{
					   array_push($bannedPerson,$persona["id"] );
					   $groupedData[$level][$node]["underLider"] = true;


					}else{
							$bannedCount = 0 ;
							foreach ($bannedPerson as $key => $bannedId) {
									
									if($persona["parent_id"]==$bannedId)
									{
											$bannedCount = $bannedCount +1;

									}

							}

							if($bannedCount >= 1)
							{
								$groupedData[$level][$node]["underLider"] = true;
								array_push($bannedPerson,$persona["id"] );

							}else{
								$groupedData[$level][$node]["underLider"] = false;

							}


					}


					}

				  
			}
		


        return array_reverse($groupedData);
}

$groupedData = tag_underLider($groupedData);


function tag_underIndirectLider($groupedData)
{
		$groupedData =  array_reverse($groupedData);

		$bannedPerson = array();
		foreach ($groupedData as $level => $levelNodes) {

			foreach ($levelNodes as $node => $persona) {


					if($persona["LiderType"]=="Indirect Lider")
					{
					   array_push($bannedPerson,$persona["id"] );
					   $groupedData[$level][$node]["underIndirectLider"] = true;

					}else{
							$bannedCount = 0 ;
							foreach ($bannedPerson as $key => $bannedId) {
									
									if($persona["parent_id"]==$bannedId)
									{
											$bannedCount = $bannedCount +1;

									}

							}

							if($bannedCount >= 1)
							{
								$groupedData[$level][$node]["underIndirectLider"] = true;
								array_push($bannedPerson,$persona["id"] );

							}else{
								$groupedData[$level][$node]["underIndirectLider"] = false;

							}


					}


					}

				  
			}
		


        return array_reverse($groupedData);
}

$groupedData = tag_underIndirectLider($groupedData);



function unGroup($groupedData){


	$unGroup = array();

	foreach ($groupedData as $level => $levelNodes) {

			foreach ($levelNodes as $node => $persona) {

								

								array_push(	$unGroup, $persona);


					}

				  
			}
			return $unGroup;
}



$unGroupedData = unGroup($groupedData);




//////////////////////////////////////////////////////////////////
//Class 3 TreeRetriver
//////////////////////////////////////////////////////////////////
function TreeRetriver($AffiliateId){


	$con = MysqlConnect();
	$AffiliateTree = "SELECT affiliateplus_account.account_id  as lev0, tabla.lev1, tabla.lev2, tabla.lev3, tabla.lev4,
		tabla.lev5,tabla.lev6,tabla.lev7,tabla.lev8,tabla.lev9,tabla.lev10,
		tabla.lev11,tabla.lev12,tabla.lev13,tabla.lev14,tabla.lev15,tabla.lev16,tabla.lev17,tabla.lev18,tabla.lev19,tabla.lev20,
		tabla.lev21,tabla.lev22,tabla.lev23,tabla.lev24,tabla.lev25,tabla.lev26,tabla.lev27,tabla.lev28,tabla.lev29,tabla.lev30,
		tabla.lev31,tabla.lev32,tabla.lev33,tabla.lev34,tabla.lev35,tabla.lev36,tabla.lev37,tabla.lev38,tabla.lev39,tabla.lev40,
		tabla.lev41,tabla.lev42,tabla.lev43,tabla.lev44,tabla.lev45,tabla.lev46,tabla.lev47,tabla.lev48,tabla.lev49,tabla.lev50
		FROM


		affiliateplus_account left join



		(SELECT
		 t1.tier_id AS lev1, t2.tier_id AS lev2, t3.tier_id AS lev3, t4.tier_id AS lev4 , t5.tier_id AS lev5, t6.tier_id AS lev6, t7.tier_id AS lev7, t8.tier_id AS lev8, t9.tier_id AS lev9, t10.tier_id AS lev10,
		 t11.tier_id AS lev11, t12.tier_id AS lev12, t13.tier_id AS lev13, t14.tier_id AS lev14 , t15.tier_id AS lev15, t16.tier_id AS lev16, t17.tier_id AS lev17, t18.tier_id AS lev18, t19.tier_id AS lev19, t20.tier_id AS lev20,
		t21.tier_id AS lev21, t22.tier_id AS lev22, t23.tier_id AS lev23, t14.tier_id AS lev24 , t25.tier_id AS lev25, t26.tier_id AS lev26, t27.tier_id AS lev27, t28.tier_id AS lev28, t29.tier_id AS lev29, t30.tier_id AS lev30,
		t31.tier_id AS lev31, t32.tier_id AS lev32, t33.tier_id AS lev33, t14.tier_id AS lev34 , t35.tier_id AS lev35, t36.tier_id AS lev36, t37.tier_id AS lev37, t38.tier_id AS lev38, t39.tier_id AS lev39, t40.tier_id AS lev40,
		t41.tier_id AS lev41, t42.tier_id AS lev42, t43.tier_id AS lev43, t14.tier_id AS lev44 , t45.tier_id AS lev45, t46.tier_id AS lev46, t47.tier_id AS lev47, t48.tier_id AS lev48, t49.tier_id AS lev49, t50.tier_id AS lev50,




		t1.toptier_id as buscado

		FROM affiliatepluslevel_tier AS t1

		LEFT JOIN affiliatepluslevel_tier AS t2 ON t2.toptier_id = t1.tier_id

		LEFT JOIN affiliatepluslevel_tier AS t3 ON t3.toptier_id = t2.tier_id

		LEFT JOIN affiliatepluslevel_tier AS t4 ON t4.toptier_id = t3.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t5 ON t5.toptier_id = t4.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t6 ON t6.toptier_id = t5.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t7 ON t7.toptier_id = t6.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t8 ON t8.toptier_id = t7.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t9 ON t9.toptier_id = t8.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t10 ON t10.toptier_id = t9.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t11 ON t11.toptier_id = t10.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t12 ON t12.toptier_id = t11.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t13 ON t13.toptier_id = t12.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t14 ON t14.toptier_id = t13.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t15 ON t15.toptier_id = t14.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t16 ON t16.toptier_id = t15.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t17 ON t17.toptier_id = t16.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t18 ON t18.toptier_id = t17.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t19 ON t19.toptier_id = t18.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t20 ON t20.toptier_id = t19.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t21 ON t21.toptier_id = t20.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t22 ON t22.toptier_id = t21.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t23 ON t23.toptier_id = t22.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t24 ON t24.toptier_id = t23.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t25 ON t25.toptier_id = t24.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t26 ON t26.toptier_id = t25.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t27 ON t27.toptier_id = t26.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t28 ON t28.toptier_id = t27.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t29 ON t29.toptier_id = t28.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t30 ON t30.toptier_id = t29.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t31 ON t31.toptier_id = t30.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t32 ON t32.toptier_id = t31.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t33 ON t33.toptier_id = t32.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t34 ON t34.toptier_id = t33.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t35 ON t35.toptier_id = t34.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t36 ON t36.toptier_id = t35.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t37 ON t37.toptier_id = t36.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t38 ON t38.toptier_id = t37.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t39 ON t39.toptier_id = t38.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t40 ON t40.toptier_id = t39.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t41 ON t41.toptier_id = t40.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t42 ON t42.toptier_id = t41.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t43 ON t43.toptier_id = t42.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t44 ON t44.toptier_id = t43.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t45 ON t45.toptier_id = t44.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t46 ON t46.toptier_id = t45.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t47 ON t47.toptier_id = t46.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t48 ON t48.toptier_id = t47.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t49 ON t49.toptier_id = t48.tier_id
		LEFT JOIN affiliatepluslevel_tier AS t50 ON t50.toptier_id = t49.tier_id




		WHERE t1.toptier_id = $AffiliateId



		) as tabla on (buscado = affiliateplus_account.account_id)





		WHERE affiliateplus_account.account_id =  $AffiliateId ";

	$Tree = mysqli_query($con,$AffiliateTree);

		$data = array();
			while($row = mysqli_fetch_array($Tree))
			{

				array_push($data, $row);
			  
			}


  $normalizedRows = array();

		foreach ($data as $tree => $branch) {

			foreach ($branch as $key => $value) {


				if(!is_int($key)&& !is_null($value))
				{

					$levelNumber = filter_var($key, FILTER_SANITIZE_NUMBER_INT);
					array_push($normalizedRows, array("id_group"=>$tree+1,"Levels"=>$levelNumber, "Account_id"=>$value))	;				
				}
			    if (is_int($key)) {
			        unset($data[$tree][$key]);
			    }

			    if(is_null($value))
			    {
			     unset($data[$tree][$key]);

			    }


			}
			
		}






		return $normalizedRows;

}

$data = TreeRetriver($wantedUser);


function ArrayUnsetDuplicates($data, $attribute){

		$ids = array();
		foreach ($data as $key => $person) {
			
			
				   if(!in_array($person[$attribute], $ids)){

				   		array_push($ids, $person[$attribute]);
				   }
				   else
				   {

				   	unset($data[$key]);
				   }

			
		}
		return $data;


}

$data = ArrayUnsetDuplicates($data,"Account_id");




//////////////////////////////////////////////////////////////////
//Class 4 MergeArrays unGroupedData && data
//////////////////////////////////////////////////////////////////

function array_merge_callback($array1, $array2, $predicate) {
    $result = array();

    foreach ($array1 as $item1) {
        foreach ($array2 as $item2) {
            if ($predicate($item1, $item2)) {
                $result[] = array_merge($item1, $item2);
            }
        }
    }

    return $result;
}


$mergedArrays = array_merge_callback($data, $unGroupedData, function ($item1, $item2) {
    return $item1['Account_id'] == $item2['id'];
});


function removeNumericKeys($data){


			foreach ($data as $tree => $branch) {

			foreach ($branch as $key => $value) {


			    if (is_int($key)) {
			        unset($data[$tree][$key]);
			    }

			  


			}
			
		}

		return $data;

}


$mergedArrays = removeNumericKeys($mergedArrays);


function sortBy($data, $attribute, $order)
{
		
	$sorting = array(); 
	foreach ($data as $datum) {   
	 $sorting[] = $datum[$attribute];
	} 
	 array_multisort($sorting, $order, $data);

	 return $data;
}



$mergedArrays = sortBy($mergedArrays, "Levels", SORT_DESC);


//////////////////////////////////////////////////////////////////
//Class 5 Process.php
//////////////////////////////////////////////////////////////////

$data= $mergedArrays;

function groupByLevel2 ($data){

	$lastLevel =$data[0]["Levels"];
	$groupedLevels= array();
	for($i = 0 ; $i <= $lastLevel; $i++)
     {

     	$groupedLevels[$i]= array();

     }

  
     foreach ($data as $key => $node) {
     					

     						array_push($groupedLevels[$node["Levels"]], $node);
     				
     }
		return  array_reverse($groupedLevels,true);

}


$lastLevel =$data[0]["Levels"];

$groupedData = groupByLevel2($data);


function tag_liders2 ($groupedData){


	foreach ($groupedData as $level => $levelNodes) {

			foreach ($levelNodes as $node => $persona) {



					if($persona["Levels"] == 1)
					{
						if($persona["GP"]>= 1600)
						{
							$groupedData[$level][$node]["LiderType"]= "Direct Lider";
						}else
						{

							$groupedData[$level][$node]["LiderType"]= "No Lider";
						}
							
					   
			

					}else if( $persona["Levels"] == 0)
					{
						if($persona["GP"]>= 1600)
						{
							$groupedData[$level][$node]["LiderType"]= "Head Lider";
						}else
						{

							$groupedData[$level][$node]["LiderType"]= "No Lider";
						}


					}else{
							

						if($persona["GP"]>= 1600)
						{
							$groupedData[$level][$node]["LiderType"]= "Indirect Lider";
						}else
						{

							$groupedData[$level][$node]["LiderType"]= "No Lider";
						}
					

				


					}

				  
			}
	}

	return $groupedData;
}


$groupedData= tag_liders2($groupedData);



function tag_underLider2($groupedData)
{
		$groupedData =  array_reverse($groupedData);

		$bannedPerson = array();
		foreach ($groupedData as $level => $levelNodes) {

			foreach ($levelNodes as $node => $persona) {


					if($persona["LiderType"]=="Direct Lider")
					{
					   array_push($bannedPerson,$persona["id"] );
					   $groupedData[$level][$node]["underLider"] = true;


					}else{
							$bannedCount = 0 ;
							foreach ($bannedPerson as $key => $bannedId) {
									
									if($persona["parent_id"]==$bannedId)
									{
											$bannedCount = $bannedCount +1;

									}

							}

							if($bannedCount >= 1)
							{
								$groupedData[$level][$node]["underLider"] = true;
								array_push($bannedPerson,$persona["id"] );

							}else{
								$groupedData[$level][$node]["underLider"] = false;

							}


					}


					}

				  
			}
		


        return array_reverse($groupedData);
}

$groupedData = tag_underLider2($groupedData);



function tag_underIndirectLider2($groupedData)
{
		$groupedData =  array_reverse($groupedData);

		$bannedPerson = array();
		foreach ($groupedData as $level => $levelNodes) {

			foreach ($levelNodes as $node => $persona) {


					if($persona["LiderType"]=="Indirect Lider")
					{
					   array_push($bannedPerson,$persona["id"] );
					   $groupedData[$level][$node]["underIndirectLider"] = true;

					}else{
							$bannedCount = 0 ;
							foreach ($bannedPerson as $key => $bannedId) {
									
									if($persona["parent_id"]==$bannedId)
									{
											$bannedCount = $bannedCount +1;

									}

							}

							if($bannedCount >= 1)
							{
								$groupedData[$level][$node]["underIndirectLider"] = true;
								array_push($bannedPerson,$persona["id"] );

							}else{
								$groupedData[$level][$node]["underIndirectLider"] = false;

							}


					}


					}

				  
			}
		


        return array_reverse($groupedData);
}

$groupedData = tag_underIndirectLider2($groupedData);



function unGroup2($groupedData){


	$unGroup = array();

	foreach ($groupedData as $level => $levelNodes) {

			foreach ($levelNodes as $node => $persona) {

								

								array_push(	$unGroup, $persona);


					}

				  
			}
			return $unGroup;
}



$unGroupedData = unGroup2($groupedData);



$unGroupedData = sortBy($unGroupedData, "Account_id", SORT_ASC);



//////////////////////////////////////////////////////////////////
//Class 6 Count Liders
//////////////////////////////////////////////////////////////////
function countLiders($data){
		$count = 0;

		foreach ($data as $key) {
			if($key["GP"] > 1600 && $key["Levels"] == 1)
			{
				$count = $count + 1;

			}
		}
		return $count;

}

$liderCount = countLiders($unGroupedData);



function businessLogic($data,$liderCount){

   $commission_rate = 1;
			foreach ($data as $key => $value) {

				

				if($data[$key]["underIndirectLider"]==true)
				{
				   $commission_rate = 20;
				}
				else
				{
					if($data[$key]["Points"] >= 80 && $data[$key]["Points"] < 160)
					{
						if($data[$key]["GP"] >= 400)
						{
							$commission_rate = 5;
						}else{
							$commission_rate = 0;
						}
				  		

					}
					else if($data[$key]["Points"] >= 160 && $data[$key]["Points"] < 240)
					{
				  		if($data[$key]["GP"] >= 800)
				  		{
				  			$commission_rate = 10;
				  		}else if($data[$key]["GP"] >= 400)
				  		{
				  			$commission_rate = 5;
				  		}
				  		else{
							$commission_rate = 0;
						}
				  		

					}
					else if($data[$key]["Points"] >= 240 && $data[$key]["Points"] < 320)
					{
				  		if($data[$key]["GP"] >= 1200)
				  		{
				  			$commission_rate = 15;
				  		}
				  		else if($data[$key]["GP"] >= 800)
				  		{
				  			$commission_rate = 10;
				  		}else if($data[$key]["GP"] >= 400)
				  		{
				  			$commission_rate = 5;
				  		}
				  		else{
							$commission_rate = 0;
						}

				  		

					}
					else if($data[$key]["Points"] >= 320)
					{
				  		if( $data[$key]["GP"] >= 1600)
				  		{
				  			$commission_rate = 20;
				  		}
				  		else if($data[$key]["GP"] >= 1200)
				  		{
				  			$commission_rate = 15;
				  		}
				  		else if($data[$key]["GP"] >= 800)
				  		{
				  			$commission_rate = 10;
				  		}else if($data[$key]["GP"] >= 400)
				  		{
				  			$commission_rate = 5;
				  		}
				  		else{
							$commission_rate = 0;
						}

				  		

					}
					else{

						$commission_rate = 0;

						
					}
				}
			


				$data[$key]["commission_rate"] = $commission_rate;

				$data[$key]["Lider_Count"] = $liderCount;

			}

			return $data;

}

$data = businessLogic($unGroupedData,$liderCount);



function headCommission($data){
	$headCommission = 433;
		foreach ($data as $key) {

			if($key["Levels"] == 0)
			{
				$headCommission = $key["commission_rate"];

			}
		}


		foreach ($data as $key => $value) {

				$data[$key]["head_commision"] = $headCommission;

		

			}

			return $data;

}

$data = headCommission($data);
$previousData = sortBy(TreeRetriver($wantedUser),"Account_id",SORT_ASC);

$mergedArrays = array_merge_callback($data, $previousData, function ($item1, $item2) {
    return $item1['Account_id'] == $item2['Account_id'];
});


//var_dump($mergedArrays);

function headTake($data){

	 $head_take_rate = 0;
	 $head_take_amount = 0;

	 	

			foreach ($data as $key => $value) {

				//var_dump($key["underLider"]);

				if ($data[$key]["underLider"] == true && $data[$key]["underIndirectLider"]  == true) {
				    $head_take_rate = 0;
				    $head_take_amount = 0;

				} else if($data[$key]["underLider"] == true && $data[$key]["head_commision"] == 20) {


				    if ($data[$key]["Lider_Count"] >= 1 && $data[$key]["Lider_Count"] <= 2) {
				        $head_take_rate = 5;


				    } else if ($data[$key]["Lider_Count"]>= 3 && $data[$key]["Lider_Count"] <= 4) {
				        $head_take_rate = 6;


				    } else if ($data[$key]["Lider_Count"] >= 5 && $data[$key]["Lider_Count"] <= 6) {
				        $head_take_rate = 7;


				    } else if ($data[$key]["Lider_Count"] >= 7 && $data[$key]["Lider_Count"] <= 8) {
				        $head_take_rate = 8;


				    } else if ($data[$key]["Lider_Count"] >= 9 && $data[$key]["Lider_Count"] <= 10) {
				        $head_take_rate = 9;


				    } else if ($data[$key]["Lider_Count"] >= 11 && $data[$key]["Lider_Count"] <= 12) {
				        $head_take_rate = 10;


				    } else if ($data[$key]["Lider_Count"] >= 13 && $data[$key]["Lider_Count"] <= 14) {
				        $head_take_rate = 11;


				    } else if ($data[$key]["Lider_Count"] >= 15 && $data[$key]["Lider_Count"] <= 16) {
				        $head_take_rate = 12;


				    } else if ($data[$key]["Lider_Count"] >= 17) {
				        $head_take_rate = 13;


				    }
				    $head_take_amount = $head_take_rate * $data[$key]["Amount"] / 100;



				} else if ($data[$key]["underIndirectLider"] == true) {
				    $head_take_rate = 0;
				    $head_take_amount = 0;

				} else {

				    if ($data[$key]["Levels"] == 0) {
				        $head_take_rate = $data[$key]["commission_rate"];
				        
				       
				        $head_take_amount = $data[$key]["Amount"] * $head_take_rate / 100;

				    } else {
				        if ($data[$key]["head_commision"] == 0) {
				            $head_take_rate = 0;
				            $head_take_amount = 0;

				        }
					    else if ($data[$key]["LiderType"] == "Direct Lider" || $data[$key]["underLider"] ==true)
				        {
							$head_take_rate = 0;
				            $head_take_amount = 0;
						}


				        else {

				            $head_take_rate = $data[$key]["head_commision"] - $data[$key]["commission_rate"];
				            $head_take_amount = $data[$key]["Amount"] * $head_take_rate / 100;
				        }

				    }
				}



				


				$data[$key]["head_take_rate"] = $head_take_rate ;

				$data[$key]["head_take_amount"] = $head_take_amount;

			}

			return $data;

}



$mergedArrays = headTake($mergedArrays);

//var_dump($mergedArrays);

$mergedArrays = sortBy($mergedArrays, "id_group", SORT_DESC);



//////////////////////////////////////////////////////////////////
//Class 7 Process3.php
//////////////////////////////////////////////////////////////////


$data = $mergedArrays;



function groupByGroup ($data){

	$lastGroup =$data[0]["id_group"];
	$groupedGroups= array();
	for($i = 1 ; $i <= $lastGroup ; $i++)
     {

     	$groupedGroups[$i]= array();

     }

  
     foreach ($data as $key => $node) {
     					

     						array_push($groupedGroups[$node["id_group"]], $node);
     				
     }
		return  $groupedGroups;

}



$lastLevel =$data[0]["Levels"];

$groupedData = groupByGroup($data);



function commisions_not_under_lider($groupedData){



	foreach ($groupedData as $group => $groupNodes) {
				$head_take_rate = 0;
                                        /*Utilizamos una variable para ir acumulando los porcentajes
					/que se van llevando de las comisiones, de manera que se pueda
					/restar del total
					*/
					
			foreach ($groupNodes as $node => $persona) {
					
					if($persona["Levels"] == 0)
					{
							$groupedData[$group][$node]["head_take_rate"] = $persona["head_commision"];

					}

					else if($persona["Levels"] == 1 && $persona["LiderType"]=="No Lider")
					{
						if($persona["head_commision"] > 0){
							
							$head_take_rate = $persona["head_commision"] - $persona["commission_rate"];
							$groupedData[$group][$node]["head_take_rate"]= $head_take_rate;
                                                        
						}
						else
						{
							$head_take_rate = 0;

						}
						
					}else{



						//Falta comprobar el caso en que la persona tenga mayor cantidad de puntos que su "Lider o tope directo"
						//if($persona["commision_rate"] > $groupedData[$group][1]["commision_rate"] )
						//El Cabeza de serie se llevaria cuanto? La diferencia entre lo de él y los demas?
						//O no se llevaria nada?
						if( $persona["underIndirectLider"]==false && $persona["LiderType"] == "No Lider")
						{
                                                       $groupedData[$group][$node]["head_take_rate"]= $head_take_rate;
							
                                                         
						}
							


					}

				  
			}
	}

	return $groupedData;


}

$groupedData = commisions_not_under_lider($groupedData);


//var_dump($groupedData);

function unGroup3($groupedData){


	$unGroup = array();

	foreach ($groupedData as $level => $levelNodes) {

			foreach ($levelNodes as $node => $persona) {

								

								array_push($unGroup, $persona);


					}

				  
			}
			return $unGroup;
}



$unGroupedData = unGroup3($groupedData);


function RecalculateHeadTakeAmount($data){
	foreach ($data as $key => $value) {
				$data[$key]["head_take_amount"] = $data[$key]["Amount"] * $data[$key]["head_take_rate"] / 100;

		}

		return $data;


}

$finalResult =  RecalculateHeadTakeAmount($unGroupedData);

//$finalResult = ArrayUnsetDuplicates($data,"Account_id");
$finalResult = ArrayUnsetDuplicates($finalResult,"Account_id");


//$aa = $finalResult;

function treeFormat($data)
{

	$new_data = array();
	foreach ($data as $user => $value) {

		$data[$user]["text"] = array("name"=>$data[$user]["name"],"title"=>$data[$user]["Account_id"],"contact"=>$data[$user]["GP"]);

		$data[$user]["image"]= "rsz_user_demo_images.jpg";

		$new_data[$user]["text"] = $data[$user]["text"];
		$new_data[$user]["image"] =$data[$user]["image"];
		$new_data[$user]["Account_id"] =$data[$user]["Account_id"];
		$new_data[$user]["parent_id"]= $data[$user]["parent_id"];
		
	}

	  $new_data = sortBy($new_data, "parent_id", SORT_DESC);
		return $new_data;

}

$aa = treeFormat($finalResult);

function buildTree(array $elements, $parentId = 0) {
    $branch = array();

    foreach ($elements as $element) {

        if ($element["parent_id"] == $parentId) {
        	 $children = buildTree($elements, $element["Account_id"]);
            if ($children) {
                $element['children'] = $children;
            }

            unset($element["Account_id"]);
            unset($element["parent_id"]);
            $branch[] = $element;
        }
    }

    return $branch;
}



$aa = buildTree($aa,$aa[0]["parent_id"] );





           $recaudacionFinal = 0;
           	foreach ($finalResult as $key) {

           			$nivel = $key["Levels"];
           			
           				
           				$MontoComprado = $key["Amount"]  ;
           				$MontoComprado = round($MontoComprado);
           				 
           				$Puntos =$key["Points"];
           				$nombre = $key["name"];
           				$id = $key["Account_id"];
           				$GP = $key["GP"];

           				$porcentaje=$key["head_take_rate"];
           				$comision=$MontoComprado * $key["head_take_rate"] / 100;

           				$comision = round($comision);
           				$recaudacionFinal = $recaudacionFinal + $comision;
           				$comision = number_format($comision, 0, '', '.'); 
           				$MontoComprado = number_format($MontoComprado, 0, '', '.'); 

           			

           	}
           	

        
           	$recaudacionFinal = round($recaudacionFinal);
           	$retencion = $recaudacionFinal * 0.1;
           	$retencion  = round($retencion);

           	$final = $recaudacionFinal * 0.9;
           	$final  = round($final);
           			
           	$recaudacionFinal  = number_format($recaudacionFinal , 0, '', '.');               
           	
           	$retencion  = number_format($retencion , 0, '', '.'); 
           			
           	$final  = number_format($final , 0, '', '.'); 





?>



    <div class="container" style="margin-top:100px">
      <div class="col-md-12">
  			<div class="col-md-12 panelTitulo">ID Usuario </div>
           	<div class="col-md-12 panelID"><?php echo $wantedUser ?> </div>
         
         
		
		   <div class="row">
			   <div class="col-md-4 col-xs-12">
	           	<div class="col-md-12 panelTitulo">Total $ en Comisiones: </div>
	           	<div class="col-md-12 panelData"><?php echo $recaudacionFinal ?> </div>
	           </div>
	           <div class="col-md-4 col-xs-12">
	           	<div class="col-md-12 panelTitulo">Total $ retenido: </div>
	           	<div class="col-md-12 panelData"> <?php echo $retencion ?></div>
	           </div>
	           <div class="col-md-4 col-xs-12">
	           	<div class="col-md-12 panelTitulo">Monto $ a Pagar: </div>
	           	<div class="col-md-12 panelData"> <?php echo $final ?></div>
	           </div>
           </div>
		<button class="btn btn-primary"  style="margin-top: 20px;" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
		  Mostrar Detalle Cálculo
		</button>
	<div class="collapse" id="collapseExample">
         <table class="table table-striped" style="margin-top: 40px;">

         	<tr> 
         		<th>ID</th><th>Nombre</th><th>Nivel</th><th>Compras en PESOS s/IVA</th><th>Puntos Individuales</th> <th>Puntos Grupales</th><th>% Comision</th><th>Comision</th>

         	</tr>
           <?php
          
           $recaudacionFinal = 0;
           	foreach ($finalResult as $key) {

           			$nivel = $key["Levels"];
           			
           				
           				$MontoComprado = $key["Amount"]  ;
           				$MontoComprado = round($MontoComprado);
           				 
           				$Puntos =$key["Points"];


           				$nombre = $key["name"];
           				$id = $key["Account_id"];
           				$GP = $key["GP"];
           				$porcentaje=$key["head_take_rate"];
           				$comision=$MontoComprado * $key["head_take_rate"] / 100;
           				$comision = round($comision);
           			
           				$comision = number_format($comision, 0, '', '.'); 
           				$MontoComprado = number_format($MontoComprado, 0, '', '.'); 

           				


           		
           			 	echo "<tr>";  
         				echo "<td>$id</td><td>$nombre</td><td>$nivel</td><td>$MontoComprado</td><td>$Puntos</td><td>$GP</td><td>$porcentaje</td><td>$comision</td>";


         	
           				echo "</tr>";



           	}
           	

        
           	$recaudacionFinal = round($recaudacionFinal);
           	$retencion = $recaudacionFinal * 0.1;
           	$retencion  = round($retencion);

           	$final = $recaudacionFinal * 0.9;
           	$final  = round($final);
           			
           	$recaudacionFinal  = number_format($recaudacionFinal , 0, '', '.');               
           	
           	$retencion  = number_format($retencion , 0, '', '.'); 
           			
           	$final  = number_format($final , 0, '', '.'); 

         

           ?>

          
        
        </table>
    </div>
  <div class="chart Treant loaded" id="basic-example">


        </div>

         <script src="Tree.js"></script>
     



       
       </div>
      

    </div><!-- /.container -->











