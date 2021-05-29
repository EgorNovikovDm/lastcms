<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Function.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php 
$_SESSION["TrakingURL"] =  $_SERVER["PHP_SELF"];
//echo $_SESSION["TrakingURL"];
Confirm_Login();

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
	<title>Dashboard</title>
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
				<li class="nav-item"><a href="Logout.php"class="nav-link text-danger">
					<i class="fas fa-user-times ">Logout</i></a></li>
			</ul>
			
		</div>
	</nav>
	<div style="height:10px; background: #27aae1;"></div>
	<!-- navbar end -->
	<!-- HEADER -->
	<header class="bg-dark text-white py-3">
		<div class="container">
			<div class="row ">
				<div class="col-md-12">
				<h1><i class="fas fa-cog" style="color:#27aae1;"></i> Dashboard</h1>
				</div>
				<div class="col-lg-3 text-center mb-2">
					<a href="AddNewPost.php" class="btn btn-outline-primary btn-block">
						<i class="fas fa-edit"></i> Add New Post
					</a>
				</div>
				<div class="col-lg-3 text-center mb-2">
					<a href="Categories.php" class="btn btn-outline-info btn-block">
						<i class="fas fa-folder-plus"></i> Add New Category
					</a>
				</div>
				<div class="col-lg-3 text-center mb-2">
					<a href="Admins.php" class="btn btn-outline-warning btn-block">
						<i class="fas fa-user-plus"></i> Add New Admin
					</a>
				</div>
				<div class="col-lg-3 text-center mb-2">
					<a href="Comments.php" class="btn btn-outline-success btn-block">
						<i class="fas fa-check"></i> Approve Comments
					</a>
				</div>
			</div>
		</div>
	</header>
	<!-- END HEADER -->

	<!-- main area -->
	<section class="container py-2 mb-4  center-block">
		<div class="row ">
			<?php 
				echo ErrorMassage();
				echo SuccessMassage();
			?>
			<!-- LEFT SIDE AREA -->
			<div class="col-lg-2 d-non d-md-block">
				 <div class="card text-center bg-dark text-white mb-3">
				 	<div class="card-body">
				 		<h1 class="lead">Posts</h1>
				 		<h4 class="display-5">
				 			<i class="fab fa-readme"></i>
				 			<?php TotalPosts();?>
				 		</h4>
				 	</div>
				 </div>

				 <div class="card text-center bg-dark text-white mb-3">
				 	<div class="card-body">
				 		<h1 class="lead">Categories</h1>
				 		<h4 class="display-5">
				 			<i class="fas fa-folder"></i>
				 			<?php TotalCategories();?>
				 		</h4>
				 	</div>
				 </div>
				 <div class="card text-center bg-dark text-white mb-3">
				 	<div class="card-body">
				 		<h1 class="lead">Admins</h1>
				 		<h4 class="display-5">
				 			<i class="fas fa-users" ></i>
				 			<?php TotalAdmins();?>
				 		</h4>
				 	</div>
				 </div>
				 <div class="card text-center bg-dark text-white mb-3">
				 	<div class="card-body">
				 		<h1 class="lead">Comments</h1>
				 		<h4 class="display-5">
				 			<i class="fas fa-comments" ></i>
				 			<?php TotalComments();?>
				 		</h4>
				 	</div>
				 </div>
			</div>
			<!-- LEFT SIDE AREA END -->
			<!-- REID SIDE AREA -->
			<div class="col-lg-10">
				<h1>Top Post</h1>
				<table class="table table-striped table-hover">
					<thead class="table-dark">
						<tr>
							<th>№</th>
							<th>Title</th>
							<th>Date&Time</th>
							<th>Author</th>
							<th>Comments</th>
							<th>Details</th>
						</tr>
					</thead>
					<?php 
					global $ConnectingDB;
					$sql = "SELECT * FROM  posts ORDER BY id desc LIMIT 0,5";
					$stmt = $ConnectingDB->query($sql);
					$SrNo = 0;
					while ($DataRows =  $stmt->fetch()) {
						$PostId = $DataRows["id"];
						$DateTime = $DataRows["datetime"];
						$Author = $DataRows["author"];
						$Title = $DataRows["title"];
						$SrNo++
					 
					 ?>
					 <tbody>
					 	<tr>
					 		<td><?php echo htmlentities($SrNo);?></td>
					 		<td><?php echo htmlentities($Title);?></td>
					 		<td><?php echo htmlentities($DateTime);?></td>
					 		<td><?php echo htmlentities($Author);?></td>
					 		<td><?php $Total = ApprovedCommentsAcardingToPosts($PostId);
					 		if ($Total>0){?>
							<span class="badge badge-success" style="background:green; border-radius: 1;">
							<?php echo $Total;  ?>
							</span>
							<?php } ;?>
					 				<?php 
					 				$Total = DisApprovedCommentsAcardingToPosts($PostId);
					 					if ($Total>0){
					 						?>
					 						<span class="badge badge-danger" style="background:red; border-radius: 1;">
					 						<?php echo $Total;  ?>
					 						</span>
					 						<?php } ?>
					 		</td>
					 		<td><a target="_blank" href="FullPost.php?id=<?php echo $PostId;?>"><span class="btn btn-info">Preview</span></a></td>

					 	</tr>
					 	<?php } ?>
					 </tbody>
					
				</table>
			</div>
			<!-- REID SIDE ARED END -->
		</div>
	</section>



	<!-- end main area -->
<br><br><br><br><br><br><br><br><br>		
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