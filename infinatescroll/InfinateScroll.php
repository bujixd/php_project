<!DOCTYPE html>
<html>
<head>
    <title></title>
    <script type="text/javascript" src="include/jquery.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var scroll =$(window).scrollTop();
            var height =$(window).height();
            var width=$(this).width();
            $(".sc").html(
                    "scroll: " + scroll + "<br/>"
            );

            $("#he").html(
                    "height: " + height + "<br/>"
            );

            $("#wh").html(
                    "width: " + width + "<br/>"
            );

            $(window).resize(function(){
                var scroll =$(window).scrollTop();
                var height =$(window).height();
                var width=$(this).width();
                $(".sc").html(
                        "scroll: " + scroll + "<br/>"
                );

                $("#he").html(
                        "height: " + height + "<br/>"
                );

                $("#wh").html(
                        "width: " + width + "<br/>"
                );
            });
            $(window).scroll(function() {
                var scroll =$(window).scrollTop();
                var height =$(document).height();
                var width=$(this).width();
                $(".sc").html(
                        "scroll: " + scroll + "<br/>"
                );

                $("#he").html(
                        "height: " + height + "<br/>"
                );

                $("#wh").html(
                        "width: " + width + "<br/>"
                );
                if($(window).scrollTop() == $(document).height() - $(window).height()) {
                    $('div#loadMoreComments').show();
                    $.ajax({
                        dataType:"html",
                        url: "jquery.loadMoreComments.php?lastComment="+ $(".postedComment:last").attr('id') ,
                        success: function(html) {
                            if(html){
                                $("#postedComments").append(html);
                                $('div#loadMoreComments').hide();
                            }else{
                                $('div#loadMoreComments').replaceWith("<center><h1 style='color:red'>End of countries !!!!!!!</h1></center>");
                            }
                        }
                    });
                }
            });
        });
    </script>
    <style type="text/css">
            .monitor{
                position:fixed;
                right:10%;
                width: 150px;
                height: 150px;
                color:white;
                background-color: green;
                overflow: auto;
            }
            h1{
				color:blue;
            	text-align:center;
            }
    </style>
   </head>
<body>
<div class="monitor" >
            <span class="sc"> </span>
            <span id="he"></span>
            <span id="wh"></span>

        </div>
<?php
mysql_connect("localhost", "root" , "");
mysql_select_db("sales");
?>
<div id="postedComments">
    <h1 > Infinate Scroll with database </h1>
    <?php
    $sql= mysql_query("SELECT * FROM sales ORDER BY id ASC LIMIT 0,30");
    $lastId ;
    while($data = mysql_fetch_object($sql)){
        $cust = $data->cust;
        $prod = $data->prod ;
        $year = $data->year;
        $state = $data->state ;
        $id = $data->id;
        echo "
<div class='postedComment' id=\"$data->id \">
<center>
<b>Custmor : </b>$cust <br />
<b>Production : </b>$prod<br/>
<b>Year : </b>$year<br/>
<i style=\"font-size:small;color:blue\">Index : $id</i>
<hr />
</center>
</div>
" ;
    }
    ?>
</div>
<div id="loadMoreComments" style="display:none;" > <center>Dimitrios</center></div>
</body>
</html>
