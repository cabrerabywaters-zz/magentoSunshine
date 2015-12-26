<script src="https://cdn.rawgit.com/zenorocha/clipboard.js/master/dist/clipboard.min.js"></script>

<script>
var clipboard = new Clipboard('.btn');

clipboard.on('success', function(e) {

function tempAlert(msg,duration)
{
     var el = document.createElement("div");
     el.setAttribute("style","position:absolute;top:20%;left:20%;background-color:white;");
     el.innerHTML = msg;
     setTimeout(function(){
      el.parentNode.removeChild(el);
     },duration);
     document.body.appendChild(el);
}


 tempAlert("Copiado en el Portapapeles!",500); 

    e.clearSelection();
});

clipboard.on('error', function(e) {
    console.error('Action:', e.action);
    console.error('Trigger:', e.trigger);
});
</script>

<?php
//header('Content-type: text/html; charset=UTF-8');
$name = $_REQUEST["search"];
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
function RetrieveCoupons($UserId)
{
$con = MysqlConnect();
$query = "SELECT * FROM affiliateplus_coupon
where account_id = $UserId
ORDER BY affiliateplus_coupon.program_id  DESC";
$result = mysqli_query($con,$query);
$coupons = array();
while($coupon = mysqli_fetch_object($result))
{
array_push($coupons, $coupon);
}
return $coupons;
}
$coupons = RetrieveCoupons($wantedUser);
?>

<div class="container" style="margin-top:100px">
    <div class="col-md-12">

       
        <table class="table table-striped" style="margin-top: 40px;">
            <tr>
                <th>CÓDIGO</th><th>PROGRAMA</th><th>CUENTA</th>
            </tr>
            <?php
            
            $recaudacionFinal = 0;
            if(count($coupons) == 0)
            {
            echo "<tr><td>No posee Cupones...</td></tr>";
            }
            else {
            
            foreach ($coupons as $coupon) {

if($coupon->program_name!="Referido")
{
            echo "<tr>";
                echo "<td>
                    <p>

<!-- Target -->



                        <textarea  id='$coupon->coupon_code'> $coupon->coupon_code</textarea><br>

<!-- Trigger -->

<button id='$coupon->coupon_code'  type='button' class='btn btn-default' data-toggle='tooltip' data-delay='200' data-placement='right' title='¡ Copiado !' data-clipboard-target='#$coupon->coupon_code'>Copiar</button>

                         
                         
                    </p>
                </td><td>"  ;
                if($coupon->program_name=="Affiliate Program")
                {
                echo "Distribuidor 30%";
                }else if ($coupon->program_name=="REFERIDO (20%)") {
                echo "Referido 20%";
                }
            echo "</td>
            <td>$coupon->account_name</td>
            ";
        echo "</tr>";
        }
        }
}
        ?>
        
        
    </table>
    
</div>
</div><!-- /.container -->