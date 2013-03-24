<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
				if (! empty ( $_GET ["path"] )) {
					if (! isset ( $_GET ["path"] )) {
						echo "can not get file path";
					} else {
						$path = $_GET ["path"];
						if (strpos ( $path, ".html" ) !== false || strpos ( $path, ".htm" ) !== false) {
							echo "<br>";
							getIndex ( $path );
						} else if (is_dir ( $path )) {
							echo "<br>";
							$file = getFile ( $path, $path );
						} else {
							echo "please enter right path";
						}
					}
				} else {
					echo "enter path to search";
				}
				if (empty ( $_GET ["word"] )) {
					
				} else {
					$db = new database ();
					$db->setup ( "root", "", "localhost", "indexer" );
					$query = "SELECT * FROM files";
					$db->send_sql ( $query );
					
					$word = $_GET ["word"];
					$search = $_GET ["search"];
					echo "<br>";
					if ($search == 0) {
						searchText ( $word );
					} else if ($search == 1) {
						searchMeta ( $word );
					} else {
						searchFile ( $word );
						searchMeta ( $word );
						searchText ( $word );
					}
				}
				function superExplode($str, $sep) {
					$i = 0;
					$arr [$i ++] = strtok ( $str, $sep );
					while ( $token = strtok ( $sep ) )
						$arr [$i ++] = $token;
					return $arr;
				}
				function getIndex($path) {
					$url1 = $path . "/" . $file;
					$sql = "INSERT INTO  files (id_file ,name ,url) VALUES (NULL ,'$path',  '$url1');";
					$db = new database ();
					$db->setup ( "root", "", "localhost", "indexer" );
					$db->send_sql ( $sql );
					$id = $db->insert_id ();
					if ($fp = fopen ( $path, "r" )) {
						$meta_info = get_meta_tags ( $path );
						echo "<table border='1'>";
						echo "<tr><td>meta_type:</td><td>meta_word:</td></tr>";
						foreach ( $meta_info as $meta_key => $meta_name ) {
							$sql = "INSERT INTO meta_info (id_file,type,content)VALUES ('$id',  '$meta_key',  '$meta_name')";
							$db->send_sql ( $sql );
							echo "<tr><td>$meta_key</td><td>$meta_word</td><tr>";
						}
						echo "</table>";
						$fcontent = file_get_contents ( $path );
						$ftags = strip_tags ( $fcontent );
						$flower = strtolower ( $ftags );
						$freplace = preg_replace ( '(\W)', ' ', $flower );
						$farr = superExplode ( $freplace, " " );
						echo "<font size=5>let's count</font><br>";
						$i = 0;
						foreach ( $farr as $f_arr ) {
							if (strlen ( $f_arr ) != 1) {
								$f_newarr [$i ++] = $f_arr;
							}
						}
						$fcount = array_count_values ( $f_newarr );
						ksort ( $fcount );
						echo "<table border='1'>";
						echo "<tr><td>words:</td><td>count:</td></tr>";
						foreach ( $fcount as $fsort_key => $fsort_word ) {
							$wsql = "INSERT INTO word (id_word,word)VALUES
							(null, '$fsort_key')";
							$db->send_sql ( $wsql );
							$wid = $db->insert_id ();
							$nsql = "INSERT INTO file_word
							 (id_file,id_word,count)VALUES ('$id', '$wid',
							 '$fsort_word')";
							$db->send_sql ( $nsql );
							echo "<tr><td>$fsort_key</td><td>$fsort_word</td><tr>";
						}
						echo "</table>";
					}
					;
					echo "<br>";
				}
				function getFile($path, $curpath = ".") {
					$handle = opendir ( $path );
					chdir ( $path );
					if ($handle) {
						$file = readdir ( $handle );
						while ( $file ) {
							if (strpos ( $file, ".htm" ) > 0 || strpos ( $file, ".html" ) > 0) {
								echo "<font color=red>" . $file . "</font><br>";
								$url1 = $path . "/" . $file;
								$sql = "INSERT INTO  files (id_file ,name ,url) VALUES (NULL ,'$file',  '$url1');";
								$db = new database ();
								$db->setup ( "root", "", "localhost", "indexer" );
								$db->send_sql ( $sql );
								$id = $db->insert_id ();
								$url = realpath ( $file );
								if ($fp = fopen ( $url, "r" )) {
									$meta_info = get_meta_tags ( $url );
									echo "<table border='1'>";
									echo "<tr><td>meta_type:</td><td>meta_word:</td></tr>";
									foreach ( $meta_info as $meta_key => $meta_name ) {
										$sql = "INSERT INTO meta_info (id_file,type,content)VALUES ('$id',  '$meta_key',  '$meta_name')";
										$db->send_sql ( $sql );
										echo "<tr><td>$meta_key</td><td>$meta_name</td><tr>";
									}
									
									echo "</table>";
									$fcontent = file_get_contents ( $url );
									$ftags = strip_tags ( $fcontent );
									$flower = strtolower ( $ftags );
									$freplace = preg_replace ( '(\W)', ' ', $flower );
									$farr = superExplode ( $freplace, " " );
									echo "<font size=5>let's count</font><br>";
									$i = 0;
									foreach ( $farr as $f_arr ) {
										if (strlen ( $f_arr ) != 1) {
											$f_newarr [$i ++] = $f_arr;
										}
									}
									$fcount = array_count_values ( $f_newarr );
									ksort ( $fcount );
									echo "<table border='1'>";
									echo "<tr><td>words:</td><td>count:</td></tr>";
									foreach ( $fcount as $fsort_key => $fsort_word ) {
										$wsql = "INSERT INTO word (id_word,word)VALUES (null,  '$fsort_key')";
										$db->send_sql ( $wsql );
										$wid = $db->insert_id ();
										$nsql = "INSERT INTO file_word (id_file,id_word,count)VALUES ('$id',  '$wid',  '$fsort_word')";
										$db->send_sql ( $nsql );
										echo "<tr><td>$fsort_key</td><td>$fsort_word</td><tr>";
									}
									echo "</table>";
								}
								;
								echo "<br>";
							} else if ($file != "." && $file != ".." && is_dir ( $file )) {
								getfile ( $path . "/" . $file, $curpath . "/" . $file );
								$temp_path = getcwd (); // important!!!
								$temp_path = str_replace ( "\\", "/", $temp_path );
								$temp_pos = strrpos ( $temp_path, "/", - 2 );
								$temp_path = substr ( $temp_path, 0, $temp_pos + 1 );
								chdir ( $temp_path );
							}
							$file = readdir ( $handle );
						}
					}
					closedir ( $handle );
				}
				function searchMeta($word) { 
					$query = "SELECT * FROM meta_info where type LIKE'%$word%' or content LIKE '%$word%'";
					$res = mysql_query ( $query );
					if (mysql_num_rows ( $res )) {
						echo "Meta_info Table:";
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
								if ($i == 0) {
									echo "<td><a href=showtable.php?url=$elem>$elem</td>";
									$i ++;
								} else {
									$nword = str_replace ( "$word", "<font color=red>$word</font>", "$elem" );
									echo "<td>$nword</td>";
								}
							}
							echo "</tr>";
						}
						echo "</table>";
					} else {
						echo "<font size=5>no such meta information in database!</font><br>";
					}
				}
				function searchText($word) { // find and print text info with
				                             // highlight search key word
					$query = "SELECT id_word FROM word where word LIKE '%$word%' ";
					$res = mysql_query ( $query );
					if (mysql_num_rows ( $res )) {
						echo "Words Table:";
						echo "<table border='1'>";
						echo "<tr>";
						echo "<th>id_file</th> <th>word</th> <th>count</th>";
						echo "</tr>";
						
						while ( $row = mysql_fetch_row ( $res ) ) {
							$i = 0;
							foreach ( $row as $elem ) {
								if ($i == 0) {
									$wid = $elem;
									$i ++;
								}
							}
							printword ( $wid, $word );
						}
						echo "</table>";
					} else {
						echo "<font size=5>no words contain that information in database!</font><br>";
					}
				}
				function searchFile($word) { // find and print meta info with
				                             // highlight search key word
					$query = "SELECT * FROM files where url LIKE'%$word%'";
					$res = mysql_query ( $query );
					if (mysql_num_rows ( $res )) {
						echo "Files Table:";
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
								if ($i == 0) {
									echo "<td><a href=showtable.php?url=$elem[$i]>$elem[$i]</td>";
									$i ++;
								} else {
									$e = str_replace ( "$word", "<font color=red>$word</font>", "$elem[$i]" );
									echo "<td>$e</td>";
								}
							}
							echo "</tr>";
						}
						echo "</table>";
					} else {
						echo "<font size=5>no files contain that information in database!</font><br>";
					}
				}
				function printword($wid, $word) { // this function is used to
				                                  // combine
				                                  // file_word and words table
					$query = "SELECT * FROM file_word where id_word='$wid'";
					$res = mysql_query ( $query );
					$num = mysql_num_fields ( $res );
					
					while ( $row = mysql_fetch_row ( $res ) ) {
						echo "<tr>";
						$i = 0;
						foreach ( $row as $elem ) {
							if ($i == 0) {
								echo "<td><a href=showtable.php?url=$elem>$elem</td>";
								$i ++;
							} else if ($i == 1) {
								$query = "select word from word where id_word='$elem'";
								$re = mysql_query ( $query );
								$ro = mysql_fetch_row ( $re );
								foreach ( $ro as $elemem ) {
									$e = str_replace ( "$word", "<font color=red>$word</font>", "$elemem" );
									echo "<td>$e</td>";
								}
								$i ++;
							} else {
								echo "<td>$elem</td>";
							}
						}
						echo "</tr>";
					}
				}
				
				?>
	</body>
</html>