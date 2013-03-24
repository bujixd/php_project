<?php
mysql_connect("localhost", "root" , "");
mysql_select_db("sales");
if($_GET['lastComment']){
    $sqlQuery = mysql_query('SELECT * FROM sales WHERE id > "'.mysql_real_escape_string($_GET['lastComment']).'" ORDER BY id ASC LIMIT 0 , 30');
    $val = $_GET['lastComment'];
    while($data = mysql_fetch_object($sqlQuery)) {
        $cust = $data->cust;
        $prod = $data->prod ;
        $year = $data->year;
        $state = $data->state;
        $id = $data->id;
        echo "
<div class='postedComment' id=\"$data->id \">
<center>
<b>custmer : </b>"."$cust <br />
<b>production : </b>" ."$prod<br/>
<b>year  : </b>"." $year<br>
<i style=\"color:blue\">Index nr."."$id</i>
<hr />
</center>
</div> 
" ;

    }

}

