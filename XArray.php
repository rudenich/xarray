<?
if(!function_exists('array_column')){
    require_once dirname(__FILE__).'/array_column.php';
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
}