<?php
require("./config.php");
require("./functions.php");


memory_check();
$destinationUser = destinationUserCheck();
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
<h1>IMAP Export - Import</h1>
<h2><?php print $sourceUser ?> -> <?php print $destinationUser ?></h2>
<h2><?php print $sourceServer ?> -> <?php print $destinationServer ?></h2>
<a href="list_mailboxes.php">Folder</a>
</body>
</html>
