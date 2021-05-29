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
	<title>Posts</title>
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
				<h1><i class="fas fa-blog" style="color:#27aae1;"></i> Blog Posts</h1>
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
			<div class="col-lg-12">
				<?php 
				echo ErrorMassage();
				echo SuccessMassage();
				 ?>
				<table class="table table-striped table-hover" >
					<thead class="thead-dark"style="background: #000000; color:white;">
					<tr>
						<th>#</th>
						<th>Title</th>
						<th>Category</th>
						<th>Date&Time</th>
						<th>Author</th>
						<th>Banner</th>
						<th>Comments</th>
						<th class="text-center">Action</th>
						<th>Live Preview</th>
					</tr>				 						
					</thead>
					<?php 
					global $ConnectingDB;
					$sql = "SELECT * FROM posts";
					$stmt = $ConnectingDB->query($sql);
					$Sr = 0;
					while ($DataRows = $stmt->fetch()) {
						$Id = $DataRows["id"];
						$DateTime =	$DataRows["datetime"];					
						$PostTitle = $DataRows["title"];
						$Category = $DataRows["category"];
						$Admin = $DataRows["author"];
						$Image = $DataRows["image"];
						$PostText =  $DataRows["post"];
						$Sr++;


					 ?>
					 <tbody style="min-height: 50px;">
					 <tr>
					 	<td><?php echo $Sr ?></td>
					 	<td ><?php if (strlen($PostTitle)>20){$PostTitle = substr($PostTitle,0, 18)."..";} echo $PostTitle;?></td>
					 	<td><?php if (strlen($Category)>8){$Category = substr($Category,0, 8)."..";} echo $Category;?></td>
					 	<td><?php if (strlen($DateTime)>11){$DateTime = substr($DateTime,0, 11)."..";} echo $DateTime;?></td>
					 	<td><?php if (strlen($Admin)>6){$Admin = substr($Admin,0, 6)."..";} echo $Admin;?></td>
					 	<td><img src="Uploads/<?php echo $Image;?>" width="170px;" height="50px;" ></td>
					 	<td><?php $Total = ApprovedCommentsAcardingToPosts($Id);
					 		if ($Total>0){?>
							<span class="badge badge-success" style="background:green; border-radius: 1;">
							<?php echo $Total;  ?>
							</span>
							<?php } ;?>
					 		<?php $Total = DisApprovedCommentsAcardingToPosts($Id);
					 			if ($Total>0){
					 		?>
					 		<span class="badge badge-danger" style="background:red; border-radius: 1;">
					 		<?php echo $Total;  ?>
					 		</span>
					 		<?php } ?>
					 	</td>
					 	<td><a href="EditPost.php?id=<?php echo $Id; ?>"><span class="btn btn-warning">Edit</span></a>
					 	<a href="DeletePost.php?id=<?php echo $Id; ?>"><span class="btn btn-danger">Delete</span></a>
					 	</td>
					 	<td><a href="FullPost.php?id=<?php echo $Id; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a></td>
					 </tr>
					 </tbody>
					 <?php } ?>

				</table>
			</div>
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