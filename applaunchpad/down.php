<?php
$path=$_SERVER['DOCUMENT_ROOT']."/applaunchpad/saved/";
$fullpath=$path.$_GET['name'];
if($fd=fopen($fullpath,'r'))
{
    $fsize=filesize($fullpath);
    $path_parts=pathinfo($fullpath);
    $ext=strtolower($path_parts["extension"]);
    switch($ext)
    {
        case "png":
        header("content-type:application/image");
        header("content-disposition:attachment;filename=".$path_parts["basename"]);
        break;
        
        case "jpg":
        header("content-type:application/image");
        header("content-disposition:attachment;filename=".$path_parts["basename"]);
        break;
        
        default:
        header("content-type:application/octed-stream");
        header("content-disposition:attachment;filename=".$path_parts["basename"]);
        break;
    }
    header("content-length:$fsize");
    header("cache-control:private");    
    while(!feof($fd))
    {
        $buffer=fread($fd,1048);
        echo $buffer;
    }    
        
}
exit;
?>