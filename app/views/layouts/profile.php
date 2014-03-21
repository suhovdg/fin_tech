<?php
if (empty($content)) {
	$content = '';
}
/**
 * @var string $userMessage
 */
?>
<!DOCTYPE html>
<html>
<head>
	<?= View::make('layouts.inc.head.head') ?>
	<?= View::make('layouts.inc.navbar.navbar') ?>
</head>
<body>
<?= View::make('layouts.inc.head.flash_message') ?>
<div class="container"><?= $content ?></div>
</body>
</html>
