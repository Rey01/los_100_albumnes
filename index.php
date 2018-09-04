<!doctype html>
 <html>
	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<link href="style.css" rel="stylesheet" >
		<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
		<title>los 100 mejores albumes</title>
	</head>
	<body>
		<nav class="navbar navbar-default" role="navigation">
		  <div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
			  <span class="sr-only">Desplegar navegación</span>
			  <span class="icon-bar"></span>
			  <span class="icon-bar"></span>
			  <span class="icon-bar"></span>
			</button>
			<a class="navbar-brand 100_alnums" style='cursor:pointer;'>100 Albums</a>
		  </div>
		  <div class="collapse navbar-collapse navbar-ex1-collapse">
			
			<ul class="nav navbar-nav pull-right" style="cursor:pointer;">
				<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" >Mostrando <span id="cantidad">100 Registros</span> <span class="caret"></span></a>
					<ul class="dropdown-menu">
					  <li><a class="cantidad">10</a></li>
					  <li><a class="cantidad">20</a></li>
					  <li><a class="cantidad">50</a></li>
					  <li><a class="cantidad">100</a></li>
					</ul>
				</li>
			</ul>
			<div class="navbar-form navbar-left  pull-right" role="search">
			  <div class="form-group">
				<input type="text" class="form-control" id="buscar" name="buscar"  autocomplete="off" placeholder="Buscar">
			  </div>
			</div>
		  </div>
		</nav>
		<input type="Hidden" name="contador" id="contador" value="100">
		<input type="Hidden" name="cantida" id="cantida" value="1">
		<div class="row" style="margin-bottom:20px;">
			<div class="col-lg-12 text-center"></div>
			<div class="col-lg-2">
			</div>
			<div class="col-lg-8 text-center">
				<ul class="pagination" style="margin-top:0px;"></ul>
				<div id="container_box" style='width:100%;'></div>
			</div>
			<div class="col-lg-2"></div>
		</div>
			<script>
				function show_albums(){
					$("#container_box").html('');
					var xhr = new XMLHttpRequest();
					var url = "https://itunes.apple.com/us/rss/topalbums/limit=100/json";
					xhr.open('GET', url, true);
					xhr.onload = function () {
						var response 	= xhr.responseText;
						var obj 		= JSON.parse(response);
						var total       = obj.feed.entry.length;
						var contador	= $('#contador').val();
						var cociente 	= total/contador;
						if($("#cantida").val()==1){
							var classs="btn disabled";
						}else{
							var classs="";
						}
						$(".pagination").html("");
						$(".pagination").append("<li><a style='cursor:pointer;' class='previus "+classs+"'>&laquo;</a></li>");
						for(var e = 1;e<=cociente;e ++){
							var active	=""
							if($("#cantida").val()==e){
								var active	="active"
							}
							$(".pagination").append("<li style='cursor:pointer;' class='"+active+"'><a class='pagina'>"+e+"</a></li>");
						}
						console.log(e);
						if($("#cantida").val()==cociente){
							var classs="btn disabled";
						}else{
							var classs="";
						}
						$(".pagination").append("<li><a style='cursor:pointer;' class='next "+classs+"'>&raquo;</a></li>");
						var inicio  = ($("#cantida").val()*contador)-contador;
						var fin 	= $("#cantida").val()*contador;
						console.log(inicio);
						console.log(fin);
						for(var i = inicio;i<fin;i ++){
							if(obj.feed.entry[i]['im:name']['label'].length>15){
								var name = obj.feed.entry[i]['im:name']['label'].substr(0,15)+"...";
							}else{
								var name = obj.feed.entry[i]['im:name']['label'];
							}
							var href=obj.feed.entry[i]['im:artist']['attributes'];
							var url = obj.feed.entry[i]['im:artist']['attributes'];
							if(obj.feed.entry[i]['im:name']['label'].indexOf($("#buscar").val())!=-1){
								$("#container_box").append("<div class='col-lg-3 col-md-3 col-sm-4 center-block' style='margin-top:5px;'><div class='section-box-ten'><figure><a href='"+obj.feed.entry[i]['id']['label']+"' target='_blank'><h3>"+name+"</h3></a><p>Artista: <a href='"+href+"' target='_blank'>"+obj.feed.entry[i]['im:artist']['label']+"</a></p><p>Genero: "+obj.feed.entry[i]['category']['attributes']['label']+"</p><p>Precio: "+obj.feed.entry[i]['im:price']['label']+"</p><p> Fecha de Lanzamiento: "+obj.feed.entry[i]['im:releaseDate']['attributes']['label']+"</p></figure><img style='width:100%;' src='" + obj.feed.entry[i]['im:image'][2]['label'] + "' class='img-responsive'/></div></div>");
							}
						}
						$('.previus').click(function (){
							console.log($(this).html());
							$("#cantida").val(parseInt($("#cantida").val())-1);
							show_albums();
						});
						$('.next').click(function (){
							console.log($("#cantida").val());
							$("#cantida").val(parseInt($("#cantida").val())+1);
							console.log($("#cantida").val());
							show_albums();
						});
						$('.pagina').click(function (){
							console.log($(this).html());
							$("#cantida").val($(this).html());
							show_albums();
						});
						if($("#container_box").html()==""){
							$("#container_box").html("<h1>No existen coincidencias</h1>");
						}
					}
					xhr.send();
					
				}
				$(document).ready(function (){
					$('.cantidad').click(function (){
						$("#cantidad").html($(this).html()+" Registros");
						$('#contador').val($(this).html());
						$("#cantida").val(1);
						show_albums();
					});
					
					$('#buscar').keyup(function (e){
						show_albums();
					});
					$('.100_alnums').click(function (){
						location.reload(true);
					});
					show_albums();
				});
			</script>
	</body>
</html>