<?
require_once __DIR__.'/XArray.php';
$obj = new XArray();

$a = array(
    array(
        'name'=>'fuck',
        'surname'=>'demon'
    ),
    array(
        'name'=>'mary',
        'surname'=>'john'
    )
);
var_dump($obj->remap($a,array('name'=>'suka','surname'=>'balbal')));