<?php

// Nested sets..

/**
 * Class NestedSets
 */
class NestedSets
{
    private $config = [
        'host' => 'localhost:3307',
        'user' => 'root',
        'pass' => '',
        'db' => 'nested_sets'
    ];
    private $connect;

    public function __construct()
    {
        $this->connect = mysqli_connect(
            $this->config['host'],
            $this->config['user'],
            $this->config['pass'],
            $this->config['db']
        );
    }

    /**
     * прочитать таблицу из базы данных
     * @return array
     */
    public function read_db()
    {
        $table = [];
        $query = "SELECT * FROM sets_table";
        $result = mysqli_query($this->connect, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $table[] = $row;
        }
        return $table;
    }

    /**
     * получить значения "крайних" ключей: минимальный левый и максимальный правый
     * @return array
     */
    public function getEdgeKeys()
    {
        $query['left'] = "SELECT min(left_key) FROM sets_table";
        $query['right'] = "SELECT max(right_key) FROM sets_table";
        $result['left'] = mysqli_query($this->connect, $query['left']);
        $result['right'] = mysqli_query($this->connect, $query['right']);
        $left_key_min = mysqli_fetch_assoc($result['left'])['min(left_key)'];
        $right_key_max = mysqli_fetch_assoc($result['right'])['max(right_key)'];
        return [
            'left_key_min' => $left_key_min,
            'right_key_max' => $right_key_max
        ];
    }

    /**
     * получить значения всех ключей
     * @return array
     */
    public function getKeys()
    {
        $left_keys = [];
        $right_keys = [];
        $query = "SELECT * FROM sets_table";
        $result = mysqli_query($this->connect, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $left_keys[] = $row['left_key'];
            $right_keys[] = $row['right_key'];
        }
        return [
            'left_keys' => $left_keys,
            'right_keys' => $right_keys
        ];
    }

    /**
     * получить данные из базы данных по значению левого ключа
     * @param $left_key
     * @return array|null
     */
    public function getNoteFromLeftKey($left_key)
    {
        $query = "SELECT * FROM sets_table WHERE left_key = $left_key";
        $result = mysqli_query($this->connect, $query);
        $row = mysqli_fetch_assoc($result);
        return $row;
    }

    /**
     * получить массив, элементы которого состоят из ключа и его обозначения (left/right)
     * @return array
     */
    public function getStringNumbers()
    {
        $arr = [];
        $lks = (new NestedSets())->getKeys()['left_keys'];
        $rks = (new NestedSets())->getKeys()['right_keys'];
        foreach ($lks as $item) {
            $arr[] = ['num' => $item, 'key' => 'left'];
        }
        foreach ($rks as $item) {
            $arr[] = ['num' => $item, 'key' => 'right'];
        }
        sort($arr);
        return $arr;
    }

    /**
     * поулчить массив, элемент которого - пара из левого и правого ключей
     * @return array
     */
    public function getCoupleParentChild()
    {
        $arr = [];
        $current = [];
        $num_keys = $this->getStringNumbers();
        foreach ($num_keys as $key => $item) {
            if ($item['key'] == 'left') {
                $current[] = (int)$item['num'];
                if (count($current) == 1) {
                    continue;
                }
                $arr[] = [
                    'parent' => $current[count($current) - 2],
                    'child' => $current[count($current) - 1]
                ];
            }
            if ($item['key'] == 'right') {
                array_pop($current);
            }
        }
        return $arr;
    }

    /**
     * получить дерево категорий/элементов
     * @return array
     */
    public function getTree()
    {
        $pongs = [];
        $arr = $this->getStringNumbers();
        $ret = [];
        foreach ($arr as $item) {
            if ($item['key'] == 'left') {
                $pongs[] = $item['num'];
            } elseif ($item['key'] == 'right') {
                $this->addBranch($ret, $pongs);

                array_pop($pongs);
            }
        }
        return $ret;
    }

    /**
     * добавить ветки для дерева из массива
     * @param $knot array - узел (дерево)
     * @param $arr array - массив
     * @return $knot array - результат-узел (дерево)
     */
    public function addBranch(&$knot, $arr)
    {
        $this->fillKnot($knot, $arr, 0);
        return $knot;
    }

    /**
     * добавить данные массива в узел
     * @param $knot array узел (дерево)
     * @param $arr array массив
     * @param $i int ключ/индекс
     * @return $knot array узел (дерево)
     */
    public function fillKnot(&$knot, &$arr, $i)
    {
        if ($i == count($arr)) {
            return $knot;
        }
        $elem = $this->getNoteFromLeftKey($arr[$i]);
        $knot[$elem['id']]['name'] = $elem['name'];

        $this->fillKnot($knot[$elem['id']], $arr, $i + 1);
    }

    /**
     * получить html-код для отображения дерева
     * @return string
     */
    public function getHTML()
    {
        $html = '';
        $html .= '<ul>';
        $this->getHTML_knot($this->getTree()[1], $html);
        $html .= '</ul>';
        return $html;
    }

    /**
     * получить часть html-кода, относящуюся к узлу
     * @param $tree
     * @param $html
     */
    public function getHTML_knot(&$tree, &$html)
    {
        $html .= '<li>';
        foreach ($tree as $key => $elem) {
            if ($key == 'name') {
                $html .= $elem;
            } else {
                $html .= '<ul>';
                $this->getHTML_knot($elem, $html);
                $html .= '</ul>';
            }
        }
        $html .= '</li>';
    }
}
//-------------------------
echo 'Задание 3 <hr>';

echo (new NestedSets())->getHTML();

