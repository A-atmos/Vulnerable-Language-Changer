<!doctype html>
<html>
    <head>
    </head>
    <body>
    <?php
        $Language = parse_ini_file('lang//english.ini');

        if ( isset( $_GET['lang'] ) ) {

            include( $_GET['lang']);
            // end
            
        }

    ?>

    <div align="right">
        <form method="get">
		   <select name="lang">
			  <option value="lang/english.php">English</option>
			  <option value="lang/hindi.php">हिन्दी</option>
			  <option value="lang/nepali.php">नेपाली</option>
		   </select>
		   <input type="submit" value="Change">
        </form>
    </div>

    <div align="center">
        <h1><?=$Language["sitename"] ?></h1>

        <h4><?=$Language["slogan"]?></h4>
        <img src="static/imgs/<?=$Language['img']?>" alt="">
        <p><?=$Language["text"]?></p>
        <h2><?=$Language["header"] ?></h2>
    </div>

    <!-- Created with <3 by 0x00ac -->
    </body>
</html>
