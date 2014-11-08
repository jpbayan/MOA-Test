<?php
/*****************************************************************
* index.php
* Updated: Saturday, Nov. 8, 2014
* 
* Joy Angeles Punongbayan
*
* Putti Development Test
******************************************************************/

include_once 'HTML2JSON.php';
$helper = new HTML2JSON();

$helper->contentToJSON('http://testing.moacreative.com/job_interview/php/index.html');
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Putti Development Test</title>
  
  <script type='text/javascript' src='//code.jquery.com/jquery-2.0.2.js'></script>
  <link rel="stylesheet" type="text/css" href="/css/result-light.css">
  <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
  <script type='text/javascript' src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">
    
  
  <style type='text/css'>

	.panel-heading a:after {
    font-family: 'Glyphicons Halflings';
    content: "\e114";    
    float: right; 
    color: grey; 
	}
	.panel-heading a.collapsed:after {
		content: "\e080";
	}
	
	.panel-heading {
		font-family: sans-serif;
		color: #fff!important;
		background-color: #8B0000!important;
	}	

	Body, .panel-body {
                margin:0;
                font-family: sans-serif;
				color: #fff;
                background-color: #000;
     }
	 .title {
		color: #FF8C00!important;
	 }
	 
  </style>
  


<script type='text/javascript'>//<![CDATA[ 
$(window).load(function(){

	$.ajax({
		url: "films.json",
		type: "post",
		dataType: "json",
		success: function(data) {
			$(".list-title").html(data.html.child_nodes.body.child_nodes.h1.value);
			
			$.each(data.html.child_nodes.body.child_nodes.div.child_nodes, function(i,item){
				drawPanel(item);	
			});
			
		}
	});		
	
	function drawPanel(item){
	
		var defPanel = '<div class="panel panel-default" id="panel_'+ item.attributes.id +'"/>';
		var $newDiv = $( defPanel );
		
		var newDiv2 = '<div class="panel-heading">' +
						  '<h4 class="panel-title">' +
							'<a data-toggle="collapse" data-target="#collapse_'+ item.attributes.id +'" href="#collapseOne">' +
							  item.child_nodes.a.value +
							'</a>' +
						  '</h4>' +
						'</div>';
		
		var newDivDetail = '<div id="collapse_'+ item.attributes.id +'" class="panel-collapse collapse">' +
							  '<div class="panel-body">' + 
							   '<img src="'+ item.child_nodes.img.attributes.src +'" />' +
							   '<br/>'+
							   '<strong><a class="title" href="'+ item.child_nodes.a.attributes.href +'">'+ item.child_nodes.a.value +'</a></strong>' + 
							   '<br/>'+
							   '<div class="small">Release Year : '+ item.attributes['data-year'] +'</div>'+
							   '<br/>'+
							   '<div class="small '+ item.child_nodes.div.attributes.class +'"><div class="small text-info"><strong>Synopsis</strong></div>' + item.child_nodes.div.value +  '</div>' +
							  '</div>' + 
							'</div>'					
						
						
		$newDiv.append(newDiv2, newDivDetail);
		$( ".panel-group" ).append( $newDiv );	
		
		console.log(item);
	}
	
	

});//]]>  

</script>


</head>
<body>

<div class="container">

  <div class="panel-group" id="accordion">
    
	<div class="img-rounded"><h3 class="list-title"></h3></div>
  
  </div>

  </div>

</body>


</html>
