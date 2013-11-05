<?php
namespace Ideal\Structure\Roster\Admin;

use Ideal\Core\Db;

/**
 * Класс для работы со списками
 *
 */

class ModelAbstract extends \Ideal\Core\Admin\Model
{

    public function detectPageByIds($path, $par)
    {
        $this->path = $path;
        $first = array_shift($par);
        if ($first != null) {
            $first = intval($first);
            $_sql = "SELECT * FROM {$this->_table} WHERE ID={$first}";
            $db = Db::getInstance();
            $localPath = $db->queryArray($_sql);
            if (!isset($localPath[0]['ID'])) {
                $this->is404 = true;
                return $this;
            }
            array_push($this->path, $localPath[0]);
        }
        return $this;
    }


    public function delete()
    {
        $db = Db::getInstance();
        $db->delete($this->_table, $this->pageData['ID']);

        if(isset($this->pageData['pos'])) {
            // Если есть сортировка pos, то нужно уменьшить все следующие за удаляемым
            // элементы на единицу
            $_sql = "UPDATE {$this->_table} SET pos = pos - 1
                        WHERE prev_structure = '{$this->prevStructure}'
                              AND pos > {$this->pageData['pos']}";
            $db->query($_sql);
        }
        // TODO сделать проверку успешности удаления
        return 1;
    }


    public function getNewPos()
    {
        /* @var Db $db */
        $db = Db::getInstance();

        $_sql = "SELECT pos FROM {$this->_table} WHERE prev_structure='{$this->prevStructure}' ORDER BY pos DESC LIMIT 1";
        $posArr = $db->queryArray($_sql);

        $pos = 0;
        if (count($posArr) > 0) {
            // Если элементы на этом уровне есть, берём cid последнего
            $pos = $posArr[0]['pos'];
        }

        // Прибавляем единицу в pos
        return $pos + 1;

    }

}
