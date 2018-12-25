<?php
/**
 * Created by PhpStorm.
 * User: Rober
 * Date: 2017/10/29
 * Time: 13:10
 */

namespace App\extensions;

class Tree
{
    static public $treeList = array();  //无限级分类结果列表
    static public $str = '';

    public function createTree( $data, $field_id='id', $field_pid='pid', $field_name='name', $pid=0 )
    {
        //echo '1进入函数<br>';
        foreach ($data as $key=>$row)
        {
            //echo '2当前id为：'.$row->id.'当前的pid为：'.$row->$field_pid."当前传入的pid为：'.$pid.'<br>";
            if ($row->$field_pid==$pid)
            {
                //echo '3pid相等<br>';
                if ($pid!=0)
                {
                    //echo '4pid不为0<br>';
                    self::$str .= "&nbsp;&nbsp;&nbsp;&nbsp;";
                    $row['_'.$field_name] = self::$str.'|--'.$row->$field_name;
                }
                else
                {
                    //echo '5pis为0<br>';
                    $row['_'.$field_name] = $row->$field_name;
                }

                self::$treeList[] = $row;
                unset($data[$key]);

                self::createTree($data, $field_id, $field_pid, $field_name, $row->$field_id);
                //echo '6递归后<br>';
            }
        }
        //echo '把str置空<br>';
        self::$str = '';

        return self::$treeList;
    }

}