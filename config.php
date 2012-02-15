<?php
$sourceUser = "foo@foo.com";
$sourcePwd = "foo";
$sourceServer = "{mail.foo.com:143}";
$destinationUser = "foo@foo.cc";
$destinationPwd = "foo";
$destinationServer = "{mail.foo.cc:143}";


// A list of folders that will be skipped.
// NOTE - If a parent folder is listed, all children folders are skipped too
$folders_skip = array(
    "Protected", 
    "Calendar", 
    "Contacts",  
    "Notes", 
    "Journal", 
    "Tasks", 
    "Spam",
    "Junk",
    "Public Folders");

$memory_limit = "384M";
?>