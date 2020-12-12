<?php namespace App\maguttiCms\Tools;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Input;
use Form;
use App;

class UploadManager
{
	protected $model;

	protected $newMedia;            // file object
	protected $fileFullName;        // full filename
	protected $fileBaseName;        // filename  without extension
	protected $fileExtension;       // file extension
	protected $mediaType;           // media type  doc or image
	protected $destinationStorage;  // media destination storage
	protected $destinationPath;     // media destination path
	protected $sanitizeFileName = true;

	/**
	* @param $media
	* @param $model
	* @return $this
	*/
	public function init($media, $request, $disk = '', $folder = '')
	{
		$this->media = $media;
		$this->request = $request;

		if ($disk) {
			$this->destinationStorage = $disk;
			$this->destinationPath = $folder;
		} else {
			$this->destinationStorage = 'media';
			$this->destinationPath = '';
		}

		return $this;
	}

	protected function prepareMediaToUpload()
	{
		if (request()->hasFile($this->media) && request()->file($this->media)->isValid()) {
			$this->newMedia = request()->file($this->media);
			$this->setFileFullName($this->newMedia->getClientOriginalName());
			if ($this->destinationStorage == 'media' && !$this->destinationPath) {
				$this->destinationPath = $this->getMediaType();
			}
			$this->fileNameHandler();
			return true;
		}
		return false;
	}

	/**
	* Store function uploading
	* file to given path;
	* @return $this
	*/
	public function store()
	{
		if ($this->prepareMediaToUpload()) {
			$this->request->file($this->media)->storeAs(
				$this->destinationPath,
				$this->getFileFullName(),
				$this->destinationStorage
			);
		}
		return $this;
	}

	/**
	* Rename the file name if
	* if already exist
	* @return $this
	*/
	public function fileNameHandler()
	{
		$this->sanitizeFileFullName();

		if ($this->verifyIfFileExist()) {
			$newFileName = Str::slug(rand(10000, 99999) . '_' . $this->getFileBaseName()) . "." . $this->getFileExtension();
			$this->setFileFullName($newFileName);
		}
		return $this;
	}

	/**
	* @return string
	*/
	public function getDestinationPath()
	{
		return $this->destinationPath;
	}

	/**
	*
	* @return bool
	*/
	protected function verifyIfFileExist()
	{
		return \Storage::disk($this->destinationStorage)->exists($this->destinationPath . '/' . $this->getFileFullName());
	}

	/**
	* @return mixed
	*/
	protected function getFileExtension()
	{
		return $this->fileExtension = $this->newMedia->getClientOriginalExtension(); // getting image extension
	}

	/**
	* @return mixed
	*/
	public function getFileBaseName()
	{
		return $this->fileBaseName = basename(
			$this->newMedia->getClientOriginalName(),
			'.' . $this->newMedia->getClientOriginalExtension()
		);
	}

	/**
	* @return string
	*/
	public function getMediaType()
	{
		return $this->mediaType = (is_image($this->newMedia->getMimeType()) == 'image') ? 'images' : 'docs';
	}

	/**
	* @return mixed
	*/
	public function getFileFullName()
	{
		return $this->fileFullName;
	}

	/**
	* @param mixed $fileName
	*/
	public function setFileFullName($fileName)
	{
		$this->fileFullName = $fileName;
	}

	/**
	* @return mixed
	*/
	public function sanitizeFileFullName()
	{
		if ($this->sanitizeFileName == true) {
			$this->setFileFullName(Str::slug($this->getFileBaseName()) . '.' . $this->getFileExtension());
		}

		return $this;
	}

	/**
	* Store file attributes
	* @return array
	*/
	public function getFileDetails()
	{
		return [
			'basename' => $this->getFileBaseName(),
			'fullName' => $this->getFileFullName(),
			'extension' => $this->getFileExtension(),
			'fullPath' => $this->getDestinationPath(),
			'mimeType' => $this->newMedia->getMimeType(),
			'mediaType' => $this->getMediaType(),
			'size' => $this->newMedia->getSize(),
			'disk' => $this->destinationStorage
		];
	}

	/**
	* @param bool $sanitizeFileName
	* @return UploadManager
	*/
	public function setSanitizeFileName(bool $sanitizeFileName): UploadManager
	{
		$this->sanitizeFileName = $sanitizeFileName;
		return $this;
	}

	/**
	* @return bool
	*/
	public function isSanitizeFileName(): bool
	{
		return $this->sanitizeFileName;
	}

	public function storeData($data, $uploaded_filename, $config)
	{
		if (preg_match('/^data:image\/(\w+);base64,/', $data, $extension)) {
			$data = substr($data, strpos($data, ',') + 1);
			$extension = strtolower($extension[1]); // jpg, png, gif
			if (!in_array($extension, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
				throw new \Exception('invalid image type');
			}
			$data = base64_decode($data);
			if ($data === false) {
				throw new \Exception('base64_decode failed');
			}
		} else {
			throw new \Exception('did not match data URI with image data');
		}

		$extension = $config->get('extension')?: $extension;

		$storage = Storage::disk($this->destinationStorage);
		$pathinfo = pathinfo($uploaded_filename);
		$new_filename = Str::slug($pathinfo['filename']).'.'.$extension;
		$new_path = $this->destinationPath.'/'.$new_filename;

		if ($storage->exists($new_path)) {
			$new_filename = Str::slug(rand(10000,99999).'_'.$pathinfo['filename']).".".$extension;
		}

		$storage->put($this->destinationPath.'/'.$new_filename, $data);

		return [
			'basename' => pathinfo($new_filename, PATHINFO_BASENAME),
			'fullName' => $new_filename,
			'extension' => pathinfo($new_filename, PATHINFO_EXTENSION),
			'fullPath' => $this->getDestinationPath(),
			'mimeType' => '',
			'mediaType' => 'images',
			'size' => $storage->size($this->destinationPath.'/'.$new_filename),
			'disk' => $this->destinationStorage
		];
	}
}
