<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Function.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php 
if (isset($_SESSION["UserId"])) {
	Redirect_to("Daschboard.php");
}
if (isset($_POST["Submit"])) {
	$UserName = $_POST["Username"];
	$Password = $_POST["Password"];
	if (empty($UserName) || empty($Password)) {
		$_SESSION['ErrorMessage'] = "All fields must be filled out";
		Redirect_to("Login.php");
	}else{
		//checking username and password 
		$Found_Account=Login_Attempt($UserName,$Password);
		if ($Found_Account ) {
			$_SESSION["UserId"] = $Found_Account['id'];
			$_SESSION["UserName"] = $Found_Account['username'];
			$_SESSION["AdminName"] = $Found_Account['aname'];
			$_SESSION["SuccessMessage"] = "Welcom ".$_SESSION["AdminName"]."!";
			if (isset($_SESSION["TrakingURL"])) {
				Redirect_to($_SESSION["TrakingURL"]);
			}else{
			Redirect_to("Dashboard.php");
			}
		}else {
			$_SESSION["ErrorMessage"] = "Incorrect Username/Password";
			Redirect_to("Login.php");
		}
	}
}

 ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://kit.fontawesome.com/75e6dc1698.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
	<title>Login</title>
	<style>.FieldInfo{
	color:rgb(251,174,44);
	font-family:Bitter,Georgia,"Times New Roman",Times,serif;
	font-size:1.2em;
}
.CommentBlockk{
	background-color:#F6F7F9;
}</style>
</head>
<body>
	<!-- navbar -->
	<div style="height:10px; background: #27aae1;"></div>
	<nav class="navbar  navbar-expand-lg navbar-dark navbar-dark bg-dark">
		<div class="container " >
			<a href="#" class="navbar-brand">PHARMACIST.COM</a>
			<button  type ="button"data-toggle="collapse" class="navbar-toggler" data-target="#navbarcollapse">
				<span class="navbar-toggler-icon "></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarcollapse">
			
			</div>
		</div>
	</nav>
	<div style="height:10px; background: #27aae1;"></div>
	<!-- navbar end -->
	<!-- HEADER -->
	<header class="bg-dark text-white py-3">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
				</div>
			</div>
		</div>
	</header>
	<!-- END HEADER -->
	<!-- MAIN AREA START -->
	<section class="container py-2 mb-4">
		<div class="row">
			<div class="offset-sm-3 col-sm-6" style="min-height: 650px;">
				<br><br><br><br>
				<?php
				echo ErrorMassage();
				echo SuccessMassage();
				 ?>
				<div class="card bg-secondary text-light">
						<div class="card-header">
							<h4>Welcom Back !</h4>
							</div>
							<div class="card-body bg-dark">
							<form action="Login.php" class="" method="post">
								<div class="form-group">
									<label for="username"><span class="FieldInfo">Username: </span></label>
									<div class="input-group mb-3">
										<div class="input-group-prepend" >
											<span class="input-group-text text-white bg-info" ><i class="fas fa-user" style="height: 24px;"></i></span>
										</div>
										<input type="text" class="form-control" name="Username" id="username">
									</div>
								</div>
								<div class="form-group">
									<label for="password"><span class="FieldInfo">Password: </span></label>
									<div class="input-group mb-3">
										<div class="input-group-prepend" >
											<span class="input-group-text text-white bg-info" ><i class="fas fa-lock" style="height: 24px;"></i></span>
										</div>
										<input type="password" class="form-control" name="Password" id="password">
									</div>
								</div>
								<input type="submit" name="Submit" class="btn btn-info btn-block" value="Login">
							</form>
						</div>
					</div>
			</div>
		</div>
	</section>
	<!-- MAIN AREA END -->
	<!-- FOOTER -->
	<footer class="bg-dark text-white">
		<div class="container">
			<div class="row">
				<div class="col">
				<p class="lead text-center">Them By | Egor Noviko | <span id="year"></span>2020 &copy; ----All right Reserved.</p>
				<p class="text-center small"><a href="https://vk.com/id415961801" style="color:white;text-decoration: none; cursor:pointer;" target="_blank"> This style is only used for Study purpose PHARMACIST.com  have all the rights. no one is allow to distribute copise other then <br>&trade; PHARMACIST.com &trade; Udemy ; &trade; Skillshare; &trade; 
					
				</a></p>
			</div>
		</div>

	</div>
</footer>
<div style="height:10px; background: #27aae1;"></div>
<!-- END FOOTER -->

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
<script>
	$('#year').text(new Date().getFullYear());
</script>
</body>
</html>