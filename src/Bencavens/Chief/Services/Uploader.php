<?php namespace Bencavens\Chief\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Exception;

class Uploader{
		
	protected $dir;

	public function __construct($dir = null)
	{
		if(!is_null($dir)) $this->dir( $dir );
	}

	/**
	 * Upload
	 *
	 * @param 	Symfony\Component\HttpFoundation\File\UploadedFile $file
	 * @return 	object
	 */
	public function upload( UploadedFile $file = null )
	{
		// No file upload
		if(is_null($file)) return false;

		// Check errors

		$dir 		= is_null($this->dir) ? public_path() : $this->dir;
		$extension 	= $file->guessExtension();
		$filename 	= md5(date('Ymdhis')).'.'.$extension;
		$path 		= $dir.'/'.$filename;

		// Save file
		$file->move($dir,$filename);

		return (object)array(

			'originalName' 	=> $file->getClientOriginalName(),
			'mimeType'		=> $file->getClientMimeType(),
			'extension'		=> $extension,
			'size'			=> $file->getClientSize(),
			'filename'		=> $filename,
			'pathName'		=> $path,
			'error'			=> $file->getError()

		);
	}

	/**
	 * Set the destination dir
	 *
	 * @param 	string 	$dir
	 * @return 	void
	 */
	public function dir( $dir )
	{
		if(!is_dir($dir) or !is_writable($dir))
		{
			try{
				mkdir($dir,0777,true);
			}
			catch(Exception $e)
			{
				throw new Exception('Could not create or write to directory ['.$dir.']. Permission denied');
			}
		}

		$this->dir = $dir;
	}


	
}