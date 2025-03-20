
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<?php
session_start();

$codigo_rol=$_SESSION['codigo_rol'];

?>

<script type="text/javascript">
    function redireccionar() {
        const var_rol = "<?php echo $codigo_rol ?>";
        if (var_rol != "1") { 
        //alert("1");
        document.getElementById('id01').style.display = 'none';
        $("#id01").trigger("click");
        }
    }
    setTimeout("redireccionar()", 1000); //tiempo expresado en milisegundos
</script>


<body>

<button id="id01" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" style="display: none">Open Modal</button>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div id="id01" class="modal-body">
                <img class="third-slide" src="../img/cat_001.png" alt="Third slide">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

</body>

</html>



