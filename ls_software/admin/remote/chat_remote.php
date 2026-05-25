<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/SqlServerDb.php';
$con = portal_get_sqlsrv_db();

$method = isset($_POST['method'])?$_POST['method']:'Error: no method was set.';

switch($method){
	case 'login':
		$nickname = $_POST['chat_nick'];
		$email = $_POST['chat_email'];
		$ip = $_POST['ipaddress'];
		$returning = $_POST['returning'];
		$error_msg=array();

		//Validate nickname
		if($nickname!=""){
		if(preg_match('/^[a-zA-Z0-9\s.\-\#]+$/',$nickname)){
			$nickname=$nickname;
		}else{
			$error_msg[]="The nickname can only contain numbers and letters.";
		}
		}else{
			$error_msg[]="Please enter a nickname.";
		}

		// Validate Email
		if($email!=""){
			if(preg_match('/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/',$email)){
				$email=$email;
			}else{
				$error_msg[]="Please check the email address again.";
			}
		}else{
			$error_msg[]="Email address cannot be empty";
		}

		if(count($error_msg)!=0){
			echo <<<EOD
				<p>The following errors were detected:</p>
				<ul>
EOD;
			foreach($error_msg as $err){
				echo "<li>".$err."</li>";
			}
				echo "</ul>";
				echo <<<EOD
				<form id="chat_nickform" name="chat_nickform" action="/remote/chat_remote.php" method="post" onsubmit="new Ajax.Updater('chat_nickname',this.action,{method:'post',asynchronous:true,parameters:Form.serialize(this)});new Ajax.Updater('chat_users','/remote/chat_remote.php',{method:'post',asynchronous:true,parameters:'checklogins='});return false;">
				<input type="hidden" name="method" id="login" value="login" />
				<input type="hidden" name="ipaddress" id="ipaddress" value="{$_POST['ipaddress']}" />
				Nickname: <input type="text" id="chat_nick" name="chat_nick" />
				E-mail: <input type="text" id="chat_email" name="chat_email" /><br />
				<input type="checkbox" id="returning" name="returning" value="returning" /> Returning User
				<input type="submit" name="chat_nsubmit" id="chat_nsubmit" value="Submit" /><br />
				<span class="smaller">* E-mail is not displayed. IP addresses are logged for spam detection.</span>
			</form>
EOD;
	}else{
		//Check to see if user exists already
		$checksql = <<<EOD
		SELECT * FROM chat_users WHERE nickname = '{$nickname}' OR email = '{$email}';
EOD;
		$checkresult = $con->query($checksql);
		$num_rows = $checkresult->num_rows;
		if($num_rows == 0){
			$insert = <<<EOD
				INSERT INTO chat_users (nickname,email,ipaddress,loggedin)
				VALUES ('{$nickname}','{$email}', '{$ip}', 'yes');
EOD;
			$results = $con->query($insert);
			$_SESSION['nickname'] = $nickname;
			echo <<<EOD
				Logged in as {$nickname} <a href="LogOut" onclick="logmeout();return false;">Logout</a>
EOD;
		}
		else if($num_rows >= 1){
			while($row = $checkresult->fetch_assoc()){
				if($row['nickname'] == $nickname && $row['email'] != $email){

				echo <<<EOD
					<p>That nickname is already taken.</p>
					<form id="chat_nickform" name="chat_nickform" action="/remote/chat_remote.php" method="post" onsubmit="new Ajax.Updater('chat_nickname',this.action,{method:'post',asynchronous:true,parameters:Form.serialize(this)});new Ajax.Updater('chat_users','/remote/chat_remote.php',{method:'post',asynchronous:true,parameters:'checklogins='});return false;">
					<input type="hidden" name="method" id="login" value="login" />
					<input type="hidden" name="ipaddress" id="ipaddress" value="{$ip}" />
					Nickname: <input type="text" id="chat_nick" name="chat_nick" />
					E-mail: <input type="text" id="chat_email" name="chat_email" value="{$email}" /><br />
					<input type="checkbox" id="returning" name="returning" value="returning" /> Returning User
					<input type="submit" name="chat_nsubmit" id="chat_nsubmit" value="Submit" /><br />
					<span class="smaller">* E-mail is not displayed. IP addresses are logged for spam detection.</span>
					</form>
EOD;
				}else if($row['nickname'] != $nickname && $row['email'] == $email){

					echo <<<EOD
						<p>That email address is already in use for the nickname '{$row['nickname']}'. If this is you, please use that nickname.</p>
						<form id="chat_nickform" name="chat_nickform" action="/remote/chat_remote.php" method="post" onsubmit="new Ajax.Updater('chat_nickname',this.action,{method:'post',asynchronous:true,parameters:Form.serialize(this)});new Ajax.Updater('chat_users','/remote/chat_remote.php',{method:'post',asynchronous:true,parameters:'checklogins='});return false;">
						<input type="hidden" name="method" id="login" value="login" />
						<input type="hidden" name="ipaddress" id="ipaddress" value="{$ip}" />
						Nickname: <input type="text" id="chat_nick" name="chat_nick" />
						E-mail: <input type="text" id="chat_email" name="chat_email" value="{$email}" /><br />
						<input type="checkbox" id="returning" name="returning" value="returning" /> Returning User
						<input type="submit" name="chat_nsubmit" id="chat_nsubmit" value="Submit" /><br />
						<span class="smaller">* E-mail is not displayed. IP addresses are logged for spam detection.</span>
					</form>
EOD;
				}else{
					$insert = <<<EOD
					UPDATE chat_users SET loggedin = 'yes' WHERE nickname = '{$nickname}' AND email = '{$email}';
EOD;
					$results = $con->query($insert);
					$_SESSION['nickname'] = $nickname;
					echo <<<EOD
						Logged in as {$nickname} <a href="LogOut" onclick="logmeout();return false;">Logout</a>
EOD;
				}


			}

		if($returning == 'returning'){
				$insert = <<<EOD
				UPDATE chat_users SET loggedin = 'yes' WHERE nickname = '{$nickname}' AND email = '{$email}';
EOD;
				$results = $con->query($insert);
				$_SESSION['nickname'] = $nickname;
				echo <<<EOD
				Logged in as {$nickname} <a href="LogOut" onclick="logmeout();return false;">Logout</a>
EOD;

			}
		}
	}


	break;

	case 'logout':
		$logouttype = isset($_POST['logouttype'])?$_POST['logouttype']:'inactive';
		switch($logouttype){
			case 'active':
			$nickname = $_SESSION['nickname'];
			$ip = getenv('REMOTE_ADDR');
			$sql = <<<EOD
				UPDATE chat_users SET loggedin = 'no' WHERE nickname = '{$nickname}';
EOD;
			$result = $con->query($sql);
			unset($_SESSION['nickname']);
			echo <<<EOD
				<form id="chat_nickform" name="chat_nickform" action="/remote/chat_remote.php" method="post" onsubmit="new Ajax.Updater('chat_nickname',this.action,{method:'post',asynchronous:true,parameters:Form.serialize(this)});new Ajax.Updater('chat_users','/remote/chat_remote.php',{method:'post',asynchronous:true,parameters:'checklogins='});return false;">
				<input type="hidden" name="method" id="login" value="login" />
				<input type="hidden" name="ipaddress" id="ipaddress" value="{$ip}" />
				Nickname: <input type="text" id="chat_nick" name="chat_nick" />
				E-mail: <input type="text" id="chat_email" name="chat_email" /><br />
				<input type="checkbox" id="returning" name="returning" value="returning" /> Returning User
				<input type="submit" name="chat_nsubmit" id="chat_nsubmit" value="Submit" /><br />
				<span class="smaller">* E-mail is not displayed. IP addresses are logged for spam detection.</span>
				</form>
EOD;
			break;
			case 'inactive':
			// TODO: SQL Server rewrite — MySQL `count(if(DATEADD(...) > CURRENT_TIMESTAMP,1,null))`
			// needs CASE WHEN ... THEN 1 END inside COUNT for T-SQL.
			$sqlone = <<<EOD
				SELECT *,
					COUNT(CASE WHEN DATEADD(HOUR, 1, timestamp) > CURRENT_TIMESTAMP THEN 1 END) as new
				FROM chat_transcript
				group by user_id
				having COUNT(CASE WHEN DATEADD(HOUR, 1, timestamp) > CURRENT_TIMESTAMP THEN 1 END) = 0;
EOD;
			$resultone = $con->query($sqlone);
			if($resultone->num_rows > 0){
				while($row = $resultone->fetch_assoc()){
					$idlist[] = $row['user_id'];
				}
				$idlist = implode(',',$idlist);
				$sql = <<<EOD
					UPDATE chat_users  SET loggedin = 'no' WHERE user_id IN ({$idlist});
EOD;
			$result = $con->query($sql);

			echo <<<EOD
			<form id="chat_nickform" name="chat_nickform" action="/remote/chat_remote.php" method="post" onsubmit="new Ajax.Updater('chat_nickname',this.action,{method:'post',asynchronous:true,parameters:Form.serialize(this)});new Ajax.Updater('chat_users','/remote/chat_remote.php',{method:'post',asynchronous:true,parameters:'checklogins='});return false;">
			<input type="hidden" name="method" id="login" value="login" />
			<input type="hidden" name="ipaddress" id="ipaddress" value="{$ip}" />
			Nickname: <input type="text" id="chat_nick" name="chat_nick" />
			E-mail: <input type="text" id="chat_email" name="chat_email" /><br />
			<input type="checkbox" id="returning" name="returning" value="returning" /> Returning User
			<input type="submit" name="chat_nsubmit" id="chat_nsubmit" value="Submit" /><br />
			<span class="smaller">* E-mail is not displayed. IP addresses are logged for spam detection.</span>
			</form>
EOD;

			}

			break;
		}
	break;
	case 'logoutinactive':
		// TODO: same MySQL count(if(...)) pattern rewritten as COUNT(CASE WHEN ...).
		$sqlone = <<<EOD
		SELECT *,
		       COUNT(CASE WHEN DATEADD(HOUR, 1, timestamp) > CURRENT_TIMESTAMP THEN 1 END) as new
		FROM chat_transcript
		group by user_id
		having COUNT(CASE WHEN DATEADD(HOUR, 1, timestamp) > CURRENT_TIMESTAMP THEN 1 END) = 0;
EOD;
		$resultone = $con->query($sqlone);
		if($resultone->num_rows > 0){
			while($row = $resultone->fetch_assoc()){
				$idlist[] = $row['user_id'];
			}
			$idlist = implode(',',$idlist);
			$sql = <<<EOD
				UPDATE chat_users  SET loggedin = 'no' WHERE user_id IN ({$idlist});
EOD;
			$result = $con->query($sql);
		}
	break;
	case 'chat':
		if(!isset($_SESSION['nickname'])){
			echo <<<EOD
				<span style="color:red;">Enter your nickname and email address to begin chatting.</span>
EOD;
		}else{
			$nick = $_SESSION['nickname'];
			$user_sql = <<<EOD
			SELECT user_id, last_login FROM chat_users WHERE nickname = '{$nick}';
EOD;
			$user_result = $con->query($user_sql);
			$user_array = $user_result->fetch_assoc();
			$user_id = $user_array['user_id'];
			$page = $_POST['page'];
			$page_sql = <<<EOD
			SELECT page_id FROM chat_pages WHERE page = '{$page}';
EOD;
			$page_result = $con->query($page_sql);
			$page_array = $page_result->fetch_assoc();
			$page_id = $page_array['page_id'];
			$c_text = addslashes($_POST['chat_text']);
			$trans_sql = <<<EOD
			INSERT INTO chat_transcript
			(user_id,page_id,text)
			VALUES
			('{$user_id}','{$page_id}','{$c_text}');
EOD;
			$trans_result=$con->query($trans_sql);

			$chat_sql = <<<EOD
			SELECT *,  FORMAT(timestamp, 'yyyy-MM-dd HH:mm:ss') as timestamp FROM chat_transcript
			WHERE timestamp >= '{$user_array['last_login']}'
			AND page_id = '{$page_id}'
			ORDER BY timestamp DESC;
EOD;
			$chat_result = $con->query($chat_sql);
			while($chat = $chat_result->fetch_assoc()){
				$uid = $chat['user_id'];
				$nick_sql = <<<EOD
				SELECT nickname FROM chat_users WHERE user_id = '{$uid}';
EOD;
				$nick_result = $con->query($nick_sql);
				$nick_array = $nick_result->fetch_array();
				$nickname = $nick_array['nickname'];
				$time = date('g:i:s A',strtotime($chat['timestamp']));
				echo <<<EOD
				[{$nickname} {$time}] {$chat['text']}<br />
EOD;
			}


		}
	break;

	case 'showchat':
		if(isset($_SESSION['nickname'])){
			$nick = $_SESSION['nickname'];
			$user_sql = <<<EOD
				SELECT user_id, last_login FROM chat_users WHERE nickname = '{$nick}';
EOD;
			$user_result = $con->query($user_sql);
			$user_array = $user_result->fetch_assoc();
			$user_id = $user_array['user_id'];
			$page = $_POST['page'];
			$page_sql = <<<EOD
				SELECT page_id FROM chat_pages WHERE page = '{$page}';
EOD;
			$page_result = $con->query($page_sql);
			$page_array = $page_result->fetch_assoc();
			$page_id = $page_array['page_id'];
			$chat_sql = <<<EOD
			SELECT * , FORMAT(timestamp, 'yyyy-MM-dd HH:mm:ss') as timestamp FROM chat_transcript
			WHERE timestamp >= '{$user_array['last_login']}'
			AND page_id = '{$page_id}'
			ORDER BY timestamp DESC;
EOD;
			$chat_result = $con->query($chat_sql);
			while($chat = $chat_result->fetch_assoc()){
				$uid = $chat['user_id'];
				$nick_sql = <<<EOD
				SELECT nickname FROM chat_users WHERE user_id = '{$uid}';
EOD;
				$nick_result = $con->query($nick_sql);
				$nick_array = $nick_result->fetch_array();
				$nickname = $nick_array['nickname'];
				$time = date('g:i:s A',strtotime($chat['timestamp']));
				echo <<<EOD
				[{$nickname} {$time}] {$chat['text']}<br />
EOD;
			}

		}else{
			echo <<<EOD
				<span style="color:red;">Enter your nickname and email address to begin chatting.</span>
EOD;
	}
	break;

	case 'users':


		$user_sql = <<<EOD
		SELECT * FROM chat_users WHERE loggedin = 'yes';
EOD;
		$user_results = $con->query($user_sql);
		$num_rows = $user_results->num_rows;
		if($num_rows !=0){
			while($user = $user_results->fetch_assoc()){
				echo $user['nickname']."<br />";
				//echo $nexthour."<br />";
			//echo $thishour;
			}
		}else{
			echo 'Nobody is logged in.<br />';
			//echo $nexthour."<br />";
			//echo $thishour;
			if(isset($_SESSION['nickname'])){
				unset($_SESSION['nickname']);
			}
	}
	break;


}


?>
