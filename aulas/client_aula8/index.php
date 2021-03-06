<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Login</title>

		<meta name="description" content="Login do servidor">
		<meta name="author" content="Igor Moraes">

		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">

	</head>
	<body>

		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-2">
						</div>
						<div class="col-md-8">
							<form class="form-horizontal" role="form" action="login.php" method="post">
								<div class="form-group">

									<label for="email" class="col-sm-2 control-label">
										Email
									</label>
									<div class="col-sm-10">
										<input type="email" class="form-control" id="email" name="email" required>
									</div>
								</div>
								<div class="form-group">

									<label for="password" class="col-sm-2 control-label">
										Password
									</label>
									<div class="col-sm-10">
										<input type="password" class="form-control" id="password" name="password"
										       required>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<div class="checkbox">

											<label>
												<input type="checkbox"> Remember me
											</label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">

										<button type="submit" class="btn btn-default">
											Sign in
										</button>
									</div>
								</div>
							</form>
						</div>
						<div class="col-md-2">
						</div>
					</div>
				</div>
			</div>
		</div>

		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/scripts.js"></script>
	</body>
</html>