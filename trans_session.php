<!-- 
---------------------------------------------------------
Display the transcriptions in an Olympus session log.
Use for entering or correcting transcriptions
Manages .trans files corresponding to .wav speech files
[201205] (air) Started.
---------------------------------------------------------

-->

<?php
error_reporting(E_ALL & E_NOTICE);
ini_set('error_log','phperror.log');

// list what's available for different days

// for each day
//    for each session
//       count *.wav
//       note whether there's transcriptions
// allow click-through to transcription tool

// pick a target 
$task=$_GET["task"];
$day=$_GET["date"];
$session=$_GET["sess"];

// check that this stuff exists
if ( file_exists("../".$task) ) { $taskx = 1; } else { $taskx = 0; }
if ( file_exists("../".$task."/".$day) )  { $dayx = 1; } else { $dayx = 0; }
if ( file_exists("../".$task."/".$day."/".$session) ) { $sessionx = 1; } else { $sessionx = 0; }

$wpath = "../".$task."/".$day."/".$session."/";
$wavs = glob($wpath."???.wav");      // get list of .wav files, etc
$trs = glob($wpath."???.trans");     // and any existing transcripts
foreach ($trs as $trans) {
    if (file_exists($trans)) {
        $in = rtrim(file_get_contents($trans));
        $ine = explode(" ",$in);
        array_pop($ine);
        $ref[basename($trans,".trans")] = implode(" ",$ine);
    } else {
        $ref[basename($trans,".trans")] = "<em>n/a</em>";
    }
}
?>

<html>
<head>

<style>
.turn {
    vertical-align: top;
    width: 20px;
    background: #efefef;  
}

.edit {
    vertical-align: top;
    width: 10px;
    background: #bbb;  
}

.play {
    vertical-align: top;
    width: 100px;
 }

.transcr {
    background: #eee;  
 }

.textinput {
  width: 150px;
}
</style>

<script type="text/javascript">

// from: http://www.whatstyle.net/articles/11/vfields
var vfields = {
maxchars : 16,
maxWidth : 500,
initWidth : 250,
charWidth : 5,
vfield_class : 'vfield',
init : function ()
{
var W3CDOM = (document.getElementsByTagName);
if (!W3CDOM) return;
var inputs = document.getElementsByTagName('input');
for (var i=0; i<inputs.length; i++)
{
if (inputs[i].type == 'text' && inputs[i].className.indexOf(vfields.vfield_class) != -1)
{
inputs[i].onkeyup = vfields.checkLength;
}
}
},
checkLength : function ()
{
if (this.value.length >= vfields.maxchars)
{
var surplus= this.value.length-vfields.maxchars;
if ((vfields.initWidth + (surplus * vfields.charWidth)) < vfields.maxWidth)
{
this.style.width = (vfields.initWidth + (surplus * vfields.charWidth))+'px';
}
}
}
}
window.onload = function ()
{
vfields.init();
}


function showSessions(str,id,fil) 
{
if (str=="") { document.getElementById(id).innerHTML="x"; return;   } 
if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}

xmlhttp.onreadystatechange=function() {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)  {
    document.getElementById(id).innerHTML=xmlhttp.responseText;
    }
}

xmlhttp.open("GET","set_trans.php?q="+str+"&f="+fil,true);
xmlhttp.send();
}

function reEdit(from,to)
{
var arr=document.getElementById(from).innerHTML.split(" ");
document.getElementById(to).value = arr.join(" ");
}

</script>
</head>

<body>
<h2>Transcription Tool v0.1</h2><hr>
<h4>
<?php echo "$task"; if ( ! $taskx ) { echo "<span style=\"color:red\">BAD VALUE!</span>"; } ?>
<?php echo "<br/>$day "; if ( ! $dayx ) { echo "<span style=\"color:red\">BAD VALUE!</span>"; } ?>
<?php echo "<br/>$session\n"; if ( ! $sessionx ) { echo "<span style=\"color:red\">BAD VALUE!</span>"; } ?>
</h4>

<p>Type your transcription in the last field; end with a <tt>&lt;tab&gt;</tt> or
<tt>&lt;enter&gt;</tt> to register</p>
<p> Note: if the 'listen' item in a row is missing this means that
the <tt>.wav</tt> file header has the wrong length. <br/>Click on the 'turn' link to
hear the utterance.</p><br/>

<table cellpadding="2" cellspacing="0" border="1">
<tr><th class="turn">turn</th><th>.TRANS</th><th class="edit">edit</th><th class="play">listen</th><th>transcription</th></tr>

<?php
   // construct a row of the display
   foreach ($wavs as $waf) {
   $dumi = str_replace(".wav","",$waf);
   $dum = explode(" ", str_replace("/"," ",$dumi));

   echo "<tr>\n";
   // date/ session /utt identifier
   echo "<td class=\"turn\"><a href=\"$waf\" target=\"playme\"><b>$dum[4]</b></a></td>\n";

   if ( isset($ref[$dum[4]]) ) {
   $rtag = chop(htmlentities($ref[$dum[4]]));
   
   } else { $rtag= "<em>n/a</em>"; }
   echo "<td> <div id=\"ref".$dum[4]."\">".$rtag."</div> ";
   echo "</td>\n";   // reference, as in .trans file

   echo "<td class=\"edit\"> ";
   $frome = "ref".$dum[4]; $toe = "tra".$dum[4];
   echo "<input type=\"button\" value=$dum[4] onclick=\"reEdit('$frome','$toe')\" />";
   echo "</td>\n";

   // playback gadget (note, broken if file len is incorrect)
//   echo "<td class=\"play\"><embed autostart=false controls=smallconsole width=100 height=25 src=\"".$waf."\"</td>\n";
   echo "<td class=\"play\"><audio width=\"100\" controls=\"controls\" <source src=\"".$waf."\" />Browser does not support audio.</audio></td>\n";

   echo "<td class=\"transcr\"> \n";    // field for trans entry
   echo "<input class=\"vfield textinput\" type=\"text\" id=\"tra".$dum[4].
       "\" onchange=\"showSessions(this.value,'ref".$dum[4]."','".urlencode($dumi)."')\" /> \n";
   echo "</td>\n";

   echo "</tr>\n\n";
   }
   ?>
</table>
<br/>

<form name="start transcription" action="index.php" method="get">

<input type="hidden" name="root" value="nil" />
<input type="hidden" name="task" value="<?php echo $task ?>" />
<input type="hidden" name="date" value="<?php echo $day ?>" />
<input type="hidden" name="sess" value="<?php echo $session ?>" />

<input type="submit" value="Return" /> to session selector
</form>
<a href="index.php">Return</a> to an empty session selector

</body>
</html>

