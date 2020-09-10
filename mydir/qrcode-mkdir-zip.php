<?php
//二维码生成
include_once('./application/libraries/phpqrcode.php');
$url ='https://www.xxroom.xyz/blogshow';
$fileName  = base64_encode($url);
$file = './uploads/'.$fileName.'.png';
QRcode::png($url,$file,QR_ECLEVEL_H,4);


//新建文件夹
function mkdirs($path) {
    if (!is_dir($path)) {
        mkdirs(dirname($path));
        mkdir($path);
    }
    return is_dir($path);
}

//zip打包下载
function downloadZip(){
    $list = [
        ['img_url'=>'https://www.wailian.work/images/2018/10/15/_20181015110619.png','name'=>'firstfile'],
        ['img_url'=>'https://www.wailian.work/images/2018/10/15/_20181015112611.png','name'=>'secondfile'],
    ];
    //批量下载
    $tmpFile = tempnam('/tmp', 'tmp');
    $zip = new ZipArchive;
    $zip->open($tmpFile, ZipArchive::CREATE);
    foreach ($list as $k=>&$v) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch,CURLOPT_URL,$v['img_url']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $fileContent = curl_exec($ch);
        curl_close($ch);

        //string iconv ( string $in_charset , string $out_charset , string $str )  注：将字符串 str 从 in_charset 转换编码到 out_charset。
        $zip->addFromString(iconv('utf-8', 'gbk', $v['name'].'.png'), $fileContent);
    }

    $zip->close();

    header('Content-Type: application/zip');
    header('Content-disposition: attachment; filename=test.zip');
    header('Content-Length: ' . filesize($tmpFile));
    readfile($tmpFile);

    unlink($tmpFile);

}

//downloadQr();