<?php

namespace Tysdever\EloquentAttachment\Traits;

use EloquentAttachment;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Http\Exception\HttpResponseException;
use Tysdever\EloquentAttachment\Filesystem\UploadedFile;

trait FormFileRequestPopulate {

	private static $uploaded_file_suffix = '_path';

	/**
	 * Validate the class instance.
	 *
	 * @return void
	 */
	public function validate() {
		$instance = $this->getValidatorInstance();
		$attachment = $this->getAttachmentValidatorInstance();

		EloquentAttachment::setValidatorInstance($attachment);
		EloquentAttachment::setRequestInstance($this);

		$errors = [];

		if (!$instance->passes()) {
			$errors = $this->formatErrors($instance);
		}

		if ($attachment->passes()) {
			EloquentAttachment::upload();
		} else {
			if (!EloquentAttachment::isUploaded()) {
				$errors = array_merge($errors, $this->formatErrors($attachment));
			}
		}

		if ((bool) $errors) {
			throw new HttpResponseException($this->response(
				$errors
			));
		}
	}

	public function getAttachmentValidatorInstance() {
		$factory = $this->container->make(ValidationFactory::class);

		if (method_exists($this, 'validator')) {
			return $this->container->call([$this, 'validator'], compact('factory'));
		}


		return $factory->make(
			$this->allFiles(), $this->container->call([$this, 'attachmentRules']), $this->messages(), $this->attributes()
		);
	}

	/**
	 * Convert the given array of Symfony UploadedFiles to custom Laravel UploadedFiles.
	 *
	 * @param  array  $files
	 * @return array
	 */
	public function convertUploadedFiles(array $files) {
		return array_map(function ($file) {
			if (is_null($file) || (is_array($file) && empty(array_filter($file)))) {
				return $file;
			}

			return is_array($file)
			? $this->convertUploadedFiles($file)
			: UploadedFile::createFromBase($file);
		}, $files);
	}

}
