<html lang="en">  
<head>  
  <title>Jquery multiple select with checkboxes using bootstrap-multiselect.js</title>  
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.2/js/bootstrap-multiselect.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.2/css/bootstrap-multiselect.css"/> 
</head>  
<body>  
  
<div class="container">  
    <strong>Select Language:</strong>  
    <select id="multiple-checkboxes" multiple="multiple">  
        <option value="php">PHP</option>  
        <option value="javascript">JavaScript</option>  
        <option value="java">Java</option>  
        <option value="sql">SQL</option>  
        <option value="jquery">Jquery</option>  
        <option value=".net">.Net</option>  
    </select>  
</div>  
  
<script type="text/javascript">  
    $(document).ready(function() {  
        $('#multiple-checkboxes').multiselect();  
    });  
</script>  
  
</body>  
</html> 