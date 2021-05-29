<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Function.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php $SearchQueryParametr = $_GET['id']; ?>
<?php 
$PostIdFromURL=$_GET["id"];
if (!isset($PostIdFromURL)) {
	$_SESSION['ErrorMessage'] = "Bad Recuest !";
	Redirect_to("Blog.php");
} 
if(isset($_POST["Submit"])){
	$Name = $_POST["CommenterName"];
	$Email = $_POST["CommenterEmail"];
	$Comment = $_POST["CommenterThoughts"];
	$CurrentTime=time();
	$DateTime=strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
	if(empty($Name)||empty($Email)||empty($Comment)){
		$_SESSION['ErrorMessage'] = 'All fields must be filed out';
		Redirect_to("FullPost.php?id={$SearchQueryParametr}");
	}elseif(strlen($Comment)>500){
		$_SESSION['ErrorMessage'] = 'Comment lenght should be less than 500 characters';
		Redirect_to("FullPost.php");
	}else{
		//Query to insert comment in DB when everything is fine
		global $ConnectingDB;
		$sql = "INSERT INTO comments(datetime,name,email,comment,approvedby,status,post_id)";
		$sql .= "VALUES(:dateTime,:name,:email,:comment,'Pending','OFF',:postIdFromURL)";
		$stmt = $ConnectingDB->prepare($sql);
		$stmt->bindValue(':dateTime',$DateTime);
		$stmt->bindValue(':name', $Name);
		$stmt->bindValue(':email', $Email);
		$stmt->bindValue(':comment',$Comment);
		$stmt->bindValue(':postIdFromURL',$SearchQueryParametr);
		$Execute = $stmt->execute();
		if($Execute){
			$_SESSION['SuccessMessage']="Comment submitted  successfully";
			Redirect_to("FullPost.php?id={$SearchQueryParametr}");
		}else{
			$_SESSION['ErrorMessage'] = 'Somthing went wrong. Try Again !';
			Redirect_to("FullPost.php?id={$SearchQueryParametr}");
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
	<link rel="stylesheet" href="css/style.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
	<title>Full Post </title>
	<style>
		.CommentBlock{
			background-color:#F6F7F9;
		}
	</style>
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
					<a href="Blog.php" class="nav-link">Home</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">About Us</a>
				</li>
				<li class="nav-item">
					<a href="Blog.php" class="nav-link">Blog</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">Contact Us</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">Featchers</a>
				</li>
			</ul>
			</div>
			<ul class="navbar-nav ml-auto " >
				<form class="form-inline d-none d-sm-block" action="Blog.php" >
					<div class="form-group">
						<input class="form-control mr-2"type="text" name="Search" placeholder="Search her">
						<button   class="btn btn-primary" name="SearchButton">Go</button>
					</div>
				</form>
			</ul>
		</div>
	</nav>
	<div style="height:10px; background: #27aae1;"></div>
	<!-- navbar end -->
	<!-- HEADER -->
	<div class="container">
		<div class="row mt-4">
			<!-- Main area -->
			<?php 
			echo ErrorMassage();
			echo SuccessMassage();
			?>
			<div class="col-sm-8 " >
				<h1>The Complate Responsive CMS Blog</h1>
				<h1 class="lead">The Complate blog by using PHP by Jazeb Akram</h1>
				<?php 
				global $ConnectingDB;
				if (isset($_GET["SearchButton"])) {
					$Search = $_GET["Search"];
					$sql = "SELECT * FROM posts 
					WHERE datetime LIKE :search 
					OR category LIKE :search 
					OR post LIKE :search";
					$stmt = $ConnectingDB->prepare($sql);
					$stmt-> bindValue(":search",'%'.$Search.'%');
					$stmt->execute();
				}else{
					$sql = "SELECT * FROM posts WHERE id='$PostIdFromURL' ";
					$stmt = $ConnectingDB->query($sql);
					$Result = $stmt->rowcount();
					if ($Result != 1) {
						$_SESSION["ErrorMassage"] = "Bad Recuest !!";
						Redirect_to("Blog.php?page=1");
					}
				}
				while ($DataRows = $stmt->fetch()) {
					$PostId = $DataRows["id"];
					$DateTime = $DataRows["datetime"];
					$PostTitle = $DataRows["title"];
					$Category = $DataRows["category"];
					$Admin = $DataRows["author"];
					$Image = $DataRows["image"];
					$PostDescription = $DataRows["post"];
				?>
				<div class="card">
					<img src="Uploads/<?php echo htmlentities($Image); ?>"class="img-fluid card-img-top" style="max-height:450px;" alt="">
					<div class="card-body">
						<h4 class="card-title"><?php echo htmlentities($PostTitle); ?></h4>
						<small class="text-muted">Category: <span class="text-dark"><a href="Blog.php?category=<?php echo htmlentities($Category);?>"><?php echo htmlentities($Category);?></a></span> Written by <span class="text-dark"><a href="Profile.php?username=<?php echo htmlentities($Admin); ?>"><?php echo htmlentities($Admin);?></a></span> On <span class="text-dark"><?php echo htmlentities($DateTime); ?></span>  </small>
						<hr>
						<p class="card-text"><?php echo nl2br($PostDescription); ?></p>
					</div>
				</div>
				<br>
				<?php } ?>
				<!-- COMMENT START -->
				<span class="FieldInfo" >Comments</span>
				<br><br>
				<?php 
				global $ConnectingDB;
				$sql = "SELECT * FROM comments 
				WHERE post_id='$SearchQueryParametr' AND status='ON'";
				$stmt=$ConnectingDB->query($sql);
				while($DataRows=$stmt->fetch()){
					$CommentDate = $DataRows['datetime'];
					$CommenterName = $DataRows["name"];
					$CommenterContent = $DataRows["comment"];
				
				 ?>
				 <div>
				 	<div class="media CommentBlock" >
				 		<img class="d-block img-fluid align-self-center" src="images/avatar.jpg" style="max-height: 70px;">
				 		<div class="media-body ml-2">
				 			<h6 class="lead"><?php echo $CommenterName; ?></h6>
				 			<p class="small"><?php echo $CommentDate; ?></p>
				 			<p><?php echo $CommenterContent; ?></p>
				 		</div>
				 	</div>
				 </div>
				 <hr>
				 <?php } ?>
				<!-- COMMENT END -->
				<div class="">
					<form action="FullPost.php?id=<?php echo $SearchQueryParametr; ?>" class="" method="post">
						<div class="card mb-3">
							<div class="card-header">
								<h5 class="FieldInfo">Search you thoughts about this post</h5>
							</div>
							<div class="card-body">
								<div class="form-group">
									<div class="input-group">
										<div class="input-group-prepend">
											<span style="height: 40px;"class="input-group-text "><i class="fas fa-user"></i></span>
										</div>	
									<input type="text"  name="CommenterName" placeholder="Name" class="form-control">
									</div>
								</div>
								<div class="form-group mt-2">
									<div class="input-group">
										<div class="input-group-prepend">
											<span style="height: 40px;"class="input-group-text"><i class="fas fa-envelope"></i></span>
										</div>	
									<input type="email"  name="CommenterEmail" placeholder="Email" class="form-control">
									</div>
								</div>
								<div class="form-group mt-3">
									<textarea name ="CommenterThoughts" class="form-control" rows="6" cols="80"></textarea>
								</div>
								<button type="submit" name="Submit" class="btn btn-primary mt-3">Submit</button>
							</div>
						</div>
					</form>
				</div>
			</div>

			<!-- Main area end -->


			<!-- Side area --> 
			<?php require_once("footer.php"); ?>
		<!-- Side area end -->
	</div>
	<!-- END HEADER -->
	<br>
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