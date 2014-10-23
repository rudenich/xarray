<?
if(!function_exists('array_column')){
    if(!function_exists('array_column')){
        function array_column ($input, $columnKey, $indexKey = null) {
            if (!is_array($input)) {
                return false;
            }
            if ($indexKey === null) {
                foreach ($input as $i => &$in) {
                    if (is_array($in) && isset($in[$columnKey])) {
                        $in    = $in[$columnKey];
                    } else {
                        unset($input[$i]);
                    }
                }
            } else {
                $result    = array();
                foreach ($input as $i => $in) {
                    if (is_array($in) && isset($in[$columnKey])) {
                        if (isset($in[$indexKey])) {
                            $result[$in[$indexKey]]    = $in[$columnKey];
                        } else {
                            $result[]    = $in[$columnKey];
                        }
                        unset($input[$i]);
                    }
                }
                $input    = &$result;
            }
            return $input;
        }
    }
}

class XArray{
    /**
     *
     * @param $oldArray
     * @param $newArray
     * @return array
     */
    public function diff($oldArray,$newArray){
        $oldValues = array_diff($oldArray,$newArray);
        $newValues = array_diff($newArray,$oldArray);
        return array($oldValues,$newValues);
    }

    /**
     * This is mor abstarct method for array_diff that can calculate
     * diff on two multidimentional arrays by custom field
     * @param $array1
     * @param $array2
     * @param $column
     * @return array
     */
    public function diffByColumn($array1,$array2,$column){
        if($array1===array()){
            return array();
        }
        if($array2===array()){
            return $array1;
        }
        $array1_keys = array_column($array1,$column);
        $array2_keys = array_column($array2,$column);
        return array_diff_key(array_combine($array1_keys,$array1),array_combine($array2_keys,$array2));
    }

    /**
     * @param array $sourceArray array of associative array
     * @param array $mapArray associative array
     * @return array
     */

    public function remap($sourceArray,$mapArray=array()){
        $res = array();
        foreach($sourceArray as $item){
            $temp = array();
            foreach($mapArray as $source=>$target){
                $temp[$target] = isset($item[$source])?$item[$source]:null;
            }
            $res[] = $temp;
        }
        return $res;
    }

    /**
     * Merges two or more arrays into one recursively.
     * If each array has an element with the same string key value, the latter
     * will overwrite the former (different from array_merge_recursive).
     * Recursive merging will be conducted if both arrays have an element of array
     * type and are having the same key.
     * For integer-keyed elements, the elements from the latter array will
     * be appended to the former array.
     * @param array $a array to be merged to
     * @param array $b array to be merged from. You can specify additional
     * arrays via third argument, fourth argument etc.
     * @return array the merged array (the original arrays are not changed.)
     * @see mergeWith
     */
    public  function merge($a,$b)
    {
        $args=func_get_args();
        $res=array_shift($args);
        while(!empty($args))
        {
            $next=array_shift($args);
            foreach($next as $k => $v)
            {
                if(is_integer($k))
                    isset($res[$k]) ? $res[]=$v : $res[$k]=$v;
                elseif(is_array($v) && isset($res[$k]) && is_array($res[$k]))
                    $res[$k]=$this->merge($res[$k],$v);
                else
                    $res[$k]=$v;
            }
        }
        return $res;
    }
}