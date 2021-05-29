<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Function.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php 
$_SESSION["TrakingURL"] =  $_SERVER["PHP_SELF"];
Confirm_Login(); ?>
<?php 
if(isset($_POST["Submit"])){
	$PostTitle = $_POST["PostTitle"];
	$Category = $_POST["Category"];
	$Image = $_FILES["Image"]["name"];
	$Target = "Uploads/".basename($_FILES["Image"]["name"]);
	$PostText = $_POST["PostDescription"];
	$Admin = $_SESSION["UserName"];
	$CurrentTime=time();
	$DateTime=strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
	if(empty($PostTitle)){
		$_SESSION['ErrorMessage'] = 'Title cant be empty';
		Redirect_to("AddNewPost.php");
	}elseif(strlen($PostTitle)<5){
		$_SESSION['ErrorMessage'] = 'Post title should be greater than 5 characters';
		Redirect_to("AddNewPost.php");
	}elseif(strlen($PostText)>999){
		$_SESSION['ErrorMessage'] = 'Post Description  should be less than 1000 characters';
		Redirect_to("AddNewPost.php");
	}else{
		//Query to insert Post in DB when everything is fine
		global $ConnectingDB;
		$sql = "INSERT INTO posts(datetime,title,category,author,image,post)";
		$sql .= "VALUES(:dateTime,:postTitle,:categoryName,:adminName,:imageName,:postDescription)";
		$stmt = $ConnectingDB->prepare($sql);
		$stmt->bindValue(':dateTime',$DateTime);
		$stmt->bindValue(':postTitle',$PostTitle);
		$stmt->bindValue(':categoryName',$Category);
		$stmt->bindValue(':adminName',$Admin);
		$stmt->bindValue(':imageName',$Image);
		$stmt->bindValue(':postDescription',$PostText);
		$Execute = $stmt->execute();
		move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
		if($Execute){
			$_SESSION['SuccessMessage']="Category whith id:".$ConnectingDB->lastInsertId()." Added Successfully";
			Redirect_to("AddNewPost.php");
		}else{
			$_SESSION['ErrorMessage'] = 'Somthing went wrong. Try Again !';
			Redirect_to("AddNewPost.php");
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
				<li class="nav-item"><a href="Login.php"class="nav-link text-danger">
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
				<h1><i class="fas fa-edit" style="color:#27aae1;"></i>Add New Post</h1>
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
				<form action="AddNewPost.php" method="post" enctype="multipart/form-data">
					<div class="card bg-secondary text-light mb-3"> 
						<div class="card-body bg-dark">
							<div class="form-group">
								<label for="title"><span class="FieldInfo">  Post  Title:</span> </label>
								<input class="form-control"type="text" name="PostTitle" id="title" placeholder="Type title here">
							</div>
							<div class="form-group mb-1">
								<label for="CategoryTitle"><span class="FieldInfo"> Chose Category:</span> </label>
								<select class = "form-control" name="Category" id="CategoryTitle">
								<?php 
								//Fetching all the categories  from category table
								global $ConnectingDB;
								$sql = "SELECT id,title FROM category";
								$stmt = $ConnectingDB->query($sql);
								while ($DataRows = $stmt->fetch()) {
									$Id = $DateRows["id"];
									$CategoryName = $DataRows["title"];
								
								 ?>
								 <option value=""><?php echo $CategoryName; ?></option>
								 <?php } ?>
								</select>
							</div>
							<div class="form-group mb-1">
								<div class="custom-file">
								<input class="custom-file-input" type="File" name="Image" if="imageSelect" >
								<label fo="imageSelect" class="custom-file-label"></label>
								</div>
							</div>
							<div class="form-group">
								<label for="Post"><span class="FieldInfo">Post: </span></label>
								<textarea class="form-control" id="Post" name="PostDescription" rows="8" col="80"></textarea>
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