<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Function.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://kit.fontawesome.com/75e6dc1698.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="css/style.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
	<title>Blog Page</title>
	<style type="text/css">
		.FieldInfo{
	color:rgb(251,174,44);
	font-family:Bitter,Georgia,"Times New Roman",Times,serif;
	font-size:1.2em;
}
.CommentBlockk{
	background-color:#F6F7F9;
}
.heading{
	font-family: Bitter,Georgia,"Times New Roman",Times,serif;
	font-weight: bold;
	color: #005E90;
}
.heading-hover{
	color:#0090DB;
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
				<form class="form-inline d-none d-sm-block" action="Blog.php" s >
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
			<div class="col-sm-8 " >
				<h1>The Complate Responsive CMS Blog</h1>
				<h1 class="lead">The Complate blog by using PHP by Jazeb Akram</h1>
				<?php echo ErrorMassage();
					echo SuccessMassage();
				 ?>
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
				}elseif (isset($_GET["page"])) {
					$Page = $_GET["page"];
					if ($Page == 0 || $Page<0){
						$ShowPostFrom=0;
					}else{
					$ShowPostFrom=($Page*4)-4;
					}
						$sql = "SELECT * FROM posts ORDER BY id desc LIMIT $ShowPostFrom,4";
						$stmt=$ConnectingDB->query($sql);
				}
				elseif (isset($_GET["category"])){
					$Category = $_GET["category"];
					$sql = "SELECT * FROM posts WHERE  category=:categoryName  ORDER BY id desc";
					$stmt = $ConnectingDB->prepare($sql);
					$stmt->bindValue(':categoryName', $Category);
					$stmt->execute();
				}
				else{
					$sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,3";
					$stmt = $ConnectingDB->query($sql);
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
						<span style="float: right;" class="badge badge-dark text-light bg-dark">Comments <?php 
						echo ApprovedCommentsAcardingToPosts($PostId);
						
						 ?></span>
						<hr>
						<p class="card-text"><?php if (strlen($PostDescription)>150) {
							$PostDescription = substr($PostDescription, 0, 149)."...";						
						}echo htmlentities($PostDescription); ?></p>
						<a href="FullPost.php?id=<?php echo $PostId; ?>" style="float:right;">
							<span class="btn btn-info">Read More >></span>
						</a>
					</div>
				</div>
				<br>
				<?php } ?>
				<!-- PAGINATION -->
				<nav>
					<ul class="pagination pagination-md">
						<?php if (isset($Page)){
							if ($Page>1) {
						?>
						<li class="page-item ">
							<a href="Blog.php?page=<?php echo $Page-1; ?>" class="page-link ">&laquo;</a>
						</li>
						 <?php } } ?>
						<?php 
						global $ConnectingDB;
						$sql = "SELECT COUNT(*) FROM posts ";
						$stmt = $ConnectingDB->query($sql);
						$RowPagination = $stmt->fetch();
						$TotalPost = array_shift($RowPagination);
						$PostPagination	 = $TotalPost/4;
						$PostPagination=ceil($PostPagination);
						for ($i = 1; $i<=$PostPagination; $i++) {
							if (isset($Page)) {
								if ($i==$Page) {
					
						 ?>
						<li class="page-item active">
							<a href="Blog.php?page=<?php echo $i; ?>" class="page-link "><?php echo $i; ?></a>
						</li>

						<?php 
						}else{
						?>	<li class="page-item ">
							<a href="Blog.php?page=<?php echo $i; ?>" class="page-link "><?php echo $i; ?></a>
						</li>
						<?php }
						} } ?>

						<?php if (isset($Page)&&!empty($Page)){
							if ($Page+1<=$PostPagination) {
						?>
						<li class="page-item ">
							<a href="Blog.php?page=<?php echo $Page+1; ?>" class="page-link ">&raquo;</a>
						</li>

						 <?php } } ?>
					</ul>
				</nav>
			</div>

			<!-- Main area end -->


			<!-- Side area --> 
			<?php require_once("footer.php");?>
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