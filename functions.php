<?php
function imap_list_source_mailboxes($server, $user, $pwd) {
	global $folders_skip;
	
	// Get list of mailboxes from src_server for $username
	$mailbox = @imap_open($server, $user, $pwd);
	$list = @imap_list($mailbox, $server,"*");
	
	if (is_array($list)) {
		reset($list);
	} else {
		$error = "source server <code>imap_list</code> failed: <code>". imap_last_error()."</code>\n";
		return $error;
	}

	while (list($key, $val) = each($list)) {
		$mailbox = @imap_utf7_decode($val);
		$fullmailbox = $mailbox;
		$mailbox = str_replace($server, "", $mailbox);

		// Skip UNIX hidden files
		if (ereg("^\.", $mailbox)) {
			continue;
		}
		  
		if (!in_array(str_replace("INBOX.", "", $mailbox), $folders_skip)) {
			$count = @imap_open($server . $mailbox, $user, $pwd);
			$mbArray[] = array('mailbox' => $mailbox, 'messages' => @imap_num_msg($count));
			@imap_close($countä);
		}
	}

	@imap_close($sourceMailbox);
	return $mbArray;
}


function imap_mailbox_exists($connection, $server, $mailbox) {
	$mailboxes = @imap_list($connection, $server, $mailbox);

	if (empty($mailboxes)) {
		return false;
	} else {
		return true;
	}
}


function imap_mailbox_create($connection, $server, $mailbox) {
	if( @imap_createmailbox($connection, imap_utf7_encode($server . $mailbox))) {
		return true;
	} else {
		return false;
	}
}


// check destination-user check
function destinationUserCheck() {
	global $destinationUser, $sourceUser; 

	if ($destinationUser=="") {
		$destinationUser = $sourceUser;
	}

	return $destinationUser;
}


// check destination-pwd check
function destinationPwdCheck() {
	global $destinationPwd, $sourcePwd;

	if ($destinationPwd=="") {
		$destinationPwd = $sourcePwd;
	}

	return $destinationPwd;
}


/*
 * memory check
 *
 */
function memory_check() {
	if (parse_size(ini_get('memory_limit')) < parse_size($memory_limit)){
 		print "Your \$memory_limit is to low! (". ini_get('memory_limit') ." < $memory_limit)";
	} else {
		return true;
	}
}

/*
 * parses a given byte count
 *
 * thanks drupal!
 */
function parse_size($size) {
  $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
  $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
  if ($unit) {
    // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
    return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
  }
  else {
    return round($size);
  }
}
?>