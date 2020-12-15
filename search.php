<?php
    require_once "Controllers/pagesController.php";
    require_once "Models/pagesModel.php";

	if(isset($_GET["term"])) {
		$term = $_GET["term"];
	}
	else {
		exit("You must enter a search term");
	}
	
	$type = isset($_GET["type"]) ? $_GET["type"] : "sites";
	$pageNumber = isset($_GET['page'])?$_GET['page']:1;
?>


<!DOCTYPE html>
<html>
<head>
	<title>Search Engine</title>

	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

</head>
<body>

	<div class="wrapper">
	
		<div class="header">


			<div class="headerContent">

				<div class="logoContainer">
					<a href="index.php">
						<img src="assets/images/doodleLogo.png">
					</a>
				</div>

				<div class="searchContainer">

					<form action="search.php" method="GET">

						<div class="searchBarContainer">

							<input class="searchBox" type="text" name="term" value="<?php echo $term; ?>">
							<button class="searchButton">
								<img src="assets/images/icons/search.png">
							</button>
						</div>

					</form>

				</div>

			</div>


			<div class="tabsContainer">

				<ul class="tabList">

					<li class="<?php echo $type == 'sites' ? 'active' : '' ?>">
						<a href='<?php echo "search.php?term=$term&type=sites"; ?>'>
							Sites
						</a>
					</li>

					<li class="<?php echo $type == 'images' ? 'active' : '' ?>">
						<a href='<?php echo "search.php?term=$term&type=images"; ?>'>
							Images
						</a>
					</li>

				</ul>


			</div>
		</div>










		<div class="mainResultsSection">

            <?php
				if($type=='sites'){
					$pagesControllerObj = new pagesController();

					$numResults = $pagesControllerObj->getTotalNumOfPagesResults($term);
					$searchResults = $pagesControllerObj->getPagesResults($term, $pageNumber);
					
					echo "<p class='resultsCount'>$numResults results found</p>";
					foreach($searchResults as $res){
						$url = $res['url'];
						$title = $res['title'];
						$description = $res['description'];

						echo "<div class='resultContainer'>

								<h3 class='title'>
									<a class='result' href='$url'>
										$title
									</a>
								</h3>
								<span class='url'>$url</span>
								<span class='description'>$description</span>
							</div>";
					}
				}
			?>

			<?php 
				if($type == 'images'){


				}
			?>


		</div>



	</div>

</body>
</html>