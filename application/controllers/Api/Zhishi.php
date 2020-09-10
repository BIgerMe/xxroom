<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/4 0004
 * Time: 下午 9:02
 */

class Zhishi extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Zhishi_model','Zhishi_mod');
        $this->load->model('Zhishi_category_model','Zhishi_category_mod');
    }

    /**知识点新增
     * @var int $user_id 用户ID
     * @var int $zs_category_id 分类ID
     * @var varchar $title 标题
     * @var text $content 内容
     * return json
    */
    public function zhishi_post()
    {
        $user_id = $this->post('user_id');
        $zs_category_id = $this->post('zs_category_id');
        $title = $this->post('title');
        $content = $this->post('content');
        if($user_id && $zs_category_id && $title && $content){
            $check_title = $this->Zhishi_mod->check_by_title($user_id,$title);
            $check_content = $this->Zhishi_mod->check_by_content($user_id,$content);
            if(!$check_title && !$check_content){
                $zhishi_data = array(
                    'user_id'=>$user_id,
                    'zs_category_id'=>$zs_category_id,
                    'title'=>$title,
                    'content'=>$content);
                if($id = $this->Zhishi_mod->commit($zhishi_data)){
                    $this->send_response(REST_Controller::HTTP_OK,'新增成功',$id);
                }
            }else{
                $msg = $check_title ? '标题重复' : ($check_content ? '内容重复' : '');
            }
        }else{
            $msg = !$user_id ? '用户为空' : (!$zs_category_id ? '分类为空' : (!$title ? '标题为空' : (!$content ? '内容为空' : '')));
        }
        $this->send_response(REST_Controller::HTTP_NOT_IMPLEMENTED,$msg,FALSE);
    }

    /**知识点查询
     * @var int $id
     * @var int $user_id
    */
    public function zhishi_get()
    {
        $id = $this->get('id');
        $user_id = $this->get('user_id');
        if($zhishi_data = $this->Zhishi_mod->get_list($id,$user_id)){
            $this->send_response(REST_Controller::HTTP_OK,'查询成功',$zhishi_data);
        }
        $this->send_response(REST_Controller::HTTP_NOT_IMPLEMENTED,'查询失败',false);
    }

    /**知识点更新
     * @var int $id
     * @var int $user_id 用户ID
     * @var int $zs_category_id 分类ID
     * @var varchar $title 标题
     * @var text $content 内容
     * return json
    */
    public function zhishi_put()
    {
        $id = $this->put('id') ?? '';
        $user_id = $this->put('user_id') ?? '';
        $zs_category_id = $this->put('zs_category_id') ?? '';
        $title = $this->put('title') ?? '';
        $content = $this->put('content') ?? '';
        if($id && $user_id && $zs_category_id && $title && $content){
            $zhishi_data = array('id'=>$id,
                'user_id'=>$user_id,
                'zs_category_id'=>$zs_category_id,
                'title'=>$title,
                'content'=>$content);
            if($this->Zhishi_mod->commit($zhishi_data)){
                $msg = '提交成功';
                $this->send_response(REST_Controller::HTTP_OK,$msg,true);
            }else{
                $msg = '提交失败';
            }
        }else{
            $msg = '条件不足';
        }
        $this->send_response(REST_Controller::HTTP_NOT_IMPLEMENTED,$msg,false);
    }

    /**知识点删除
     * @var int $id 知识点ID
     * return json
    */
    public function zhishi_delete()
    {
        $id = $this->query('id') ?? '';

        if($zhishi_data = $this->Zhishi_mod->delete(array('id'=>$id)))
        {
            $this->send_response(REST_Controller::HTTP_OK,'删除成功',$zhishi_data);
        }
        $this->send_response(REST_Controller::HTTP_NOT_FOUND,'删除失败',FALSE);
    }


    /**新增分类
     * @var varchar $title
     * @var int $parent_id
     * return json
    */
    public function category_post()
    {
        $title = $this->post('title') ?? '';
        $parent_id = $this->post('parent_id') ?? '';
        if($title && ($parent_id || $parent_id == 0)){
            $category_data = array('title'=>$title,'parent_id'=>$parent_id);
            if($id = $this->Zhishi_category_mod->commit($category_data)){
                $this->send_response(REST_Controller::HTTP_OK,'添加成功',$id);
            }
        }
        $this->send_response(REST_Controller::HTTP_NOT_IMPLEMENTED,'添加失败',false);
    }

    /**分类列表
     * @var int $id
     * return json
    */
    public function category_get()
    {
        $id = $this->get('id') ?? '';
        if($category_data = $this->Zhishi_category_mod->get_by_id($id))
        {
            $child = $this->Zhishi_category_mod->get_by_parent_id($category_data[0]['id']) ?? false;
            $category_data[0]['child'] = $child;
            $this->send_response(REST_Controller::HTTP_OK,'查询成功',$category_data);
        }
        $this->send_response(REST_Controller::HTTP_NOT_IMPLEMENTED,'查询失败',FALSE);
    }

    /**更新分类
     * @var int $id
     * @var varchar $title
     * @var int $parent_id
     * return json
     */
    public function category_put()
    {
        $id = $this->put('id') ?? '';
        $title = $this->put('title') ?? '';
        $parent_id = $this->put('parent_id') ?? '';
        if($id && ($title || $parent_id || $parent_id == 0)){
            $category_data['id'] = $id;
            $title ? $category_data['title'] = $title : '';
            $parent_id ? $category_data['parent_id'] = $parent_id : '';
            if( $id = $this->Zhishi_category_mod->commit($category_data)){
                $this->send_response(REST_Controller::HTTP_OK,'更新成功',$id);
            }
        }
        $this->send_response(REST_Controller::HTTP_NOT_FOUND,'更新失败',FALSE);
    }

    /**删除分类
     * @var int $id
     * return json
     */
    public function category_delete()
    {
        $id = $this->query('id') ?? '';

        if($category_data = $this->Zhishi_category_mod->delete(array('id'=>$id)))
        {
            $this->send_response(REST_Controller::HTTP_OK,'删除成功',$category_data);
        }
        $this->send_response(REST_Controller::HTTP_NOT_FOUND,'删除失败',FALSE);
    }

}