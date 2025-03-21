<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=1">
<title>Home</title>
<link rel="stylesheet" type="text/css" href="dist/css/virtual-select.min.css">
<link rel="stylesheet" type="text/css" href="estilosel.css"> 
</head>
<body>

<div>
	<label>Multiple Select</label>
	<select id="multi_option" multiple name="native-select" placeholder="Native Select" data-silent-initial-value-set="false">
	  <option value="1">HTML</option>
	  <option value="2">CSS</option>
	  <option value="3">JavaScript</option>
	  <option value="4">Python</option>
	  <option value="5">JAVA</option>
	  <option value="6">PHP</option>
	</select>
</div>


<script type="text/javascript" src="dist/js/virtual-select.min.js"></script>
<script type="text/javascript">
	VirtualSelect.init({ 
	  ele: '#multi_option' 
	});
</script>
</body>
</html>
