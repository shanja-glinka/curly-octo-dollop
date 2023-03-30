<?

namespace System\Utils;

class Files
{
    public static function isWritable_r($dir)
    {
        if (is_dir($dir)) {
            if (is_writable($dir)) {
                $objects = scandir($dir);
                foreach ($objects as $object) {
                    if ($object != '.' && $object != '..') {
                        if (!\System\Utils\Files::isWritable_r($dir . "/" . $object)) return false;
                        else continue;
                    }
                }
                return true;
            } else {
                return false;
            }
        } else if (file_exists($dir)) {
            return (is_writable($dir));
        }
    }

    public static function fileRewrite($filePath, $content)
    {
        $fp = fopen($filePath, 'w+');
        fwrite($fp, $content);
        fclose($fp);
        chmod($filePath, 0777);
        clearstatcache();
    }

    public static function getFileContent($filePath)
    {
        if (!file_exists($filePath)) 
            throw new \Exception("File '$filePath' is not found", 404);

        return file_get_contents($filePath);
    }

    public static function getFilesDirectory($fileDir)
    {
        if (!file_exists($fileDir)) 
            throw new \Exception("Directory '$fileDir' is not found", 404);
            
        return array_diff(scandir($fileDir), array('.', '..'));
    }
}
