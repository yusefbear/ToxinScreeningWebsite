<!doctype html>
<?php require 'connection.php'; ?>
<html>

<!-- DC Table Styles I CSS -->
<head>

  <link rel="stylesheet" href="styles/main.css">
    <!-- build:js scripts/vendor/modernizr.js -->
  <script src="./bower_components/modernizr/modernizr.js"></script>
  <!-- endbuild -->

  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <!-- bootstrap.js below is only needed if you wish to use the feature of viewing details 
    of text file preview via modal dialog -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js" type="text/javascript"></script>  
    
	<style type="text/css">
		.zui-table {
			border: solid 1px #DDEEEE;
			border-collapse: collapse;
			border-spacing: 0;
			font: normal 13px Arial, sans-serif;
		}
		.zui-table thead th {
			background-color: #DDEFEF;
			border: solid 1px #DDEEEE;
			color: #336B6B;
			padding: 2px;
			text-align: center;
			text-shadow: 1px 1px 1px #fff;
		}
		.zui-table tbody td {
			border: solid 1px #DDEEEE;
			color: #333;
			padding: 2px;
			text-shadow: 1px 1px 1px #fff;
		}
		.zui-table-zebra tbody tr:nth-child(odd) {
			background-color: #fff;
		}
		.zui-table-zebra tbody tr:nth-child(even) {
			background-color: #EEF7EE;
		}
		.zui-table-horizontal tbody td {
			border-left: 1px solid #DDEFEF;
			border-right: 1px solid #DDEFEF;
		}

		label{
			color: #B4886B;
			text-align: left;
			font-family: Arial, Helvetica, sans-serif;
			font-size: 25px;
		}

		td, th {
			white-space: nowrap;
			overflow: hidden;
		}
	</style>
</head>

<body>
        <div class="header">
          <ul class="nav nav-pills pull-right">
            <li><a href="./index.php">Home</a></li>
            <li class="active"><a href="./dbsearch.php">Data Search</a></li>
            <li><a href="./scanID.php">Plate Entry</a></li>
          </ul>
          <h3 class="text-muted">toxin_screening</h3>
        </div>
