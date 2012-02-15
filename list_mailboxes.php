<?php
require("./config.php");
require("./functions.php");

$mailboxes = imap_list_source_mailboxes($sourceServer, $sourceUser, $sourcePwd);
?>
<html>
<head>
  <title>IMAP Export Import</title>

  <style type="text/css">
	* {
		color: #333;
		font: 15px "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-weight: 300;
		line-height: 1.625;
	}

	code {
		font-style: italic;
	}
  </style>
</head>
<body>
<h1><?php print $sourceUser ?></h1>
<ol>
<?php 
if (is_array($mailboxes)) {
	foreach ($mailboxes as $key => $box) {
		print '<li><a href="import_mailbox.php?folder='. $box['mailbox'] .'" target="_blank">'. $box['mailbox'] .' - '. $box['messages'] .' messages</a></li>';
	}
} else {
	print $mailboxes;
}
?>
</ol>
</body>
</html>