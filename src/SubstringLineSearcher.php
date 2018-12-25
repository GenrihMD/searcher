<?php
namespace Awork\Searcher;
use Symfony\Component\Yaml\Yaml;
class SubstringLineSearcher 
{
    public $config = array();
    public $fileSize;
    public $fileResource;
    public $fileContent;
    public $fileContentLinesSartPosition = array();

    public function __construct($configFileName = "config.yml")
    {
        $configFile = dirname(__FILE__) . "/" . $configFileName;
        $this->loadConfig($configFile);
        $this->resetFileParams();
    }

    public function resetFileParams() {
        $this->fileResource = NULL;
        $this->fileSize = 0;
        $this->fileContent = '';
    }

    public function loadConfig($configFile) {
        if (file_exists($configFile)) {
            $yamlContent = file_get_contents($configFile);
            $config = Yaml::parse($yamlContent);
            $this->setConfig($config);
         } else {
            throw new \Exception('Config file is not exist.');
         }
    }

    public function setConfig($config) {
        $this->config = $config;
    }

    public function openFile($fileName) {
        if ($this->checkFile($fileName)) {
            $this->closeFile();
            $this->fileResource = fopen($fileName, "r");
            $this->fileSize = filesize($fileName);
        } else {
            throw new \Exception('Bad file!');
        }
    }

    public function checkFile($fileName) {        
        if (is_readable($fileName)) {
            $fileType = mime_content_type($fileName);
            $testFileSize = filesize($fileName) <= $this->config['max_size'];
            $testFileType = in_array($fileType, $this->config['file_type']);
            return $testFileSize && $testFileType;
        }
        throw new \Exception('File not exist!');
    }

    public function closeFile() {
        if ($this->fileResource != NULL) {
            fclose($this->fileResource);
            $this->resetFileParams();
        }
    }

    public function readFile() {
        if ($this->fileResource != NULL) {
            $this->fileContent = fread($this->fileResource, $this->fileSize);
        } else {
            throw new \Exception('No file opened!');
        }
    }

    public function find($string) {
        if (ftell($this->fileResource) <= 0) {
            $this->readFile();
        }

        $offset = 0;
        $findResult = array();
        $stringLength = strlen($string);
        $fileContentLenght = strlen($this->fileContent);
        $lineCount = 1;
        $prevPosition = 0;

        while ($offset <= $fileContentLenght) {
            $substringPosition = strpos($this->fileContent, $string, $offset);
            if (!!$substringPosition) {

                $contentChunk = substr($this->fileContent, $offset, $substringPosition - $offset);
                $lineOfSubstring = substr_count($this->fileContent, PHP_EOL , 0, $substringPosition) + 1;
                $inlinePosution = strlen($contentChunk) - strrpos($contentChunk, PHP_EOL);

                $offset = $substringPosition + 1;
                $findResult[] = array(
                    'line_number' => $lineOfSubstring,
                    'inline_position' => $inlinePosution
                );
            } else {
                break;
            }
        }
        return $findResult;
    }

    public function __destroy() {
        $this->closeFile();
    }

}