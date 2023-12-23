<?php

declare(strict_types=1);

ini_set("display_errors", 1);
class LocalStash
{

    private string $cachePath;
    private const LOCAL_STORAGE = "localStorage";
    private string $currentCache;
    private string $filePath;
    private const FILE_404 = "file not found";
    private const FILE_EXT = '.json';


    public function __construct(string $currentCache = null, string $cachePath = null)
    {
        $this->cachePath = $cachePath ?? __DIR__ . '/../../cache/';
        $this->currentCache = $currentCache ?? LocalStash::LOCAL_STORAGE;
        $this->filePath = $this->cachePath . $this->currentCache . LocalStash::FILE_EXT;
    }

    public function init(array $cacheNames)
    {
        $this->createLocalStorage();

        foreach ($cacheNames as $cacheName) {
            $this->createCacheFile($cacheName);
        }
        LocalStash::EDITFILE($this->cachePath.LocalStash::LOCAL_STORAGE. LocalStash::FILE_EXT,"caches",$cacheNames);
    }

    private function createCacheFile(string $cacheName)
    {
        $fileName = $cacheName  .  LocalStash::FILE_EXT;
        $filePath = $this->cachePath . $fileName;
        $fileHandle = fopen($filePath, "w");
        if ($fileHandle  === false) {
            die('Could not open file for writing');
        }
        fclose($fileHandle);
    }

    public function createLocalStorage()
    {
        if (!file_exists($this->cachePath . LocalStash::LOCAL_STORAGE)) {
            $this->createCacheFile(LocalStash::LOCAL_STORAGE);
        }
    }

    private static function EDITFILE(string $filePath, string $key, mixed $value)
    {
        if (file_exists($filePath)) {

            $jsonString = file_get_contents($filePath);
            $dataArray = json_decode($jsonString, true);
            $dataArray[$key] = $value;
            $newJsonString = json_encode($dataArray);

            $result = file_put_contents($filePath, $newJsonString);
            return $result !== false ? true : false;
        }
        print_r(LocalStash::FILE_404);
        return false;
    }

    public function set(string $key, mixed $value): bool
    {
        return LocalStash::EDITFILE($this->filePath, $key, $value);
    }


    public function get(string $key): mixed
    {
        if (file_exists($this->filePath)) {

            $jsonString = file_get_contents($this->filePath);
            $dataArray = json_decode($jsonString, true);
            return $dataArray[$key] ?? null;
        }
        print_r(LocalStash::FILE_404);
        return false;
    }

    public function delete(string $key): bool
    {
        $jsonString = file_get_contents($this->filePath);
        $dataArray = json_decode($jsonString, true);
        unset($dataArray[$key]);
        $newJsonString = json_encode($dataArray);

        $result = file_put_contents($this->filePath, $newJsonString);
        return $result !== false ? true : false;
    }

    public function exists(string $key): bool | null
    {
        if (file_exists($this->filePath)) {
            $jsonString = file_get_contents($this->filePath);
            $dataArray = json_decode($jsonString, true);
            return isset($dataArray[$key]) ? true : false;
        }
        print_r(LocalStash::FILE_404);
        return null;
    }

    public function clear(): bool | null
    {
        $newJsonString = json_encode(array());
        if (file_exists($this->filePath)) {
            $result = file_put_contents($this->filePath, $newJsonString);
            return $result !== false ? true : false;
        }
        return null;
    }

    public function clearAll()
    {
        $fileList = scandir($this->cachePath);

        foreach ($fileList as $file) {
            if ($file != "." && $file != "..") {
                $newJsonString = json_encode(array());

                $result = file_put_contents($this->cachePath . $file, $newJsonString);
                if ($result == false) {
                    print_r("error writing to the file.");
                    return false;
                }
            }
        }
        return true;
    }

    public function deleteCache()
    {
        if (file_exists($this->filePath)) {
            return unlink($this->filePath) ? true : false;
        }
        return false;
    }
}
