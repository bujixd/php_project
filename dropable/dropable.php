<!DOCTYPE html>
<html>
<head>
    <title></title>
    <script type="text/javascript" src="include/jquery.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
    <style type="text/css">
        #puzzle,#word{
            width: 700px;
            height: 300px;
            margin: 10px 10px;
            padding: 10px 10px;
            border: solid 1px;
            float: right;
        }

        #pictures,#words{
            width: 500px;
            height: 300px;
        }
        .image{
            width:80px;
            height:80px;
            border: solid 1px;
        }

        .char{
            display: block;
            width: 50px;
            height: 50px;
            float: left;
            border: solid 1px;
            background: #a52a2a;
        }

        
    </style>
    <script>
        $(function(){
            $(".image").draggable(
                    {snap:true,
                    revert:"invalid"}
            );

            $(".char").draggable(
                    {
                        snap:true,
                        revert:"invalid"
                    }
            );

            $( "#puzzle" ).droppable({
                accept: ".image",
                activeClass: "ui-state-hover",
                hoverClass: "ui-state-active"

            });

            $("#word").droppable({
                accept: ".char",
                activeClass: "ui-state-hover",
                hoverClass: "ui-state-active"
            });
        });
    </script>
</head>
<body>
    <div id="puzzle" >
        <p>drop image</p>
    </div>
    <div id="word" >'
        <p>drop word</p>
    </div>
    <div id="pictures">
        <?php
            for($i=0;$i<16;$i++){
                echo"<img class='image' src='/assignment7/picture/72-00-0".$i.".jpg'/>";
            }
        ?>

    </div>
    <div id="words">
        <span class="char"> A </span>
        <span class="char"> B </span>
        <span class="char"> C </span>
        <span class="char"> D </span>
        <span class="char"> E </span>
        <span class="char"> F </span>
    </div>

</body>
</html>