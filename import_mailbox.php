<?php
require("./config.php");
require("./functions.php");

$destinationUser = destinationUserCheck();
$destinationPwd = destinationPwdCheck();

$mailbox = $_GET['folder'];

// Open sourceServer and mailbox
$sourceMailbox = @imap_open($sourceServer . $mailbox, $sourceUser, $sourcePwd)
	 or die("can't connect to sourceMailbox: ".imap_last_error());

// Open destinationServer, choose no mailbox
$destinationMailbox = @imap_open($destinationServer, $destinationUser, $destinationPwd, OP_HALFOPEN) 
	 or die("can't connect to destinationMailbox: ".imap_last_error());

// check if mailbox exists
$mailbox_exists = imap_mailbox_exists($destinationMailbox, $destinationServer, $mailbox);

// create non existing mailbox
if (!$mailbox_exists) {
	if( imap_mailbox_create($destinationMailbox, $destinationServer, $mailbox) ) {
		print "Mailbox created: $mailbox";
	} else {
		print "Error: ". imap_last_error();
	}
}

$destinationMailbox = @imap_open($destinationServer . $mailbox, $destinationUser, $destinationPwd);

$sourceMailsStatus = imap_check($sourceMailbox);

for ($i=1; $i<=$sourceMailsStatus->Nmsgs; $i++) {
	$soureMail = imap_fetchheader($sourceMailbox, $i) . "\r" . imap_body($sourceMailbox, $i, FT_PEEK);
	imap_append($destinationMailbox, $destinationServer . $mailbox, $soureMail);
	$messageInfo = imap_headerinfo($sourceMailbox, $i);

	if ($messageInfo->Unseen!="U") {	
		$status = imap_setflag_full($destinationMailbox, $i, "\\Seen \\Flagged");
		//echo gettype($status) . "\n";
		//echo $status . "\n";
	}
}

$check = imap_check($destinationMailbox);
echo "Msg Count after append : ". $check->Nmsgs . "\n";
imap_close($sourceMailbox);
imap_close($destinationMailbox);
?>