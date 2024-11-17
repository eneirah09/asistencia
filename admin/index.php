<?php
session_start();
if (isset($_SESSION['admin'])) {
	header('location:inicio.php');
}
?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition login-page">
	<div class="login-box">
		<div class="login-logo">
			<!-- //// -->
			<b></b>
		</div>

		<div class="login-box-body">
			<p class="login-box-msg"><b>INICIO DE SESION</b></p>

			<form action="login.php" method="POST">
				<div class="form-group has-feedback">
					<input type="text" class="form-control" name="username" placeholder="Ingresa nombre de usuario" required autofocus>
					<span class="glyphicon glyphicon-user form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
					<input type="password" class="form-control" name="password" placeholder="Ingresa tu contraseña" required>
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<button type="submit" class="btn btn-success btn-block btn-flat" name="login"><i></i> Ingresar</button>
					</div>
				</div>
			</form>
		</div>
		<?php
		if (isset($_SESSION['error'])) {
			echo "
  				<div class='callout callout-danger text-center mt20'>
			  		<p>" . $_SESSION['error'] . "</p> 
			  	</div>
  			";
			unset($_SESSION['error']);
		}
		?>
	</div>

	<?php include 'includes/scripts.php' ?>
</body>

</html>