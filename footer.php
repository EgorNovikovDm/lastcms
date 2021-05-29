<div class=" col-sm-4">
				<div class="card mt-4">
					<div class="card-body">
						<img src="images/blogging.png" class='d-block img-fluid mb-3' alt="">
						<div class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
						</div>
					</div>
				</div>
				<div class="card mt-4">
					<div class="card-header bg-dark text-light">
						<h2 class="lead">Sign Up!</h2>
					</div>
					<div class='card-body'>
						<button type="button" class="btn btn-success btn-block text-center text-white" name="button">Jpin the Forum</button>
						<button type="button" class="btn btn-danger btn-block text-center text-white" name="button">Login</button>
						<div class="input-group mt-4 mb-3" >
							<input type="text" class="form-control" name="" placeholder="Enter your email">
							<div class="input-group-append">
								<button type="button" class="btn btn-primary btn-sm text-center text-white">Subscribe Now</button>
							</div>
						</div>
					</div>
				</div>
				<div class="card mt-4">
				<div class="card-header bg-primary text-light">
					<h2 class="lead">Categories</h2>
				</div>
					<div class="card-body">
						<?php 
						global $ConnectingDB;
						$sql = "SELECT * FROM category ORDER BY id desc";
						$stmt = $ConnectingDB->query($sql);
						while ($DataRows = $stmt->fetch()) {
							$CategoryId = $DataRows['id'];
							$CategoryName = $DataRows['title'];
						 ?>
						<a href="Blog.php?category=<?php echo $CategoryName;?>"><span class="heading"><?php echo $CategoryName; ?></span></a> <br>
						<?php } ?>
				</div>
			</div>
			<br>
			<div class="card">
				<div class="card-header bg-info text-white">
					<h2 class="lead">Recent Posts</h2>
				</div>
				<div class="card-body">
					<?php 
					global $ConnectingDB;
					$sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
					$stmt = $ConnectingDB->query($sql);
					while ($DataRows = $stmt->fetch()) {
						$Id = $DataRows['id'];
						$Title = $DataRows["title"];
						$DateTime = $DataRows['datetime'];
						$Image = $DataRows['image'];
				
					 ?>
					<div class="media">
					<img src="Uploads/<?php echo htmlentities($Image); ?>" class="d-block img-fluid align-self-start mr-2" width="90" height="94" alt="">
					<div class="media-body ">
						<a class='nav-link' href="FullPost.php?id=<?php echo htmlentities($Id); ?>" target="_blank"><h6 class="lead"><?php echo htmlentities($Title); ?></h6></a>
						<p class="small"><?php echo htmlentities($DateTime); ?></p>
					</div>
					</div>
					<hr>
					<?php } ?>
				</div>
			</div>

			</div>
			<br>
		</div>