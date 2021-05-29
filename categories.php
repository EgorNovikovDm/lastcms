<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Function.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php 
$_SESSION["TrakingURL"] =  $_SERVER["PHP_SELF"];
//echo $_SESSION["TrakingURL"];
Confirm_Login(); ?>
<?php 
if(isset($_POST["Submit"])){
	$Category = $_POST["CategoryTitle"];
	$Admin = $_SESSION["UserName"];
	$CurrentTime=time();
	$DateTime=strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
	if(empty($Category)){
		$_SESSION['ErrorMessage'] = 'All fields must be filed out';
		Redirect_to("categories.php");
	}elseif(strlen($Category)<3){
		$_SESSION['ErrorMessage'] = 'Category title should be greater than 2 characters';
		Redirect_to("categories.php");
	}elseif(strlen($Category)>49){
		$_SESSION['ErrorMessage'] = 'Category title should be less than 50 characters';
		Redirect_to("categories.php");
	}else{
		//Query to insert category in DB when everything is fine
		global $ConnectingDB;
		$sql = "INSERT INTO category(title,author,datetime)";
		$sql .= "VALUES(:categoryName,:adminName,:dateTime)";
		$stmt = $ConnectingDB->prepare($sql);
		$stmt->bindValue(':categoryName',$Category);
		$stmt->bindValue(':adminName',$Admin);
		$stmt->bindValue(':dateTime',$DateTime);
		$Execute = $stmt->execute();
		if($Execute){
			$_SESSION['SuccessMessage']="Category whith id:".$ConnectingDB->lastInsertId()." Added Successfully";
			Redirect_to("categories.php");
		}else{
			$_SESSION['ErrorMessage'] = 'Somthing went wrong. Try Again !';
			Redirect_to("categories.php");
		}
	}
}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://kit.fontawesome.com/75e6dc1698.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
	<title>Categories</title>
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
			
			<ul class="navbar-nav ml-auto" style="margin:auto">
				<li class="nav-item"><a href="Logout.php"class="nav-link text-danger">
					<i class="fas fa-user-times ">Logout</i></a></li>
			</ul>
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
				<h1><i class="fas fa-edit" style="color:#27aae1;"></i>Manage Caregorise</h1>
				</div>
			</div>
		</div>
	</header>
	<!-- END HEADER -->

	<!-- main area -->
	<section class="container py-2 mb-4">
		<div class="row" >
			<div class="offset-lg-1 col-lg-10"style="min-height: 400px;" >
				<?php echo ErrorMassage();
						echo SuccessMassage();
				 ?>
				<form action="categories.php" method="post">
					<div class="card bg-secondary text-light mb-3">
						<div class="card-header">
							<h1>Add New Category</h1>
						</div>
						<div class="card-body bg-dark">
							<div class="form-group">
								<label for="title"><span class="FieldInfo"> Category Title:</span> </label>
								<input class="form-control"type="text" name="CategoryTitle" id="title" placeholder="Type title here">
							</div>
							<div class="row" >
								<div class="col-lg-6 mb-2" style="margin-top:5px;">
									<a href="Dashboard.php" class="btn btn-warning  btn-block"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
								</div>
								<div class="col-lg-6 mb-2" style="margin-top:5px;">
									<button type="submit" name="Submit" class="btn btn-success btn-block"><i class="fas fa-check"></i> Publish
									</button>
								</div>
							</div>
						</div>
					</div>
				</form>
				<h2>Existing Categories</h2>
				<table class="table table-striped table-hover">
					<thead class="table-dark">
						<tr>
							<th>№</th>
							<th>Category Name</th>
							<th>Date&Time</th>
							<th>Creator Name</th>
							<th>Delete</th>
						</tr>
					</thead>
				<?php 
				global $ConnectingDB;
				$sql = "SELECT * FROM category ORDER BY id desc ";
				$Execute = $ConnectingDB->query($sql);
				$SrNo = 0;
				while ($DataRows = $Execute->fetch()) {
					$CategoryId = $DataRows['id'];
					$CategoryDate = $DataRows['datetime'];
					$CategoryName = $DataRows["title"];
					$CreatorName = $DataRows['author'];
					$SrNo++;
				 ?>
				 <tbody>
				 	<tr>
				 		<td><?php echo htmlentities($SrNo);?></td>
				 		<td><?php echo  htmlentities($CategoryName) ;?></td>
				 		<td><?php echo  htmlentities($CategoryDate);?></td>
				 		<td><?php echo  htmlentities($CreatorName);?></td>
				 		<td><a href="DeleteCategories.php?id=<?php echo $CategoryId?>" class="btn btn-danger">Delete</a></td>
				 	</tr>
				 	<?php } ?>
				 </tbody>
				 </table>
			</div>
		</div>

	</section>

	<!-- main area end -->

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