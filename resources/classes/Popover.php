<?php
	class Popover {
		var $message;
		function set_popover($alert_type, $error_message) {
			$this->message = <<<ERROR_POP
			<div class="alert alert-$alert_type alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <strong>Error: </strong>$error_message
            </div>
ERROR_POP;
			
			
		}
		function get_popover() {
			return $this->message;
		}
	}

?>