<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Function.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php 
$_SESSION["TrakingURL"] =  $_SERVER["PHP_SELF"];
Confirm_Login(); ?>
<?php 
$SearchQueryParameter = $_GET['username'];
global $ConnectingDB;
$sql = "SELECT aname,aheadline,abio,aimage FROM admins WHERE username=:userName ";
$stmt = $ConnectingDB->prepare($sql);
$stmt->bindValue(':userName', $SearchQueryParameter);
$stmt->execute();
$Result = $stmt->rowcount();
//var_dump($Result);
if ($Result ==1){
	while ($DataRows = $stmt->fetch()) {
		$ExistingName = $DataRows['aname'];
		$ExistingBio = $DataRows['abio'];
		$ExistingImage = $DataRows['aimage'];
		$ExistingHeadline = $DataRows['aheadline'];
	}
}else {
	$_SESSION['ErrorMessage'] ="Bad Request !!";
	Redirect_to("Blog.php?page=1");
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
	<title>Profile</title>
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
			<ul class="navbar-nav mr-auto" >
				<li class="nav-item">
					<a href="MyProfile.php" class="nav-link"><i class="fas fa-user text-success"></i> My Profile</a>
				</li>
				<li class="nav-item">
					<a href="Dashboard.php" class="nav-link">Dashboard</a>
				</li>
				<li class="nav-item">
					<a href="Posts.php" class="nav-link">Posts</a>
				</li>
				<li class="nav-item">
					<a href="Categories.php" class="nav-link">Categories</a>
				</li>
				<li class="nav-item">
					<a href="Admins.php" class="nav-link">Manage Admins</a>
				</li>
				<li class="nav-item">
					<a href="Comments.php" class="nav-link">Comments</a>
				</li>
				<li class="nav-item">
					<a href="Blog.php?page=1" class="nav-link">Live Blog</a>
				</li>
			</ul>
			</div>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item"><a href=""class="nav-link text-danger">
					<i class="fas fa-user-times ">Logout</i></a></li>
			</ul>
			
		</div>
	</nav>
	<div style="height:10px; background: #27aae1;"></div>
	<!-- navbar end -->
	<!-- HEADER -->
	<header class="bg-dark text-white py-3">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
				<h1><i class="fas fa-user text-success mr-2" style="color:#27aae1;"></i><?php echo $ExistingName; ?></h1>
				<h3><?php echo $ExistingHeadline ?></h3>
				</div>
			</div>
		</div>
	</header>
	<!-- END HEADER -->
	<section class="container py-2 mb-4">
		<div class="row">
			<div class="col-md-3">
				<img src="images/<?php echo $ExistingImage; ?>" class="d-block img-fluid mb-3 rounded-circle" alt="">
			</div>
			<div class="col-md-9" style="min-height:550px;">
				<div class="card-body">
					<p class="lead"><?php echo $ExistingBio; ?></p>
				</div>
			</div>
		</div>
	</section>
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