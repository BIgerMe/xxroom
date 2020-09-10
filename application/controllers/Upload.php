<?php
/**
 * Created by PhpStorm.
 * User: 22608
 * Date: 2018/5/29
 * Time: 16:53
 */
class Upload extends Yl_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('attachment_model');
    }

    /*public function index()
    {
        $this->_view('upload_form');
    }*/
    /*create by zhangxiaoming*/
    /*public function selfUpload()
    {
        $name = key($_FILES);   //对应前端name值
        $file = $_FILES;

        if($file){
            //多文件上传
            if($file && is_array($file[$name]['tmp_name'])){

            }else{
                //单文件上传
                $path = date('Y/m/');
                $dir = FCPATH .'uploads/image/'. $path;
                $this->mkdirs($path);

                if($file[$name]['error'] != 0){
                    $this->json_out(0,'上传失败');
                }else{
                    $ext = str_replace('image/','',$_FILES[$name]['type']);
                    !in_array($ext,['bmp','jpg','png','jpeg','gif']) && $this->json_out(0,'必须为图片格式');
                    do {
                        $filename = $this->random(30) . '.' . $ext;
                    } while (file_exists($dir . $filename));
                    move_uploaded_file($_FILES[$name]["tmp_name"],$dir.$filename);
                    $data = [
                        'path'=>'/uploads/image/'.$path.$filename,
                        'name'=>$filename,
                        'size'=>round($file[$name]['size'] / 100)
                    ];
                }
                $this->attachment_model->commit($data);
                if($this->is_ajax()){
                    $this->json_out(1,'上传成功',['url'=>HOME_HOST.'/uploads/image'.$path.$filename]);
                }else{
                    $this->redirect('pic');
                }
            }
        }else{
            $this->json_out(0,'发生错误');
        }
    }*/

    /*图库*/
    public function pic(){

        $square = $this->attachment_model->getAllSquare();  //方
        $rectangle = $this->attachment_model->getAllRectangle();//横
        $vertical = $this->attachment_model->getAllVertical();//竖
        foreach ($square as &$s){
            $s['url'] = $this->tomedia($s['path']);
        }
        foreach ($rectangle as &$r){
            $r['url'] = $this->tomedia($r['path']);
        }
        foreach ($vertical as &$v){
            $v['url'] = $this->tomedia($v['path']);
        }

        $this->_vd['square'] = $square;
        $this->_vd['rectangle'] = $rectangle;
        $this->_vd['vertical'] = $vertical;

        $this->_view('pic');
    }

    /*图片新增*/
    public function add(){
        $path = $this->_post['path'];
        $exist = $this->db->where(['path'=>$path])->get('attachment')->result_array();
        if(!$path || $exist)
            $this->json_out(0,'图片不存在');

        $image_content = file_get_contents($path);
        $image = imagecreatefromstring($image_content);
        $width = imagesx($image);
        $height = imagesy($image);
        $size = $width * $height;
        if(!$size){
            $this->json_out(0,'图片不存在');
        }
        //比例 0是偏正方形 1是偏0.5625横矩  2偏竖距
        $prop  = ($height / $width < 0.7 ) ? 1 : (($height/$width)>1.1 ? 2 : 0) ;

        $data = [
            'path'=>$path,
            'size'=>$size,
            'proportion'=>$prop
        ];
        $this->attachment_model->commit($data);
        $this->json_out(1,'录入成功');
    }

    /*下载图片*/
    public function download_pic(){

        $url = $this->_get['url'];
        file_put_contents('save_img/dimg1.png', $url);
        $file = 'save_img/dimg1.png';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $file_content = curl_exec($ch);
        curl_close($ch);
        $downloaded_file = fopen($file, 'w');
        fwrite($downloaded_file, $file_content);
        fclose($downloaded_file);

        header("content-type:text/html;charset=utf-8");
        header("Content-type: octet/stream");
        header("Content-disposition:attachment;filename=dimg.png;");
        header("Content-Length:".filesize($file));
        readfile($file);
        exit;
    }

    /*新建文件夹*/
    function mkdirs($path) {
        $path = explode('/',$path);
        $np = FCPATH.'uploads/image/';
        foreach ($path as $p){
            $np .= '/'.$p;
            if(!is_dir($np)){
                mkdir($np);
            }
        }
        return is_dir($np);
    }
}
