<?php
class m130930_130344_ClearAssets extends CDbMigration
{
	public function up()
	{


		$this->clearAssets();
	}

	private function clearAssets()
	{
		$path = Yii::app()->assetManager->getBasePath();
		$this->clearDir($path);
		echo "Assets clear\n";
	}

	private function clearDir($folder, $main = true)
	{
		if (is_dir($folder)) {
			$handle = opendir($folder);
			while ($subfile = readdir($handle)) {
				if ($subfile == '.' || $subfile == '..' || $subfile == '.gitignore') {
					continue;
				}
				if (is_file($subfile)) {
					unlink("{$folder}/{$subfile}");
				} else {
					$this->clearDir("{$folder}/{$subfile}", false);
				}
			}
			closedir($handle);
			if (!$main) {
				rmdir($folder);
			}
		} else {
			unlink($folder);
		}
	}

	public function down()
	{
		echo "m130930_130344_ClearAssets does not support migration down.\n";

		return false;


	}

	/*	// Use safeUp/safeDown to do migration with transaction	public function safeUp()	{	}

	public function safeDown()	{	}	*/
}
