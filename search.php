<?php
    require_once "Controllers/pagesController.php";
	require_once "Controllers/imagesController.php";
	require_once "utils/paginationSystem.php";

	if(isset($_GET["term"])) {
		$term = $_GET["term"];
	}
	else {
		exit("You must enter a search term");
	}
	
	$type = isset($_GET["type"]) ? $_GET["type"] : "sites";
	$pageNumber = isset($_GET['page'])?$_GET['page']:1;
	$requestNumber = isset($_GET['reqNum'])?$_GET['reqNum']:1;
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
						<img src="https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png">
					</a>
				</div>

				<div class="searchContainer">

					<form action="search.php" method="GET">

						<div class="searchBarContainer">

							<input class="searchBox" id = 'searchTerm' type="text" name="term" value="<?php echo $term; ?>">
							<input type='hidden' name='type' value="<?= $type?>">
							<button class="searchButton">
								<img src="assets/images/icons/search.png">
							</button>
						</div>

					</form>

				</div>

			</div>


			<div class="tabsContainer">

				<ul class="tabList">

					<li class="<?php echo $type == 'sites' ? 'active' : '' ?>" data-type='sites'>
						<a href='<?php echo "search.php?term=$term&type=sites"; ?>'>
							Sites
						</a>
					</li>

					<li class="<?php echo $type == 'images' ? 'active' : '' ?>" data-type='images'>
						<a href='<?php echo "search.php?term=$term&type=images"; ?>'>
							Images
						</a>
					</li>

				</ul>


			</div>
		</div>










		<div class="mainResultsSection">

			<?php
				$resultsPerPage = 10;
				if($type=='sites'){
					$pagesControllerObj = new pagesController();

					$numResults = $pagesControllerObj->getTotalNumOfPagesResults($term);
					$searchResults = $pagesControllerObj->getPagesResults($term, $pageNumber);
					
					echo "<p class='resultsCount'>$numResults results found</p>";
					foreach($searchResults as $res){
						$id = $res['id'];
						$url = $res['url'];
						$title = $res['title'];
						$description = $res['description'];

						/*
							format theses information in a more a approriate way 
						 */
						$title = substr($title, 0, 50);
						$description = substr($description, 0, 100);
						echo "<div class='resultContainer'>
								<input class='pageUrlID' type='hidden' value ='$id'>
								<h3 class='title'>
									<a class='result' href='$url' onclick='increaseUrlClick(event)'>
										$title
									</a>
								</h3>
								<span class='url'>$url</span>
								<span class='description'>$description</span>
							</div>";
					}
				}
			?>

			<div class="imageGrid">
				<?php 
					if($type == 'images'){
						$imagesControllerObj = new imagesController();

						$numResults = $imagesControllerObj->getTotNumOfImgsResults($term);
						echo "<p> $numResults </p>";

						$imgsResult = $imagesControllerObj->getImagesResult($term, $requestNumber);

						foreach($imgsResult as $img)
						{

							$url = $img['imageUrl'];
							$alt = $img['alt'];
							$title = $img['title'];
							if($alt)
								$displayText = $alt;
							else if($title)
								$displayText = $title;
							else 
								$displayText = $url;

							echo "<div class='gridItem'>
									<a href='$url'>
										<img src='$url'>
										<span class='details'>$displayText</span>
									</a>
								</div>";	
						}
					}
				?>
			</div>

		</div>

		<div class='paginationSystem'>
			<?php
			if($type !='images'){
				// constants
				$numberOfHrefs = 10;
				$totalNumberOfPages = ceil($numResults / $resultsPerPage);

				// get boundries
				$paginationObj = new paginationSystem();
				$boundries = $paginationObj->getBoundries($totalNumberOfPages,$numberOfHrefs,
															$pageNumber);

				$start = $boundries['start'];
				$end = $boundries['end'];

				// display 

				// previous button 
				if($start !=1){
					$prevPageNumber = $pageNumber -1;
					$href = "search.php?term=$term&type=$type&page=$prevPageNumber";
					echo "<a href='$href'>Prev</a>";
				}

				// hrefs 
				for($index = $start; $index <=$end; $index+=1)
				{
					$href = "search.php?term=$term&type=$type&page=$index";
					echo "<a class='paginationHref' href='$href' > $index <a>";
				}

				// next button
				if($end !=$totalNumberOfPages){
					$nextPageNumber = $pageNumber +1;
					$href = "search.php?term=$term&type=$type&page=$nextPageNumber";
					echo "<a href='$href'>Next</a>";
				}
			}
			?>
		</div>



	</div>
	<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>

	<script src="js/app.js"> </script>
	<script src="js/images.js"> </script>
</body>
</html>