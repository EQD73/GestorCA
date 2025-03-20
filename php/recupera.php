<!doctype html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Recuperar Contraseña</title>
		
		<link rel="stylesheet" href="css/bootstrap.min.css" >
		<link rel="stylesheet" href="css/bootstrap-theme.min.css" >
		<script src="js/bootstrap.min.js" ></script>
		<script src='https://www.google.com/recaptcha/api.js'></script>	
	</head>
	
	<body>
		
		<div class="container">    
			<div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
				<div class="panel panel-info" >
					<div align="center"><img src="assets/img/Logo-Coopercar.png" class="img-responsive" alt="Coopercar logo" width="300" height="200"></div>
					<div class="panel-heading" style="background: #84BD00">

						<div class="panel-title"><font color= "#FFFFFF">Recuperación de Contraseña</div>
						<div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="index.php"><font color= "#FFFFFF">Iniciar Sesi&oacute;n</a></div>
					</div>     
					
					<div style="padding-top:30px" class="panel-body" >
						
						<div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
						
						<form id="loginform" class="form-horizontal" role="form" action="" method="POST" autocomplete="off">
							
							<div style="margin-bottom: 25px" class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
								<input id="email" type="email" class="form-control" name="email" placeholder="ingresa correo electrónico de asociado" required>                                        
							</div>

							<div class="form-group">
								<label for="captcha" class="col-md-3 control-label"></label>
								<div class="g-recaptcha col-md-9" data-sitekey="6LeD278ZAAAAABMT06fKPzGc6L6aiBtPpYzxu-xT"></div>
							</div>
							<div style="margin-top:10px" class="form-group">
								<div class="col-sm-12 controls">
									<button id="btn-login" type="submit" class="btn btn-success">Enviar</a>
								</div>
							</div>
										
						</form>
											</div>                     
				</div>  
			</div>
		</div>
	</body>
</html>							