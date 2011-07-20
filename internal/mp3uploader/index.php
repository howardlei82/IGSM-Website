<?php
/*
 * IGSM mp3 Message Upload Script
 * 
 */

$PHP_SELF = htmlentities($_SERVER['PHP_SELF']);

// get to PDT timezone
date_default_timezone_set("America/Los_Angeles");

/* --------------- CONSTANTS ----------------- */

$file_root = "/home/igsm/igsmonline.org/files/msgs";
$url_root = "/files/msgs";
$http_url = "http://www.igsmonline.org";

// options are "formPage" and "loginPage": default is the loginPage
$pageMode = "loginPage";

$statusMessage = "";
$orig_log_path = $file_root . "/orig.log";
$final_log_path = $file_root . "/final.log";
$login_log_path = $file_root . "/login.log";

$pwFixed = "ps119!";
$pwRotate = date("j"); // day of the month 1-31
$loginMessage = "";

$numOriginalToShow = 10;
$numFinalToShow = 10;
$oneMB = 1048576;

/* --------------- FORM PROCESSING ----------------- */

if ($_POST['command']=='processLogin') {
	
	// process authentication and start new php session
	$user = $_POST['username'];
	$pass = $_POST['password'];

	// this is to make sure that logins do not occur using the same password twice
	// in the event that the password gets sniffed in transit
	$numLoginsToday = 0;
	$date = date("Y.m.d");
	$ph = popen("/bin/grep '${user}:${date}:' {$login_log_path}","r");
	while($pline = fgets($ph)) {
		$numLoginsToday += 1;
		$pwItems = explode(":", trim($pline));
		if ($pass == $pwItems[2]) {
			// this is a used password!  force pw to be invalid
			$pass = "Invalid";
		}
	}
	pclose($ph);

	$pwRotate2 = substr($user, 0, 1); // first letter
	$pwModel = $pwFixed . $pwRotate . $pwRotate2 . $numLoginsToday;
	$computePw = md5($pwModel);
	
	if ($computePw == $pass && strlen($user) > 4) {
		// authentication successful: start a NEW session
		if (isset($_SESSION['AuthKey'])) {
			session_destroy();
		}
		session_start();
		$pageMode = 'formPage';
		$_SESSION['Username'] = $user;
		$_SESSION['AuthKey'] = $computePw;
		$_SESSION['IP_ADDR'] = $_SERVER['REMOTE_ADDR'];
		$_SESSION['logNum'] = $numLoginsToday;
		
		// write out pw to file
		$fh = fopen($login_log_path,"a");
		$pwLine = "{$user}:${date}:${pass}\n";
		fwrite($fh, $pwLine);
		fclose($fh);
	} else {
		if (isset($_SESSION['AuthKey'])) {
			session_destroy();
		}
		$pageMode = 'loginPage';
		$loginMessage = "<span class='msg'>Username or password was incorrect.</span>";		
	}
	
} else if ($_POST['command'] == 'processUpload') {
	
	session_start();
	
	// check if IP Address is same
	if ($_SESSION['IP_ADDR'] != $_SERVER['REMOTE_ADDR']) {
		session_destroy();
		$pageMode = 'loginPage';
		$loginMessage = "<span class='msg'>Authentication failure: invalid session.</span>";
		
	} else {
	
		$pageMode = "formPage";
	
		// calculate file paths
		$log_path = $file_root;
		$target_path = $file_root;
		$url = $url_root;
		$upFileName = basename($_FILES['uploadedfile']['name']);
		$log_line = $_POST['uploader'] . "|" . time() . "|" . $upFileName . "|";
	
		if ($_POST['mp3type']=='orig') {
			$path_extension = "/orig/" . $upFileName;
			$target_path = $target_path . $path_extension;
			$url = $url . $path_extension;
			$log_path = $orig_log_path;
		} else if ($_POST['mp3type']=='final') {
			$path_extension = "/final/" . $_POST['year'] . "/" . $_POST['event'] . "/" . $upFileName;
			$target_path = $target_path . $path_extension;
			$url = $url . $path_extension;
			$log_path = $final_log_path;
		}
		
		$log_line .= $url;

		// check if file was actually uploaded
		if ((!empty($_FILES['uploadedfile'])) && ($_FILES['uploadedfile']['error'] == 0)) {

			$pwRotate2 = substr($_SESSION['Username'], 0, 1); // first letter
			// do some authentical here too, to prevent session hijacking.
			$pwModel = $pwFixed . $pwRotate . $pwRotate2 . $_SESSION['logNum'] . $upFileName;
			$computePw = md5($pwModel);
			$upPass = $_POST['UpPass'];
			
			if ($computePw != $upPass) {
				session_destroy();
				$pageMode = 'loginPage';
				$loginMessage = "<span class='msg'>Authentication failure: incorrect password.</span>";
				
			} else if (!preg_match('/\.mp3$/', $upFileName)) {
				$statusMessage = "<p>Error: only files of type mp3 may be uploaded!</p>";
			} else if (move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
				// save file: success!
				// get filesize
				$fsizemb = sprintf("%.1f MB",(filesize($target_path)/$oneMB));
				$log_line .= '|' . $fsizemb . "\n";
				// write to log
				$fh = fopen($log_path, 'a');
				fwrite($fh, $log_line);
				fclose($fh);
		
	    		$statusMessage = "<p>The file {$upFileName} has been uploaded.  Its URL is ".
	    							$http_url . $url . "</p>";

    			chmod($target_path, 0644);
    		
    			// send mail if that was selected
    			if ($_POST['authors']=="yes") {
    				$to      = 'authors@igsmonline.org';
					$subject = 'mp3 msg uploaded';
					$message = $_POST['message'];
					$message .= "\n\nURL to uploaded mp3:\n".$http_url . $url;
					$headers = 'From: '.$_POST['email']. "\r\n".
								'Reply-To: '.$_POST['email']. "\r\n" .
								'Cc: '.$_POST['email']. "\r\n" .
								'X-Mailer: PHP/' . phpversion();
					mail($to, $subject, $message, $headers);
    			}
			} else {
    			$statusMessage = "<p>There was an error saving the uploaded the file " . basename($_FILES['uploadedfile']['tmp_name']) . " to $target_path, please try again!</b>";
			}
		} else {
    			$statusMessage = "<p>No file uploaded! Please try again!</p>";
		}
	}
}

