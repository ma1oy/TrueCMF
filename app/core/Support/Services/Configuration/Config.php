<?php

namespace Truth\Support\Services\Configuration;

use InvalidArgumentException;
use Truth\Support\Services\FileSystem\FS;
use Truth\Support\Services\Repository\FileRepository;

class Config extends FileRepository
{
    /**
     * @param FS $fileSystem
     * @param string $filePath
     */
    public function __construct(FS &$fileSystem, $filePath) {
        parent::__construct($fileSystem, $filePath);
        $this->setLanguage($this->get('localization.language'));
        $this->setErrors($this->get('errors'));
    }

    /**
     * @param string $path
     * @return string
     *
     * @throws InvalidArgumentException
     */
    public function getDirectoryPath($path) {
        if (is_string($path)) {
            // TODO: directory separator to windows
            return $this->get('directories')[$path] . '/';
        } else {
            throw new InvalidArgumentException('exceptions.invalid_argument'); // TODO: Envisage
        }
    }

    /**
     * @param string $lang
     *
     * @throws InvalidArgumentException
     */
    public function setLanguage($lang) {
        if (is_string($lang)) {
            self::$box->make('Lang', [BASEDIR . $this->getDirectoryPath('languages'), $lang.'.php']); // TODO: Bad make
        } else {
            throw new InvalidArgumentException('exceptions.invalid_argument'); // TODO: Envisage
        }
    }

    /**
     * @param array $params
     *
     * @throws InvalidArgumentException
     */
    public function setErrors($params) {
        if (is_array($params)) {
            if (isset($params['display'])) {
                ini_set('display_errors', $params['display']);
                ini_set('display_startup_errors', $params['display']);
            }
            if (isset($params['reporting'])) {
                error_reporting($params['reporting']);
            }
        } else {
            throw new InvalidArgumentException('exceptions.invalid_argument');  // TODO: Envisage
        }
    }

    public function getCurrentThemeName() {
        return $this->get('site')['theme'];
    }

    public function getCurrentThemePath() {
        return $this->getDirectoryPath('themes') . '/' . $this->getCurrentThemeName();
    }
}
