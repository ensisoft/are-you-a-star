
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Are You a Star?</title>
        <link rel="stylesheet" title="style" type="text/css" href="star.css">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <head>
    <body>
        <div class="header">
            <p>FEELING A LITTLE UNAPPRECIATED?<br>
            ALL THAT HARD WORK AND NO RECOGNITION?<br><br>

            LETS SEE IF YOU'RE A STAR...<br><br>

            GIVE US YOUR GITHUB REPOSITORY AND WE'LL KNOW.</p>

            <br>

            <?php
                echo("<form action=\"yes.php\" method=\"post\">" .
                    "<input style=\"width:75%;\" type=\"text\" name=\"repository\" value=\"http://github.com/your/repository\">" .
                    "<input type=\"submit\" value=\"Send\">" .
                    "</form>");
            ?>        
        </div>

        <div style="width:100%">
            <a href="https://github.com/ensisoft/ur-a-star">
                <img style="float:right;" src="forkme_right_green_007200.png" alt="Fork me on GitHub">
            </a>
        </div>
    </body>
</html>