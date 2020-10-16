<?php

	session_start();
	
	function message() {
		if (isset($_SESSION["message"])) {
			$output = "<div class=\"message\"><ul>";
			$output .= $_SESSION["message"];
			$output .= "</ul></div>";
			
			// clear message after use
			$_SESSION["message"] = null;
			
			return $output;
		}
	}

	function errors() {
		if (isset($_SESSION["errors"])) {
			$errors = "<div class=\"errors\"><ul>";
			$errors .= $_SESSION["errors"];
			$errors .= "</ul></div>";
			
			// clear message after use
			$_SESSION["errors"] = null;
			
			return $errors;
		}
	}
	
	function showSessionMessage() { ?>
		<div id="return_messages">
			<?php if(isset($_SESSION["message"])) {
				echo message();
			} else {
				$_SESSION["message"] = null;
			}
			
			if(isset($_SESSION["errors"])) {
				echo errors();
			} else {
				$_SESSION["errors"] = null;
			} ?>
		</div>
	<?php }
	
?>