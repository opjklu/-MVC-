<?php
namespace MyMVC;

/**
 * 模型类 
 * @author 王强
 */
 
class Model 
{
    
    
    
    /**
     *插入数据
     */
    public function create(array $array = null, array $not_key = null, $is_check_number = FALSE, $is_validate_token = FALSE)
    {
        $data = empty($array) ? $_POST : $array;
         
        //是否验证表单令牌
        if ($is_validate_token === true && ($validate = ecjia::config('is_validate_token')))
        {
            if (empty($data['validate']) || $data['validate'] !== $validate)
                return null;
        }
        //检测数据
        if(!isCheckData($data, $not_key, $is_check_number)) return null;
         
        //判断是更新还是插入 的标记变量
        $flag = 0;
        //对比字段
        foreach ($data as $key => $value)
        {
            if (!in_array($key, $this->db->fields))
            {
                unset($data[$key]);
            }
            //判断是更新还是插入
            if ($this->db->primary === $key)
            {
                $flag = 1;
            }
        }
        if ($flag === 0 && !empty($data[$this->primary]))//插入
        {
            unset($data[$this->primary]);
        }
        //字段类型验证
         
        //首先获取所有字段类型
        $fields_type = $this->query('select COLUMN_TYPE,COLUMN_NAME from information_schema.COLUMNS where table_name = "'.$this->table_name.'" and table_schema = "'.$this->db_config[$this->db_setting]['database'].'"');
        if (!empty($fields_type))
        {
            foreach ($fields_type as $key => $value)
            {
                if (!array_key_exists($value['COLUMN_NAME'], $data))
                {
                    unset($fields_type[$key]['COLUMN_NAME']);
                    unset($fields_type[$key]['COLUMN_TYPE']);
                }
                elseif (0 === strpos($value['COLUMN_TYPE'], 'int') || strpos($value['COLUMN_TYPE'], 'int'))
                {
                    $data_colum[$value['COLUMN_NAME']] = 'integer';
                }
                else if (0 === strpos($value['COLUMN_TYPE'], 'varchar') || strpos($value['COLUMN_TYPE'], 'date') || 0 === strpos($value['COLUMN_TYPE'], 'text')) //.....以后在完善
                {
                    $data_colum[$value['COLUMN_NAME']] = 'string';
                }
                else
                {
        	           $data_colum[$value['COLUMN_NAME']] = $value['COLUMN_TYPE'];
                }
            }
            if (empty($data_colum))
            {
                return null;
            }
            //比较类型
            foreach ($data_colum as $type_key => $type_value)
            {
                if (gettype($data[$type_key]) != $type_value)
                {
                    $data[$type_key] = eval('('.$type_value.')$data[$type_key];');
                }
            }
            return $data;
        }
        else
        {
            return null;
        }
    }
    
}
 