<?php

class Catalog
{
    private $folder;

    public function __construct($folder)
    {
        if ($folder == '' || $folder == '/') {
            $this->folder = PATH_DEFAULT;
        } else {
            $this->folder = $folder;
        }
    }

    /**
     * получение вложенного массива
     * @return array
     */
    function getList()
    {
        $dir = new DirectoryIterator($this->folder);
        $arr = [];
        foreach ($dir as $item) {
            $fileName = $item->getFilename();
            $fileType = $item->getType();
            if ($fileName == '..' || $fileName == '.') {
                continue;
            }
            $elem['name'] = $fileName;
            $elem['type'] = $fileType;
            if ($fileType == 'dir') {
                $path = $this->folder . $fileName . '/';
                $elem['list'] = (new Catalog($path))->getList();
            } else {
                $elem['size'] = $item->getSize();
                $elem['ext'] = $item->getExtension();
            }
            $arr[] = $elem;
        }
        return $arr;
    }

    /**
     * получение древовидного html-кода
     * @param string $htmlText
     * @return string
     */
    function getHTMLText($htmlText = '')
    {
        $dir = new DirectoryIterator($this->folder);
        $htmlText .= '<ul>';
        foreach ($dir as $item) {
            $fileName = $item->getFilename();
            $fileType = $item->getType();
            if ($fileName == '..' || $fileName == '.') {
                continue;
            }
            $htmlText .= '<li>' . $fileName . '</li>';
            if ($fileType == 'dir') {
                $path = $this->folder . $fileName . '/';
                $htmlText = (new Catalog($path))->getHTMLText($htmlText);
            }
        }
        $htmlText .= '</ul>';
        return $htmlText;
    }

    /**
     * сортировка: сначала папки, потом файлы
     */
    function sortDefault($arr)
    {
        $folders = [];
        $files = [];
        foreach ($arr as $item) {
            if ($item['type'] == 'dir') {
                $folders[] = $item;
            } else {
                $files[] = $item;
            }
        }
        return array_merge($folders, $files);
    }

    /**
     * получение содержимого папки
     * @return array
     */
    function explore()
    {
        $dir = new DirectoryIterator($this->folder);
        $arr = [];
        foreach ($dir as $item) {
            $fileName = $item->getFilename();
            $fileType = $item->getType();
            if ($fileName == '..' || $fileName == '.') {
                continue;
            }

            $elem['name'] = $fileName;
            $elem['type'] = $fileType;
            if ($fileType != 'dir') {
                $elem['size'] = $item->getSize();
                $elem['ext'] = $item->getExtension();
                switch ($elem['ext']) {
                    case 'jpg':
                    case 'png':
                        $elem['pic'] = mb_substr($this->folder,
                                mb_strlen(PATH_ROOT) + 1,
                                mb_strlen($this->folder) - mb_strlen(PATH_ROOT) - 1) .
                            '/' . $fileName;;
                        break;
                    default:
                        $elem['pic'] = IMAGES_DIR . 'text.png';
                }
            } else {
                $elem['pic'] = IMAGES_DIR . 'folder.png';
            }
            $arr[] = $elem;
        }
        return $this->sortDefault($arr);
    }

}