<?php
    include_once("database.php");

    $err='';
    $msg='';

    function sql_string($str)
    {
        if (isset($str))
            return "'" . mysql_real_escape_string(strip_tags($str)) . "'";
        return $str;
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

    function check_repository($repository)
    {
        $ret = preg_match('#^https?://github\.com/[[:alnum:]-]+/[[:alnum:]-]+\.git#', $repository);
        if ($ret == 0)
            return 0;
        $headers = @get_headers($repository);

        foreach ($headers as $header) {
            if (strcasecmp($header, "HTTP/1.1 404 Not Found") == 0)
                return 0;
        }
        return 1;
    }

    function oops($msg)
    {
        global $err;
        $err = $err . $msg;
    }

    $repository = $_REQUEST['repository'];

    if (isset($repository))
    {
        if (check_repository($repository) == 0) {
            oops("$repository is not a valid GitHub repository... :(");
        }
        else
        {
            $repository = sql_string($repository);
            $visitor    = sql_string(get_visitor_host());

            $insert = "INSERT INTO stars (visitor, repository) VALUES ($visitor, $repository)";
            @mysql_query($insert, $db);

            // http://dev.mysql.com/doc/refman/5.5/en/error-messages-server.html
            // 1062 for duplicate entry.
            $e = mysql_errno();

            if ($e &&  $e != 1062) {
                oops("ooops the database has died.");
            } else {
                $msg = $msg . "<p>YES, YOU ARE A STAR!<br>" .
                "CONGRATULATIONS :)<br><br><br></p>";
               
                $msg = $msg . "<img src=\"star.png\">";
            }
        }
    }

    $select  = "SELECT repository FROM stars ORDER BY RAND() LIMIT 1";
    $records = mysql_query($select, $db);
    if (mysql_errno()) {
        oops("oops the database has died...");
    } else {
        $row = mysql_fetch_array($records);
        $url = $row['repository'];

        $msg = $msg . "<br><br>Now.. why don't you take a few minutes and visit <br><br>" .
            "<a href=\"$url\">$url</a>";
    }
    @mysql_close($db);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Yes You Are!</title>
        <link rel="stylesheet" title="style" type="text/css" href="star.css">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <head>
    <body>
        <div class="content">
            <?php
              if ($err) { echo $err; }
              else if ($msg) { echo $msg; }
            ?>
        </div>

        <div style="width:100%">
            <a href="https://github.com/ensisoft/are-you-a-star">
                <img style="float:right;" src="forkme_right_green_007200.png" alt="Fork me on GitHub">
            </a>
        </div>
    </body>
</html>