<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/28 0028
 * Time: 下午 8:31
 */
class Tidyroom extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('tidyroom_center_model','center_mod');
        $this->load->model('tidyroom_lists_model','lists_mod');
        $this->load->model('tidyroom_users_model','t_users_mod');
        $this->load->model('tidyroom_records_model','records_mod');
    }

    /**
     * @var $user_id
     * @var $center_id
     * return json
    */
    function index_get()
    {
        $user_id = $this->get('user_id') ?? '';
        $center_id  = $this->get('center_id') ?? '';
        $start_date = $this->get('start_date') ?? '';
        $end_date = $this->get('end_date') ?? '';
        $title = '';
        if(!$center_id) {
            $center = $this->center_mod->getLatestCenter($user_id);
            if($center){
                $center_id = $center['id'];
                $title = $center['title'];
            }
        }else{
            $rst = $this->center_mod->getTitle($center_id);
            !$rst || $title = $rst[0]['title'];
        }

        $list = $this->lists_mod->listInfo($center_id);

        $record = $this->records_mod->recordList($center_id,$user_id,$start_date,$end_date);
        $lists = $score = array();
        //id键值翻转到键名
        foreach ($list as $v){
            $v['count'] = 0;
            $v['lastDate'] = '';
            $lists[$v['id']] = $v;
            //根据单项分数排序
            $score[] = $v['score'];
        }
        $list = array();
        foreach ($record as $v){
            if(array_key_exists($id = $v['list_id'],$lists)){
                $lists[$id]['count'] += $v['count'];
                $lists[$id]['lastDate'] < $v['date']  && $lists[$id]['lastDate'] = $v['date'];
            }
        }
        $finalScore = 0;
        foreach($lists as $v){
            $v['totalScore'] = $v['count'] * $v['score'];
            $list[$v['id']] = $v;
            $finalScore +=  $v['totalScore'];
        }
        array_multisort($score,SORT_DESC,SORT_NUMERIC,$list);
        $this->send_response(REST_Controller::HTTP_OK,$title,array('title'=>$title,'center_id'=>$center_id,'finalScore'=>$finalScore,'data'=>$list));
    }

    function centerList_get()
    {
        $user_id = $this->get('user_id');
        $userList = $this->center_mod->centerList($user_id);
        $this->send_response(REST_Controller::HTTP_OK,'家勤列表',$userList);
    }

    //中心详情
    function center_get()
    {
        $center_id  = $this->get('center_id');
        $list = $this->center_mod->centerInfo($center_id);
        $this->send_response(REST_Controller::HTTP_OK,'家活考勤',$list);
    }


    //新增
    function center_post()
    {
        $title = $this->post('title') ?? '';
        $list = $this->post('list') ?? [];
        $user = $this->post('user') ?? [];
        if($title && $list){
            $this->db->trans_start();
            $center_id = $this->center_mod->commit(['title'=>$title]);
            $lists = $users = array();
            foreach($list as $v){
                $v['center_id'] = $center_id;
                $lists[] = $v;
            }
            foreach($user as $v){
                $v['center_id'] = $center_id;
                $users[] = $v;
            }
            $this->lists_mod->commit_batch($lists);
            $this->t_users_mod->commit_batch($users);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->send_response(REST_Controller::HTTP_UNAUTHORIZED,'添加失败');
            }else {
                $this->db->trans_commit();
                $this->send_response(REST_Controller::HTTP_OK,'添加成功',$center_id);
            }
        }
    }
    /**编辑项目*/
    function editCenter_post()
    {
        $id = $this->post('id') ??  '';
        $title = $this->post("title") ?? '';
        $list = $this->post("list") ?? [];
        $user = $this->post("user") ?? [];
        if(!$id || !$title)
            $this->send_response(REST_Controller::HTTP_UNAUTHORIZED,'标题不能为空');
        //标题查重
        $center = $this->db->select("*")->from("tidyroom_center")->where("title = '{$title}' and id != '{$id}'")->get()->result_array();
        $center = $center ? $center[0] : false;
        if($center)
            $this->send_response(REST_Controller::HTTP_UNAUTHORIZED,'标题已存在');
        //列单查重
        $existList = $this->db->select("*")->from("tidyroom_lists")->where('center_id',$id)->get()->result_array();
        $existList = array_column($existList,'title');
        foreach($list as $l){
            if(in_array($l['title'],$existList))
                $this->send_response(REST_Controller::HTTP_UNAUTHORIZED,$l['title']."已存在");
        }
        foreach($list as &$v){
            $v['center_id'] = $id;
        }
        $this->center_mod->commit(['id'=>$id,'title'=>$title]);
        $this->lists_mod->commit_batch($list);
        $this->send_response(REST_Controller::HTTP_OK,'编辑成功');
    }

    /*家勤记录*/
    function record_post()
    {
        $record = $this->post('record');
        $this->records_mod->commit_batch($record);
        $this->send_response(REST_Controller::HTTP_OK,'添加成功');
    }
    /*批量删除记录*/
    function recordDelete_post()
    {
        $record_ids = $this->post('record_ids');
        $this->records_mod->delete_batch($record_ids);
        $this->send_response(REST_Controller::HTTP_OK,'删除成功');
    }


}