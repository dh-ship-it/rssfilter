<!DOCTYPE html>
<html>
<head>
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<style>
body{
	background-color:#FFF;
}
label{
	min-width:100px;
	display:inline-block;
	height:20px;
	padding:10px;
	font-weight:bold;
}

h2{
	font-weight:800;
	color:#003;
}

#total{
	width:900px;
}

div{
	border:1px solid #CCC;
	padding:10px;
}

p{
	text-align:justify;
}

</style>
</head>
<body>
<form name="feedform" id="feedform">
<label>Select Feed</label>
<select name="type" id="type">
	<option value="" >-- None --</option>
	<option value="1">Google News</option>
	<option value="2">New York Times</option>
	<option value="3">Washington Post Soccer</option>
	<option value="4">CNN</option>
	<option value="5">Nature</option>
</select>
<br/>
<label>Keyword</label>
<input type="text" name="keyword" id="keyword" value=""/>
<br/>
<label>&nbsp;</label>
<input type="button" onClick="getfeeds()" value="Submit" />
</form>
<div id="total"></div>
<script>
function getfeeds(){
	var frmdata= $("#feedform").serialize();
			$.ajax( {
				   		  dataType: "json",
						  type:"GET", 
						  url: "service.php", 
						  beforeSend: loading(),
						  data: frmdata, 
						  success: function(response){
							  		$('#total').html("");
									$.each(response, function(index, element) {
															  var h2 = document.createElement("h2"),p = document.createElement('p'),
															  h2_txt = document.createTextNode(element.title),
															  p_txt =  document.createTextNode(element.description),
															  div = document.createElement("div");
															  
															  h2.appendChild(h2_txt);
															  $(p).append($.parseHTML(element.description));
															  if(element.title!="Error"){
															     $(p).append('<a href="'+element.link+'" >Read More</a>');
															  }
															  div.appendChild(h2);
															  div.appendChild(p);

												$('#total').append(div);
											});							  
							  
						   }});
		//return response;
}

function loading(){
	$("#total").html("loading...");
}

</script>
</body>
</html>