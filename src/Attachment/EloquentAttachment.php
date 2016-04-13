<?php

namespace Tysdever\EloquentAttachment;

use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\Validator;

class EloquentAttachment {

	protected $request;

	protected $validator;

	protected $uploadedFileSuffix;

	protected $tmpPath;

	public function __construct() {
		$config = Config::get('eloquent-attachment');

		$this->tmpPath = $config['tmp_path'];

		$this->uploadedFileSuffix = $config['uploaded_file_suffix'];
	}


	public function getTempPath()
	{
		return $this->tmpPath;
	}


	public function getUrlPath()
	{
		return str_replace($_SERVER['DOCUMENT_ROOT'], '', $this->tmpPath);
	}


	public function getUpdatedFileSuffix()
	{
		return $this->uploadedFileSuffix;
	}


	public function setRequestInstance(Request $request) {
		$this->request = $request;
	}

	public function setValidatorInstance(validator $validator) {
		$this->validator = $validator;
	}

	public function upload() {
		foreach ($this->collect() as $field => $file) {

			$imageName = str_random(32) . '.' . $file->getClientOriginalExtension();

			$file->move(
				$this->tmpPath, $imageName
			);

			$this->request->merge([$field . $this->uploadedFileSuffix => $imageName]);
		}
	}

	public function isUploaded() {
		$attachments = array_keys($this->validator->getRules());

		foreach ($attachments as $field) {
			if ($this->request->has($field . $this->uploadedFileSuffix)) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Collect file only with rules, for your own good
	 *
	 * @return array
	 */
	protected function collect() {
		$rulesCollection = new Collection($this->validator->getRules());
		$filesCollection = new Collection();

		foreach ($this->request->allFiles() as $name => $file) {
			if ($rulesCollection->has($name)) {
				$filesCollection->put($name, $file);
			}
		}

		return $filesCollection->all();
	}

}
