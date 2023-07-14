<?php

require_once('shared/system.php');
require_once('shared/dbFuncs.php');
require_once('shared/sharedFuncs.php');

$check = checklogin($_SESSION['username'], $_SESSION['password']);

$columns = array('DISPLAY_NAME','CREATE_DATE');
$column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[1];
$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'asc' ? 'ASC' : 'DESC';

$sql = "SELECT * FROM T_FILE WHERE FILE_TYPE_ID = 1 AND IS_DELETED = 0 ORDER BY " . $column . " " . $sort_order;

$up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
$asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';

$frrrs = do_sql($sql);

$newsletter_columns = array('display_name','create_date');
$newsletter_column = isset($_GET['newsletter_column']) && in_array($_GET['newsletter_column'], $newsletter_columns) ? $_GET['newsletter_column'] : $newsletter_columns[1];
$newsletter_sort_order = isset($_GET['newsletter_order']) && strtolower($_GET['newsletter_order']) == 'asc' ? 'ASC' : 'DESC';

$sql = "SELECT ID, DISPLAY_NAME AS NEWSLETTER_DISPLAY_NAME, CREATE_DATE AS NEWSLETTER_CREATE_DATE FROM T_FILE WHERE FILE_TYPE_ID = 2 AND IS_DELETED = 0 ORDER BY " . $newsletter_column . " " . $newsletter_sort_order;

$newsletter_up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $newsletter_sort_order); 
$newsletter_asc_or_desc = $newsletter_sort_order == 'ASC' ? 'desc' : 'asc';

$nlrs = do_sql($sql);

include_once('includes/header.php');
?>
<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.3.1/css/all.css' integrity='sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU' crossorigin='anonymous'>
<style>
	th { border-bottom-width: 1px;
    border-bottom-style: solid;
    border-bottom-color: #0C223F;}
	td, th { color: #0C223F; padding-top: 0.25em; padding-bottom: 0.5em; padding-right: 1em; padding-left: 1em;}
	td a { color: #0C223F; }
</style>

<section id="intro-boxes">
	<div class="row">

		<div class="col-md-1">&nbsp;</div>
		<div class="col-md-9">
			<h1>Investor Relations</h1>			
		</div>
		<div class="col-md-2">			
			<a href="logout.php" style="margin-top: 2em;" class="btn btn-primary float-right">Logout</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-1">&nbsp;</div>
		<div class="col-md-5">
			<h2>Financial Results Reports</h2>
			<table class="sortable">
				<tr>
					<th><a href="index.php?column=DISPLAY_NAME&order=<?php echo $asc_or_desc; ?>">File Name<i style="margin-left:5px;" class="fas fa-sort<?php echo $column == 'DISPLAY_NAME' ? '-' . $up_or_down : ''; ?>"></i></a></th>
					<th><a href="index.php?column=CREATE_DATE&order=<?php echo $asc_or_desc; ?>">Posted on<i style="margin-left:5px;" class="fas fa-sort<?php echo $column == 'CREATE_DATE' ? '-' . $up_or_down : ''; ?>"></i></a></th>
		
				</tr>
				<?php
				foreach ($frrrs as $row)
				{
					echo '<tr><td><a href="./download.php?id='.$row['ID'].'&" target="_blank" title="'.$row['DISPLAY_NAME'].'">'.$row['DISPLAY_NAME'].'</a></td><td>'.date("F j, Y - H:i", strtotime($row['CREATE_DATE'])).'</td></tr>';
				}?>	
			</table>
		</div>

		<div class="col-md-6">
			<h2>Newsletters</h2>
			<table>
				<tr>
					<th><a href="index.php?newsletter_column=display_name&newsletter_order=<?php echo $newsletter_asc_or_desc; ?>">File Name<i style="margin-left:5px;" class="fas fa-sort<?php echo $newsletter_column == 'display_name' ? '-' . $newsletter_up_or_down : ''; ?>"></i></a></th>
					<th><a href="index.php?newsletter_column=create_date&newsletter_order=<?php echo $newsletter_asc_or_desc; ?>">Posted on<i style="margin-left:5px;" class="fas fa-sort<?php echo $newsletter_column == 'create_date' ? '-' . $newsletter_up_or_down : ''; ?>"></i></a></th>
				</tr>
				<?php
				foreach ($nlrs as $row)
				{
					echo '<tr><td><a href="./download.php?id='.$row['ID'].'&" target="_blank" title="'.$row['NEWSLETTER_DISPLAY_NAME'].'">'.$row['NEWSLETTER_DISPLAY_NAME'].'</a></td><td>'.date("F j, Y - H:i", strtotime($row['NEWSLETTER_CREATE_DATE'])).'</td></tr>';
				}?>	
			</table>
		</div>
	</div>

	<div class="row" style="margin-top: 25%;">
		<div class="col-md-1">&nbsp;</div>
		<div class="col-md-11">
			<h3>For any questions please contact <a href="mailto:investorrelations@beyondmpd.com">investorrelations@beyondmpd.com</a></h3>
		</div>
	</div>
</section>
<?php
	include_once('includes/footer.php');
?>

