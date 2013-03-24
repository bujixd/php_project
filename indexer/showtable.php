<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Indexer</title>
<title>Indexer</title>
<h1 align=center>Indexer</h1>
		<label >zhichen dai</label>
		<br>
		<label >10369433</label>
		<br>
</head>


<body>
	<p>please input the path or .html/.htm file</p>
	<form action="indexer.php" method="get" target="_self">
		<input name="path" type="text" /> <input name="submit" type="submit" />
	</form>
	<form name="word" action="indexer.php" method="GET" target="_self">
		<label>Input word you want to search :</label> <input
			style="width: 200px; height: 25px;" type="text" name="word" /> <br> <input
			type=radio name=search value=0> Word
		<p>
			<input type=radio name=search value=1> Meta
		
		
		

		<p>
			<input type=radio name=search value=2> Both
		
		
		
		
		
		<p>
			<input type=submit value=submit><input type=reset value=reset>
	
	
	
	</form>

<?php

include ("./database.php");
$url = $_GET ['url'];
$db = new database ();
$db->setup ( "root", "", "localhost", "indexer" );

$query = "SELECT * FROM files where url='$url' or id_file='$url'";
$db->send_sql ( $query );
$res = mysql_query ( $query );
$id = find_id ( $res );
echo "File information";
printfile ( $id );

printmeta ( $id );
echo "<br><br>word count information";
printword ( $id );

$db->disconnect ();
function find_id($res) {
	$row = mysql_fetch_row ( $res );
	$i = 0;
	if (is_Array ( $row )) {
		foreach ( $row as $elem ) {
			if ($i == 0) {
				return $elem;
				$i ++;
			}
		}
	}
}
function printfile($id) { // print info in file table
	$query = "SELECT * FROM files where id_file='$id'";
	$res = mysql_query ( $query );
	mysql_data_seek ( $res, 0 );
	
	$num = mysql_num_fields ( $res );
	echo "<table border='1' >";
	echo "<tr>";
	for($i = 0; $i < $num; $i ++) {
		echo "<th>";
		echo mysql_field_name ( $res, $i );
		echo "</th>";
	}
	echo "</tr>";
	while ( $row = mysql_fetch_row ( $res ) ) {
		echo "<tr>";
		$i = 0;
		foreach ( $row as $elem ) {
			echo "<td>$elem</td>";
		}
		echo "</tr>";
	}
	echo "</table>";
}
function printmeta($id) { // print info in meta_info table
	$query = "SELECT * FROM meta_info where id_file='$id'";
	$res = mysql_query ( $query );
	if (mysql_num_rows ( $res ) == 0) {
		echo "<br><br><br><br>this file does not have meta information!";
	} else {
		echo "<br><br>Meta information";
		$num = mysql_num_fields ( $res );
		echo "<table border='1' >";
		echo "<tr>";
		for($i = 0; $i < $num; $i ++) {
			echo "<th>";
			echo mysql_field_name ( $res, $i );
			echo "</th>";
		}
		echo "</tr>";
		while ( $row = mysql_fetch_row ( $res ) ) {
			echo "<tr>";
			$i = 0;
			foreach ( $row as $elem ) {
				echo "<td>$elem</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
	}
}
function printword($id) { // print info in word table
	$query = "SELECT * FROM file_word where id_file='$id'";
	$res = mysql_query ( $query );
	mysql_data_seek ( $res, 0 );
	
	$num = mysql_num_fields ( $res );
	echo "<table border='1'>";
	echo "<tr>";
	for($i = 0; $i < $num; $i ++) {
		echo "<th>";
		echo mysql_field_name ( $res, $i );
		echo "</th>";
	}
	echo "</tr>";
	while ( $row = mysql_fetch_row ( $res ) ) {
		echo "<tr>";
		$i = 0;
		foreach ( $row as $elem ) {
			if ($i == 0) {
				echo "<td>$elem</td>";
				$i ++;
			} else if ($i == 1) {
				$query = "select word from word where id_word='$elem'";
				$re = mysql_query ( $query );
				$ro = mysql_fetch_row ( $re );
				foreach ( $ro as $elemem ) {
					echo "<td>$elemem</td>";
				}
				$i = 0;
			}
		}
		
		echo "</tr>";
	}
	echo "</table>";
}
	


	?>

		
		</body>
</html>