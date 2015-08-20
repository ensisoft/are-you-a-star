<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Yes You Are!</title>
        <link rel="stylesheet" title="style" type="text/css" href="star.css">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <head>
    <body>
        <div class="header">
            <p>YES, YOU ARE A STAR!<br>
            CONGRATULATIONS :)<br><br><br>
            </p>

            <br>

            <?php
                include("database.php");

                function sql_string($str)
                {
                    if (isset($str))
                        return "'" . mysql_real_escape_string(strip_tags($str)) . "'";
                    return "NULL";
                }
                function get_visitor_host()
                {
                  $ip = getenv("HTTP_CLIENT_IP");
                  if (strlen($ip) == 0)
                  {
                      $ip = getenv("HTTP_X_FORWARDED_FOR");
                      if (strlen($ip) == 0)
                          $ip = getenv("REMOTE_ADDR");
                  }
                  if (strlen($ip))
                      return gethostbyaddr($ip);
                  return "unknown";                    
                }

                $repository = sql_string($_REQUEST['repository']);
                $visitor    = sql_string(get_visitor_host());

                $insert = "INSERT INTO stars (visitor, repository) VALUES ($visitor, $repository)";
                mysql_query($insert, $db) or 
                    die("ooops the database has died.");

                $select  = "SELECT repository FROM stars ORDER BY RAND() LIMIT 1";
                $records = mysql_query($select, $db) or
                    die("oops the database has died...");

                $row = mysql_fetch_array($records);
                $url = $row['repository'];

                echo("Now.. why don't you take a few minutes and visit <br><br>" .
                  "<a href=\"$url\">$url</a>");


                @mysql_close($db);

            ?>        
        </div>

        <div style="width:100%">
            <a href="https://github.com/ensisoft/ur-a-star">
                <img style="float:right;" src="forkme_right_green_007200.png" alt="Fork me on GitHub">
            </a>
        </div>
    </body>
</html>