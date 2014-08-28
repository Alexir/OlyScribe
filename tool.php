<html>
<head> <title>Quick transcription tool for Olympus</title> </head>
<body>
<h3>Olympus Transcription Tools</h3>
<form name="start transcription" action="trans_session.php" method="get">

<table>
<th colspan=2>Enter session coordinates:</th>
<!-- <tr><td>Domain:</td><td> <input type=text name="root" value="SocialRobot" /></td></tr> -->

<!-- <tr><td>Task:</td><td> <input type="text" name="task" value="" /></td></tr> -->
<?php
// find all the juncture folders
$juncts = array();

$ha=popen('dir /al /b ..','r');
while ( $inl=fscanf($ha,"%s") ) {
    list($in) = $inl; // goofy
    array_push($juncts,$in);
}
pclose($ha);

echo "<tr><td>Task:</td><td>\n";
echo "<select name=task>\n";
echo "<option value=''>Select One...</option>";
foreach ($juncts as $task) {
    echo "<option value=".$task.">".$task."</option>";
}
echo "</select>";
echo "</td></tr>\n";


// following ought also to be dynamically populated <select>s

?>

<tr><td>Date:</td><td> <input type="text" name="date" value="" /> <tt>yyyymmdd</tt></td></tr>
<tr><td>Session:</td><td> <input type="text" name="sess" value="" /> <tt>nnn</tt></td></tr>

<tr><td><input type="submit" value="GO" /></td><td> </td></tr>
</form>
</body>
</html>
