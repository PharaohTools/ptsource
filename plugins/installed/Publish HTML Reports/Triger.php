<?php

class Triger {

	function __construct() {

	}

	public function startTriger($input) {

		$dir = $input['HTML directory to archive'];
		if (substr($dir, -1) != '/') { $dir = $dir . '/';
		}
		$indexFile = $input['Index page'];
		$ReportTitle = $input['Report title'];

		$tmpfile = $input["tmpfile"];

		$raw = file_get_contents($tmpfile);
		if (!$raw) {
			echo "Report not generated";
		}
		else {
			$raw = str_replace('/n', "<br />", $raw);
			$htmloutput = "
		    <html>
		    <head><title>" . $ReportTitle . "</title>
		    <style>
		    .slug {font-size: 15pt; font-weight: bold}
		    .byline { font-style: italic }
		    </style>
		    </head>
		    <body>
		    " . $raw . "
		    </body>
			</html>";

			file_put_contents($input["pluginWorkDir"] . $indexFile . '-' . date("l jS \of F Y h:i:s A"), $htmloutput);
			if (file_put_contents($dir . $indexFile, $htmloutput)) {
				return true;
			} 
			else {
				return false;
			}
		}
		return false;

	}

}
