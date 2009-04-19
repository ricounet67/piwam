<?php
/**
 * This class provides an easy way to export data within a file
 * 
 * @author 	Adrien Mogenet
 * @since	r15
 *
 */
class FileExporter
{
	private $filename = null;
	
	public function __construct($filename)
	{
		$this->filename = $filename;
	}
}
?>