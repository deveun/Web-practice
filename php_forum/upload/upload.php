<?

$MAXLIMIT = 10*1024*1024; // 10MByte
if($_FILES['upload']['size'] > $MAXLIMIT) {
    echo "<script>alert('이미지 용량이 큽니다.');</script>";
}
else {
    $file = $_FILES['upload'];
    $name = preg_replace("/\.(php|phtm|htm|cgi|pl|jsp|asp|inc)/i", "$0-x", $file['name']);
    $name = Date('YmdHis').'_'.str_replace('%', '', urlencode($name));
    $ATTACH_DIR = "./";
    $dest_file  = $ATTACH_DIR.$name;
    $url = $ATTACH_DIR.$name;
    if(!is_dir($ATTACH_DIR)) {
        if(@mkdir($ATTACH_DIR, 0777, true)) {
            if(is_dir($ATTACH_DIR)) {
                @chmod($ATTACH_DIR, 0777);
            }
        }
    }
    if(move_uploaded_file($file['tmp_name'], $dest_file)) {
        echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction('".$_GET['CKEditorFuncNum']."', '".$url."', 'success')</script>";
    }
    else {
        echo "<script>alert('failed')</script>";
    }
}
?>