<label>Planarian Database</label>
	<table class="zui-table zui-table-zebra zui-table-horizontal">
		<thead>
			<tr> 
				<th> plate id </th>
				<th> chemical </th>
				<th> run </th>
				<th> worm type</th>
				<th> day </th>
				<th> pharynx </th>
				<th> phototaxis </th>
				<th> thermotaxis</th>
				<th> IOL </th>
				<th> curvature </th>
				<th> eyes </th>
				<th> entry creation date </th>
				<th> last modified </th>
				<th> conc A </th>
				<th> conc B </th>
				<th> conc C </th>
				<th> conc D </th>
				<th> conc E </th>
				<th> conc F </th>
			</tr>
		</thead>

		<tbody>
			<form role="form" method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<tr align='center'>
					<td> <input type="search" name="plateID" style="width: 50px;"></td>
					<td> <input type="search" name="chemical"></td>
					<td> <input type="search" name="run" style="width: 35px;"></td>
					<td> <input type="search" name="worm_type" style="width: 60px;"></td>
					<td> <input type="search" name="day" style="width: 45px;"></td>
					<td> /48 </td>
					<td></td>
					<td></td>
					<td></td>
					<td align='left'>0: Normal <br> 1: C Shape <br> 2: C Shape W/ Pharynx Extrusion <br> 3: Contracted <br> 4: Corkscrew </td>
					<td> 0s 1s 2s 3s </td>									
					<td>yyyy-mm-dd</td>
					<td>yyyy-mm-dd hh:mm:ss</td>
					<td>%</td>
					<td>%</td>
					<td>%</td>
					<td>%</td>
					<td>%</td>
					<td>%</td>
				</tr>
				<input type="submit" value="Search" style="visibility: hidden;">
			</form>

			<?php
			$sql = "SELECT * FROM plate";

			if ($_SERVER["REQUEST_METHOD"] == "GET"){

				if(isset($_GET['plateID']) && !empty($_GET['plateID'])){
					$plateID = $_GET['plateID'];
					if (strpos($sql,'WHERE') !== false) {
						$sql .= " AND plateID='$plateID'";
					}
					else{
						$sql .= " WHERE plateID='$plateID'";
					}
				}

				if(isset($_GET['chemical']) && !empty($_GET['chemical'])){
					$chemical = $_GET['chemical'];
					if (strpos($sql,'WHERE') !== false) {
						$sql .= " AND chemical='$chemical'";
					}
					else{
						$sql .= " WHERE chemical LIKE '%$chemical%'";
					}
				}

				if(isset($_GET['run']) && !empty($_GET['run'])){
					$run = $_GET['run'];
					if (strpos($sql,'WHERE') !== false) {
						$sql .= " AND run='$run'";
					}
					else{
						$sql .= " WHERE run='$run'";
					}
				}

				if(isset($_GET['worm_type']) && !empty($_GET['worm_type'])){
					$worm_type = $_GET['worm_type'];
					if (strpos($sql,'WHERE') !== false) {
						$sql .= " AND worm_type='$worm_type'";
					}
					else{
						$sql .= " WHERE worm_type='$worm_type'";
					}
				}

				if(isset($_GET['day']) && !empty($_GET['day'])){
					$day = $_GET['day'];
					if (strpos($sql,'WHERE') !== false) {
						$sql .= " AND day='$day'";
					}
					else{
						$sql .= " WHERE day='$day'";
					}
				}

			}

			$sql .= " ORDER BY input_date DESC";

			$result = mysqli_query($con, $sql);

			if (mysqli_num_rows($result) > 0) {
    // output data of each row
				while($row = mysqli_fetch_assoc($result)) {
					$eyes = $row["eyes"];
					$curvature = $row["curvature"];

					$IOLfile = $row["IOL"];
					$IOLtrailing = basename($IOLfile);

					$phototaxisFile = $row["phototaxis"];
					$phototaxisTrailing = basename($phototaxisFile);

					$thermotaxisFile = $row["thermotaxis"];
					$thermotaxisTrailing = basename($thermotaxisFile);

					$image = $row["image"];
					$imageTrailing = basename($image);

					echo "<tr align='center'>" 

					. "<td>"
					. $row["plateID"]
					. "</td>"

					."<td>"
					. $row["chemical"]
					. "</td>"

					."<td>" 
					. $row["run"] 
					."</td>"

					."<td>" 
					. $row["worm_type"] 
					."</td>"  

					."<td>" 
					. $row["day"] 
					."</td>"

					."<td>" 
					. array_sum(str_split($row["pharynx"]))
					."</td>"

					."<td>" 
					."<a href='/RECORDS/$phototaxisFile'>$phototaxisTrailing</a>"
					."</td>"

					."<td>" 
					."<a href='/RECORDS/$thermotaxisFile'>$thermotaxisTrailing</a>"
					."</td>"    

					."<td>" 
					."<a href='./RECORDS/$IOLfile'>$IOLtrailing</a>"
					."</td>" 

					."<td>" 
					. substr_count("$curvature","0")
					. " "
					. substr_count("$curvature","1")
					. " "
					. substr_count("$curvature","2")
					. " "
					. substr_count("$curvature","3")
					."</td>"

					."<td>" 
					. substr_count("$eyes","0")
					. " "
					. substr_count("$eyes","1")
					. " "
					. substr_count("$eyes","2")
					. " "
					. substr_count("$eyes","3")
					."</td>"

					."<td>" 
					.$row["date"] 
					."</td>"

					."<td>" 
					.$row["input_date"] 
					."</td>"

					."<td>" 
					.$row["concA"] 
					."</td>"

					."<td>" 
					.$row["concB"] 
					."</td>"

					."<td>" 
					.$row["concC"] 
					."</td>"

					."<td>" 
					.$row["concD"] 
					."</td>"

					."<td>" 
					.$row["concE"] 
					."</td>"

					."<td>" 
					.$row["concF"] 
					."</td>"

					."</tr>";
				}
			} else {

				echo "<td> No results found </td>";
			};
			?>
		</tbody>

	</table>
</body>
</html>