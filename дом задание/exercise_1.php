<?php

//Clojure table.

/**
 * Class Categories
 */
class Categories
{
    private $config = [
        'host' => 'localhost:3307',
        'user' => 'root',
        'pass' => '',
        'db' => 'closure_table'
    ];
    private $connect;
    private $parent_ids;
    private $child_ids;
    public $tree;
    private $root_id;

    public function __construct()
    {
        $this->connect = mysqli_connect(
            $this->config['host'],
            $this->config['user'],
            $this->config['pass'],
            $this->config['db']
        );
        $ids = $this->getParentChildIds();
        $this->parent_ids = $ids['parent_ids'];
        $this->child_ids = $ids['child_ids'];
        $this->root_id = $this->getRootId();
        $this->categories = $this->getNamesCategories();
        $this->tree = $this->getTree();
    }

    /**
     * получение родительских, дочерних id
     * @return array массив, состоящий из родительских и дочерних id
     */
    public function getParentChildIds()
    {
        $parent_ids = [];
        $child_ids = [];
        $query = "SELECT * FROM categories_links";
        $result = mysqli_query($this->connect, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $parent_id = $row['parent_id'];
            $child_id = $row['child_id'];
            if (!in_array($parent_id, $parent_ids)) {
                $parent_ids[] = $parent_id;
            }
            if (!in_array($child_id, $child_ids) && $parent_id != $child_id) {
                $child_ids[] = $child_id;
            }
        }
        return [
            'parent_ids' => $parent_ids,
            'child_ids' => $child_ids
        ];
    }

    /**
     * получение имен категорий
     * @return array
     */
    public function getNamesCategories()
    {
        $categories = [];
        $query = "SELECT * FROM categories";
        $result = mysqli_query($this->connect, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[$row['id']] = $row['name'];
        }
        return $categories;
    }

    /**
     * получить корневой id
     * @return null
     */
    public function getRootId()
    {
        foreach ($this->parent_ids as $parent_id) {
            if (!in_array($parent_id, $this->child_ids)) {
                return $parent_id;
            };
            return null;
        }
    }

    /**
     * получить связи (дочерние id) по узловому id
     * @param $parent_id
     * @return array|null
     */
    public function getLinksFromParent($parent_id)
    {
        if (!in_array($parent_id, array_merge($this->parent_ids, $this->child_ids))) {
            return null;
        }
        $arr = [];
        $query = "SELECT * FROM categories_links WHERE parent_id = $parent_id";
        $result = mysqli_query($this->connect, $query);
        if (!$result->num_rows) {
            return [];
        }
        while ($row = mysqli_fetch_assoc($result)) {
            $child_id = $row['child_id'];
            $child_ids[] = $child_id;
            if ($child_id == $parent_id) {
                continue;
            }
            $arr[] = $child_id;
        }
        return $arr;
    }

    /**
     * получить дерево категорий
     * @return array
     */
    public function getTree()
    {
        $knot = [
            $this->root_id
        ];
        $this->fillKnot($knot, $this->root_id);

        return $knot;
    }

    /**
     * заполнить узел дерева категорий
     * @param $knot
     * @param $pivot_id
     * @return mixed
     */
    public function fillKnot(&$knot, $pivot_id)
    {
        foreach ($knot as $key => $item) {
            if (is_numeric($item)) {
                unset($knot[$key]);
                $links = $this->getLinksFromParent($item);
                $knot[$item] = $links;
                $knot[$item]['name'] = $this->categories[$item];
                if (!empty($links)) {
                    foreach ($knot[$item] as $value) {
                        $this->fillKnot($knot[$item], $value);
                    }
                }
            }
        }
        return $knot;
    }

    /**
     * получить html - код для отображения дерева категорий
     * @return string
     */
    public function htmlTree()
    {
        $html = '';
        $this->htmlKnot($html, $this->tree);
        return $html;
    }

    /**
     * получить html - код для отображения узла дерева категорий
     * @param $html
     * @param $knot
     * @return mixed
     */
    public function htmlKnot(&$html, &$knot, $str = '', $key = null)
    {
        if (is_array($knot)) {
            if (!is_null($key)) {
                $html .= "<details><summary><span class='menu_list'>{$str}{$knot['name']}</span></summary>";
                $str .= '--';
            }
            foreach ($knot as $key => $item) {
                if ($key != 'name') {
                    $this->htmlKnot($html, $item, $str, $key);
                }
            }
            if (!is_null($key)) {
                $html .= '</details>';
            }
        }
        return $knot;
    }
}

echo 'Задание 1<hr>';
?>
<style>
    /*details summary::-webkit-details-marker {*/
        /*display: none;*/
    /*}*/
    /*details summary:before {*/
        /*content: " + ";*/
    /*}*/
    /*details[open] summary:before {*/
        /*content: " - ";*/
    /*}*/
</style>
<div id="menu">
    <?= (new Categories())->htmlTree(); ?>
</div>