/* -------------------- HTML DISPLAY ------------------------ */

// print header so that this file doesn't get cached
header("Cache-Control: no-cache, must revalidate");

?>	
<html>
<head>
	
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.9.custom.min.js"></script>
<script type="text/javascript" src="jquery.md5.js"></script>
<script type="text/javascript" src="jquery.tablesorter.min.js"></script>

<?php
if ($pageMode=='formPage') {
?>
<script type="text/javascript">
  $(document).ready(function() {
  	function validateForm() {
		var ready = true;
		if ($('#uploader').val()=='') {
			ready = false;
			$('#uploadermsg').html('(required)');
		} else {
			$('#uploadermsg').html('');
		}
		var id = $("input[@name=mp3type]:checked").attr('id');
		if (id=='orig') {
			// check that file name ends with -orig.mp3
			if ($('#selectfile').val() != '') {
				if ($('#selectfile').val().match(/-orig\.mp3$/)) {
					$('#filemsg').html('');
				} else {
					$('#filemsg').html('(must end with -orig.mp3)');
					ready = false;
				}
			} else {
				ready = false;
				$('#filemsg').html('(required)');				
			}
		} else if (id == 'final') {
			if ($('#selectfile').val() != '') {
				if ($('#selectfile').val().match(/-orig\.mp3$/)) {
					ready = false;
					$('#filemsg').html('(edited files should not end with -orig.mp3)');
				} else if ($('#selectfile').val().match(/\.mp3$/)){
					$('#filemsg').html('');
				} else {
					$('#filemsg').html('(must end with -orig.mp3)');
					ready = false;
				}
			} else {
				ready = false;
				$('#filemsg').html('(required)');				
			}
			if ($('#year').val()=='Choose One' ||
				$('#event').val()=='Choose One') {
				ready=false;
				$('#infomsg').html('(year and event are required)');				
			} else {
				$('#infomsg').html('');
			}
			if ($('input[name=authors]:checked').val() == 'on') {
				if ($('#email').val()=='') {
					ready = false;
					$('#emailmsg').html('(required)');
				} else {
					$('#emailmsg').html('');
				}
			}
		}
		if ($('#upPasswordField').val() == '') {
			ready = false;
			$('#pwMsg').html('(required)');	
		} else {
			$('#pwMsg').html('');
		}
		if (ready) {
			$('#submit').removeAttr('disabled');
		} else {
			$('#submit').attr('disabled','true');
		}
	}
	
	
	/* bind validators */
	$('.cValid').change(validateForm);
	$('.bValid').blur(validateForm);
	
	/* event handlers */
    $('#orig').change(function(){
		$('div.info').hide();
	});
	$('#final').change(function(){
		$('div.info').show();
	});
	$('#uploader').keypress(function(e){
		if (e.which == 13 || e.which == 9) {
			// change focus to selectfile
			$(this).blur();
			$('#selectfile').focus();
			return false;
		}
	});
	$('#email').keypress(function(e){
		if (e.which == 13 || e.which == 9) {
			// change focus to selectfile
			$(this).blur();
			$('#mailcontent').focus();
			return false;
		}
	});
	$('#upPasswordField').keypress(function(e){
		if (e.which == 13 || e.which == 9) {
			$(this).blur();
			$('#submit').focus();
			return false;
		} else {
			validateForm();
		}
	});
	$('#sendauthors').change(function() {
		if ($('input[name=authors]:checked').val() == 'yes') {
			$('#maildiv').show();
		} else {
			$('#maildiv').hide();
		}
	});

	/* initial settings */
	
	// sending to authors - disable
	$('#maildiv').hide();
	
	// form submit disabled
	$('#submit').attr('disabled','true'); // start with submit disabled

	// orig/unedited mp3 is default
	$('#orig').attr("checked",1);
	$('#orig').change();
	
	// start with focus on name field
	$('#uploader').focus();

	//tablesorter
	$('#origlog').tablesorter({widgets: ["zebra"]});
	$('#finallog').tablesorter({widgets: ["zebra"]});

	//tabs
	$('#filetabs').tabs();

	$('#submit').click(function(e){
		// when submit button is pressed MD5 encrypt the password
		var fName = $('#selectfile').val().replace(/\\/g,'/').replace( /.*\//, '' );
		var oldpw = $('#upPasswordField').val() + fName;
		$('#upPasswordField').val($.md5(oldpw));
	});
  });
</script>
<?php
} else if ($pageMode=='loginPage') {
?>
<script type="text/javascript">
	$(document).ready(function() {
		$('#loginSubmitButton').click(function() {
			// when login submit button is pressed MD5 encrypt the password
			var oldpw = $('#passwordField').val();
			$('#passwordField').val($.md5(oldpw));
		});
	});
</script>
<?php
}
?>
<link type="text/css" href="css/smoothness/jquery-ui-1.8.9.custom.css" rel="stylesheet" />
<link href="blue/style.css" rel="stylesheet" type="text/css">
<style type='text/css'>
html { height:100%; }
body {
	background-color: #333333;
	margin:0px; 
	padding:0px; 
	height:100%;
}
div.page {
	position: relative;
	width: 80%;
	height: auto;
	margin-top: 0px;
	margin-bottom: 0px;
	margin-left: auto;
	margin-right: auto;
	padding: 20px;
	background-color: white;
}
.msg {
	font-style: italic;
	color: red;
}
span.tips {
	font-style: italic:
	font-size: x-small;
	color: #444444;
}
div.info {
	padding: 10px;
	width: auto;
}
div.maildiv {
	padding: 10px;
}
div.typeselection {
	padding: 5px;
}
div.login {
	margin-left: auto;
	margin-right: auto;
	border: 1px solid gray;
	background: #EEEEEE;
	width: 250px;
	padding:30px;
	align: center;
}
.grayout {
	color: gray;
}
.ui-tabs-nav {
	font-size: small;
}
.ui-tabs-panel {
	height: 200px;
	overflow: scroll;
}	
</style>
</head>
<body>

<div class='page'>

<h2>IGSM upload page</h2>
<hr />

<?php
if ($pageMode=='loginPage') {
?>
<div class='login'>
<form action="<?php echo $PHP_SELF;?>" method="POST">
<?php echo $loginMessage;?>
<table>
<tr><td>Username:</td><td><input type="text" size=20 name="username" /></td></tr>
<tr><td>Password:</td><td><input id="passwordField" type="password" size=20 name="password" /></td></tr>
</table>
<input type="hidden" name="command" value="processLogin" />
<input id="loginSubmitButton" type="submit" name="login" value="Submit" />
</form>
</div>
<?php
} else if ($pageMode=='formPage') {
?>
<span class='msg'><?php echo $statusMessage;?></span>

<form enctype="multipart/form-data" action="<?php echo $PHP_SELF;?>" method="POST">
<input type="hidden" name="MAX_FILE_SIZE" value="157286400" />
Your name:
<input id='uploader' class='bValid' type='text' name='uploader'></input><span id='uploadermsg' class='msg'></span><br/>
<p>
Choose a file to upload: <input id="selectfile" class='cValid' name="uploadedfile" type="file" /><span id='filemsg' class='msg'></span><br />
</p>
	
This is an:<br/>
<div class='typeselection'>
<input id='orig' class='cValid' type='radio' name='mp3type' value='orig'/>original/unedited recording<br/>
<input id='final' class='cValid' type='radio' name='mp3type' value='final'/>edited/final recording<br/>
</div>

<div class='info'>
Year
<select id='year' class='cValid' name="year">
<option>Choose One</option>
<option>2011</option>
<option>2010</option>
<option>2009</option>
<option>2008</option>
</select>

Event
<select id='event' class='cValid' name="event">
<option>Choose One</option>
<option>ff</option>
<option>sws</option>
<option>retreat</option>
<option>other</option>
</select>
<span id='infomsg' class='msg'></span>

<p>
<input id='sendauthors' class='cValid' type="checkbox" name="authors" value="yes">Send email to &lt;authors@igsmonline.org&gt; to post podcast.</input>
</p>
<p>
<div id='maildiv'>
<p>
Your Email: <input id='email' class='bValid' type='text' name='email' size=50></input><span id='emailmsg' class='msg'></span>
</p>
<span id='notes'>Notes to include in email to &lt;authors&gt; (if any):</span><br/>
<textarea id='mailcontent' name='message' rows=6 cols=80></textarea>
<br /><span class='tips'>(The URL to the uploaded file will be appended to the email.)</span>
</div>
</p>
</div>
<p>
Password: <input type="password" name="UpPass" size="20" id="upPasswordField" value='' class='cValid' /> <span id='pwMsg' class='msg'></span>
</p>
<input type="hidden" name="command" value="processUpload" />
<input id='submit' type="submit" name="submit" value="Upload File" />
</form>
<p><span class='tips'>Note: It may take a while to upload the file after hitting ("Upload File"). Please be patient.</span></p>
<hr />
<div id='filetabs'>
<ul>
	<li><a href='#tab-1'>Originals</a></li>
	<li><a href='#tab-2'>Final/Edited</a></li>
</ul>
<div id='tab-1' class='filelist'>
<table id='origlog' class='tablesorter'>
<thead>
	<tr>
		<th>Date</th>
		<th>Uploader</th>
		<th>Size</th>
		<th>File</th>
	</tr>
</thead>
<tbody>
<?php
	$file = file($orig_log_path);
	$filetracker = array();
	for ($i = count($file)-1; $i > count($file)-1-$numOriginalToShow && $i >= 0; $i--) {
		$logItems = explode("|", trim($file[$i]));
		// to skip duplicate log entries in case of overwrites
		if (array_key_exists($logItems[2],$filetracker)) {
			$i--;
			$numOriginalToShow++;
			continue;
		}
		echo "<tr>";
		echo "<td>".date("Y M d h:i A, T",$logItems[1])."</td>";
		echo "<td>{$logItems[0]}</td>";
		echo "<td>{$logItems[4]}</td>";
		echo "<td><a href='{$logItems[3]}'>{$logItems[2]}</a></td>";
		echo "</tr>";
		$filetracker[$logItems[2]] = 1;
	}
?>
</tbody>
</table>
</div>
<div id='tab-2' class='filelist'>
<table id='finallog' class='tablesorter'>
<thead>
	<tr>
		<th>Date</th>
		<th>Uploader</th>
		<th>Size</th>
		<th>File</th>
	</tr>
</thead>
<tbody>
<?php
	$file = file($final_log_path);
	$filetracker = array();
	for ($i = count($file)-1; $i > count($file)-1-$numFinalToShow && $i >= 0; $i--) {
		$logItems = explode("|", trim($file[$i]));
		// to skip duplicate log entries in case of overwrites
		if (array_key_exists($logItems[2],$filetracker)) {
			$i--;
			$numFinalToShow++;
			continue;
		}
		echo "<tr>";
		echo "<td class='date'>".date("Y M d h:i A, T",$logItems[1])."</td>";
		echo "<td>{$logItems[0]}</td>";
		echo "<td>{$logItems[4]}</td>";
		echo "<td><a href='{$logItems[3]}'>{$logItems[2]}</a></td>";
		echo "</tr>";
		$filetracker[$logItems[2]] = 1;
	}
?>
</table>
</div>
</div>
<?php
}
// end of (if formPage)
?>
</div>
</body>
</html>
