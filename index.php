<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="utf-8">
  <title>TSH Web Developer Task</title>

  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,900&display=swap" rel="stylesheet">
  <link href="font/fontello-min.css" rel="stylesheet">
  <link href="style.css" rel="stylesheet" />

</head>
<body>
<div class="wrapper">

<?php
/*
 * Pagination function (for demo purpose just like WP)
 */

function pagination($files_array) {
	$page = 0;
	global $current_page;

	// Check if not empty and if page exist
	if (!empty($files_array) && ($current_page <= count($files_array))):
	echo '<nav class="pagination">';
		if ($current_page > 1) echo '<a class="prev pager" href="'.(($current_page == 2) ? '/' : '?page='.($current_page-1)).'"><i class="icon-left-open"></i></a>';
		echo'<ul>';
		foreach ($files_array as $file):
			$page++;
			echo '<li '.(($current_page == $page || ($current_page == 0 && $page == 1)) ? 'class="active"' : '').'><a href="'.(($page == 1) ? '/' : '?page='.$page).'" class="pager">'.$page.'</a></li>';
		endforeach;
		echo '</ul>';
		if ($current_page < count($files_array)) echo '<a href="?page='.($current_page+1).'" class="next pager"><i class="icon-right-open"></i></a>';
	echo '</nav>';
	endif;
}


/*
 * Error message
 */
 function error_message() {
	 echo '<main class="error-message">
			<p>Requested page does not exist.</p>
		</main>';
 }

/*
 * Getting files and create some loop
 */

// Here U can set source directory
$directory = 'data';
$current_page = intval($_GET['page']);

// Getting files only with json extension
if (file_exists($directory)):
	$json_files = glob($directory.'/page*.{json}', GLOB_BRACE);
	sort($json_files,SORT_NATURAL);


	// Check if not empty and if page exists
	if (!empty($json_files) && ($current_page <= count($json_files))):

	// Set '1' for first page and for page without no
		if ($current_page == 0):
			$current_page = 1;
		endif;

	// Read json file
		$json_data = json_decode(file_get_contents($json_files[$current_page - 1]), true); ?>
		<main class="main-content">
			<h1 class="title">Where your money goes</h1>
			<p class="desc">Payments made by Chichester District Council to individual suppliers with a value over £500 made within October.</p>
			<hr>
		<!-- Search form -->
			<form class="search">
				<input type="search" placeholder="Search suppliers">
				<div class="select-background">
					<select>
						<option>Select pound rating</option>
						<option>&bull;</option>
						<option>&bull;&bull;</option>
						<option>&bull;&bull;&bull;</option>
						<option>&bull;&bull;&bull;&bull;</option>
						<option>&bull;&bull;&bull;&bull;&bull;</option>
					</select>
				</div>
				<button type="reset">Reset</button>
				<button type="submit">Search</button>
			</form>

		<section class="table">
			<!-- Table header -->
			<div class="table-header row">
				<div class="supplier">Supplier</div>
				<div class="pound-rating">Pound rating</div>
				<div class="reference">Reference</div>
				<div class="value">Value</div>
			</div>

			<!-- Content table -->
			<div class="table-body">
			<?php

			// Loop through results

				foreach($json_data as $row): ?>
				<figure class="row">
					<div class="supplier"><?php echo $row['name']; ?></div>
					<div class="pound-rating">
						<ul class="rate-<?php echo $row['rating']; ?>">
							<li>£</li>
							<li>£</li>
							<li>£</li>
							<li>£</li>
							<li>£</li>
						</ul>
					</div>
					<div class="reference"><?php echo $row['reference']; ?></div>
					<div class="value">£<?php echo number_format($row['value']); ?></div>
				</figure>
				<?php endforeach; ?>
			</div>
		</section>
		<?php pagination($json_files); ?>
		</main>

	<?php
	// Message if page no exists
	else:
		error_message();
	endif;

else:
	error_message();
endif; ?>

</div>

<!-- Modal -->
<section id="modal">
	<h1 class="title">Details:</h1>
	<div class="data"></div>
	<button id="close-modal">Zamknij</button>
</section>

  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script>
  $( "figure.row" ).click(function() {
  	  $(document.body).addClass('modal-open');
  	  $( "#modal > .data").empty();
	  $(this).clone().appendTo("#modal > .data");
  });
  $( "#modal > #close-modal" ).click(function() {
	  $(document.body).removeClass('modal-open');
  });
  </script>
</body>
</html>