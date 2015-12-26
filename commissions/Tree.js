 

var query = location.search.split('search=')[1];
var month = location.search.split('month=')[1];

 var estructura;
        $.getJSON("json-data.php?search="+query+"&month="+month, function(data) {


                      estructura = data;

               var chart_config = {
                    chart: {
                        container: "#basic-example",
                        
                        connectors: {
                            type: 'step'
                        },
                        node: {
                            HTMLclass: 'nodeExample1'
                        }
                    },
                    nodeStructure: estructura
             };

             new Treant( chart_config );

           

            
        });
    
 //var estructura =   {"text":{"name":"Comerc.Nutric. y Dietist. Constance De Baeremaecker Elgart EIRL DE BAEREMAECKER EHART","title":"54","contact":0},"image":"rsz_user_demo_images.jpg"};


         

