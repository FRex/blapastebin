<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bla Paste Bin</title>
</head>

<body>
<?php
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['pasteid']))
{
    $pasteid = $_GET['pasteid'];
    $text = "";
    if(ctype_alnum($pasteid))
    {
        $fname = "files/$pasteid.txt";
        if(file_exists($fname))
        {
            $text = file_get_contents($fname);
            if($text === FALSE)
                $text = "";
        }
    }
?>
<pre>
<?=htmlentities($text)?>
</pre>
<?php
}
elseif($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content']))
{
    $content = $_POST['content'];
    while(TRUE)
    {
        $pasteid = sha1(rand() . substr($content, 0, rand(10, 1000)));
        $fname = "files/$pasteid.txt";
        if(!file_exists($fname))
            break;
    }

    file_put_contents($fname, $content);
    echo "<a href=\"/index.php?pasteid=$pasteid\">$pasteid</a>";
}
else
{
?>
<form action="/index.php" method="POST">
<input type="submit" value="Submit"><br/>
<textarea name="content"></textarea>
</form>
<?php
}
?>
</body>

</html>
