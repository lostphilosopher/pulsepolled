<H1>TESTING DB CONNECTION AND I/O...</H1>

<ul>
<?php
	foreach ($views as $view) {
		var_dump($view);
		echo '<li>' . $view->ip . '</li>';
	}
?>
</ul>