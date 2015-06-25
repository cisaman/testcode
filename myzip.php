<?php

// assuming file.zip is in the same directory as the executing script.
$file = 'admin/psd2html.zip'; //like mydir.zip

// get the absolute path to $file
 $path = "admin";

$zip = new ZipArchive;
$res = $zip->open($file);
if ($res === TRUE) {
// extract it to the path we determined above
$zip->extractTo($path);
$zip->close();
echo 'WOO! $file extracted to $path';
} else {
echo 'Doh! I couldn?t open $file';
}

?>