<?php

function generateAllDirs($dev) {

	/* Setup beginning of table */
        $html = '<table>
                     <tr>
                         <th class="name">Name</th>
                         <th class="time">Uploaded</th>
                         <th class="MD5">MD5</th>
                     </tr>';

	/* Set dir variable for later use */
	if (isset($_GET['d'])) {
		$dir = $_GET['d'] . "/";
	} else {
		$dir = "";
	}

	/* Pull JSON from BasketBuild */
	$json = json_decode(file_get_contents("https://s.basketbuild.com/api4web/devs/" . $dev . "/" . $dir));

	/* If $_GET['d'] contains a value, we set a back request up */
	if (!empty($dir)) {
		$backOne = dirname($dir);
		if ($backOne == ".") {
			$html .= '<tr><th><a href="' . strtok($_SERVER["REQUEST_URI"],'?') . '">..</a></th><th>&mdash;</th></tr>';
		} else {
			$html .= '<tr><th><a href="?d=' . $backOne . '">..</a></th><th>&mdash;</th></tr>';
		}
	}

	/* Handle Folders */
	foreach ($json->folders as $folder) {
		$html .= '<tr><th><a href="?d=' . $dir . $folder->folder . '">' . $folder->folder . '</a></th>';
		$html .= '<th>&mdash;</th>';
        $html .= '<th>&mdash;</th></tr>';
	}

	/* Handle Files */
	foreach ($json->files as $file) {
		$html .= '<tr><th><a href="' . $file->filelink . '">' . $file->file . '</a></th>';
        $html .= '<th>' . date('Y-m-d h:i:s', $file->fileTimestamp) . '</th>';
		$html .= '<th>' . $file->filemd5 . '</th></tr>';
	}

	/* End Table Tag */
	$html .= "</table>";

	/* Return The HTML */
	return $html;
}

function generateSingleDir($dev, $dir) {
	/* Make Sure Directory ends in / */
	if (substr($dir, -1) != "/") {
		$dir = $dir . "/";
	}
	
	/* Setup beginning of table */
	$html = '<table>
                     <tr>
                         <th class="name">Name</th>
                         <th class="MD5">MD5</th>
                     </tr>';

	/* Set dir variable for later use */
	if (isset($_GET['d'])) {
		$dir2 = $_GET['d'] . "/";
	} else {
		$dir2 = "";
	}

	/* Pull JSON from BasketBuild */
	$json = json_decode(file_get_contents("https://s.basketbuild.com/api4web/devs/" . $dev . "/" . $dir . $dir2));

	/* If $_GET['d'] contains a value, we set a back request up */
	if (!empty($dir2)) {
		$backOne = dirname($dir2);
		if ($backOne == ".") {
			$html .= '<tr><th><a href="' . strtok($_SERVER["REQUEST_URI"],'?') . '">..</a></th><th>&mdash;</th></tr>';
		} else {
			$html .= '<tr><th><a href="?d=' . $backOne . '">..</a></th><th>&mdash;</th></tr>';
		}
	}

	/* Handle Folders */
	foreach ($json->folders as $folder) {
		$html .= '<tr><th><a href="?d=' . $dir2 . $folder->folder . '">' . $folder->folder . '</a></th>';
		$html .= '<th>&mdash;</th></tr>';
	}

	/* Handle Files */
	foreach ($json->files as $file) {
		$html .= '<tr><th><a href="' . $file->filelink . '">' . $file->file . '</a></th>';
		$html .= '<th>' . $file->filemd5 . '</th></tr>';
	}

	/* End Table Tag */
	$html .= "</table>";

	/* Return The HTML */
	return $html;
}

function generateFileButton($dev, $file) {
	$html = '<br><a class="nostyle" href="https://s.basketbuild.com/filedl/devs?dev=' . $dev . '&dl=' . $dev . '/' . $file . '"><span class="button">Download File</span></a><br>';
	return $html;
}
?>