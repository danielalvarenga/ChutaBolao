<?php require"links_index.php"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Chuta Bol&atilde;o</title>
<link href="estilos/folha.css" rel="stylesheet" type="text/css" />

<!---------------------------Google Analytics---------------------------->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-31194475-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<!------------------------------------------------------------------------>

</head>

<body>
		
		<!-- logo-->
		
		<div id="principal">
				
		<div id="top">
			<p align="center">
				<img src="../imagens/logo.png" align="center"></img>
			</p>
		</div>
		
		<!-- pagina principal   xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->
		
		<div id="content"><?php include $page; ?></div>
				
				<!-- rodapé    xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->
				
					<div id="footer"><p>Copyright © 2012</p></div>
				    
				<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->
				
				</div>
</body>
</html>