<?php
/**
 * Created by PhpStorm.
 * User: 晓明
 * Date: 2017/10/12
 * Time: 14:18
 */
class blog_model extends Public_model
{
    function __construct() {
        parent::__construct();
        $this->pk_name = 'id';
        $this->table = 'blog';
    }

    function allList($user_id,$title='',$page=1,$per_page=10){
        $rst = $this->db
            ->select("b.*,u.truename")
            ->from("$this->table b")
            ->join("users u",'b.user_id = u.id','left')
            ->where(["b.user_id"=>$user_id,"b.status"=>1])
            ->like('b.title',$title)
            ->order_by("b.created_at",'DESC')
            ->limit($per_page,($page-1)*$per_page)
            ->get()
            ->result_array();
        return $rst ?? [];
    }

    function blogList($user_id,$title='',$page=1,$per_page=10){
        $rst = $this->db
                ->select("b.*,u.truename")
                ->from("$this->table b")
                ->join("users u",'b.user_id = u.id','left')
                ->where(["b.user_id"=>$user_id,"b.status"=>1,'b.tag'=>0])
                ->like('b.title',$title)
                ->order_by("b.created_at",'DESC')
                ->limit($per_page,($page-1)*$per_page)
                ->get()
                ->result_array();
        return $rst ?? [];
    }

    function blogShow($title='',$category='',$page=1,$per_page=6){
        $rst = $this->db
            ->select("b.*,u.truename,u.avatar,count(bc.id) as comment")
            ->from("$this->table b")
            ->join("users u",'b.user_id = u.id','left')
            ->join("blog_comment bc","b.id=bc.blog_id",'left')
            ->where("b.status",1)
            ->where('b.tag',0)
            ->like('b.title',$title)
            ->like('category',$category)
            ->order_by("b.created_at",'DESC')
            ->limit($per_page,($page-1)*$per_page)
            ->group_by("b.id")
            ->get()
            ->result_array();
        return $rst ?? [];
    }
    function qaShow($title='',$category='',$page=1,$per_page=6){
        $rst = $this->db
            ->select("b.*,u.truename,u.avatar,count(bc.id) as comment")
            ->from("$this->table b")
            ->join("users u",'b.user_id = u.id','left')
            ->join("blog_comment bc","b.id=bc.blog_id",'left')
            ->where("b.status",1)
            ->where('b.tag',1)
            ->like('b.title',$title)
            ->like('category',$category)
            ->order_by("b.created_at",'DESC')
            ->limit($per_page,($page-1)*$per_page)
            ->group_by("b.id")
            ->get()
            ->result_array();
        return $rst ?? [];
    }

    function gameShow($title='',$category='',$page=1,$per_page=6){
        $rst = $this->db
            ->select("b.*,u.truename,u.avatar,count(bc.id) as comment")
            ->from("$this->table b")
            ->join("users u",'b.user_id = u.id','left')
            ->join("blog_comment bc","b.id=bc.blog_id",'left')
            ->where("b.status",1)
            ->where('b.tag',2)
            ->like('b.title',$title)
            ->like('category',$category)
            ->order_by("b.created_at",'DESC')
            ->limit($per_page,($page-1)*$per_page)
            ->group_by("b.id")
            ->get()
            ->result_array();
        return $rst ?? [];
    }

    //top10
    function top10(){
        $rst = $this->db
            ->select("b.*,u.truename,u.avatar")
            ->from("$this->table b")
            ->join("users u",'b.user_id = u.id','left')
            ->where(["b.status"=>1,'b.tag'=>0])
            ->order_by("b.last_view",'DESC')
            ->limit(10,0)
            ->get()
            ->result_array();
        return $rst ?? [];
    }
    //top10
    function getAll(){
        $rst = $this->db
            ->select("b.*,u.truename,u.avatar")
            ->from("$this->table b")
            ->join("users u",'b.user_id = u.id','left')
            ->where(["b.status"=>1])
            ->order_by("b.last_view",'DESC')
            ->get()
            ->result_array();
        return $rst ?? [];
    }

    ///top10
    function selectByKey($key){
        $sql = " select 
                    b.*,
                    u.truename,
                    u.avatar 
                  from {$this->table} b 
                  left join users u on b.user_id = u.id
                  where
                    b.status = 1 and ( b.title like '%{$key}%' or b.category like '%{$key}%')
                  order by b.last_view desc
                ";
        $rst = $this->db->query($sql)->result_array();

        return $rst ?? [];
    }

    /**
    @author zhangxiaoming
    @return json
    */
    function blogDetail($id){
        $rst = $this->db
            ->select("b.*,u.truename,u.avatar,u.sex")
            ->from("$this->table b")
            ->join("users u",'b.user_id = u.id','left')
            ->where(["b.id"=>$id])
            ->get()
            ->result_array();
        return $rst ? $rst[0] : [];
    }

    /**
    @author zhangxiaoming
    @return json
     */
    function qaDetail($id){
        $rst = $this->db
            ->select("b.*,u.truename,u.avatar,u.sex")
            ->from("$this->table b")
            ->join("users u",'b.user_id = u.id','left')
            ->where(["b.id"=>$id])
            ->get()
            ->result_array();
        return $rst ? $rst[0] : [];
    }

    /**
    @author zhangxiaoming
    @return json
     */
    function gameDetail($id){
        $rst = $this->db
            ->select("b.*,u.truename,u.avatar,u.sex")
            ->from("$this->table b")
            ->join("users u",'b.user_id = u.id','left')
            ->where(["b.id"=>$id,'b.tag'=>2])
            ->get()
            ->result_array();
        return $rst ? $rst[0] : [];
    }

    function updateView($id){
        $sql = "update blog set view = view + 1 where id = $id";
        $this->db->query($sql);
        return true;
    }


    /*首次评论*/
    function blogComment($id){
        $rst = $this->db
            ->select('bc.*,u.truename,u.avatar,u.sex,u2.truename as r_truename')
            ->from('blog_comment bc')
            ->join('users u','bc.user_id=u.id','left')
            ->join('blog_comment bc2','bc.reply_id=bc2.id','left')
            ->join('users u2','bc2.user_id=u2.id','left')
            ->where('bc.blog_id',$id)
            ->order_by('bc.created_at','desc')
            ->get()
            ->result_array();
        return $rst ? $rst : false;
    }

    /*二次评论*/
    function blogReply($id){
        $rst = $this->db
            ->select('bc.*,u.truename,u.avatar,u.sex,u2.truename as r_truename,u2.avatar as r_avatar')
            ->from('blog_comment bc')
            ->join('users u','bc.user_id=u.id','left')
            ->join('blog_comment bc2','bc.reply_id = bc2.id','left')
            ->join('users u2','bc2.user_id = u2.id','left')
            ->where("bc.blog_id = {$id} and bc.reply_id != 0")
            ->order_by('bc.created_at','ASC')
            ->get()
            ->result_array();
        return $rst ? $rst : false;
    }

    /*首次评论*/
    function qaComment($ids){
        if($ids){
            $rst = $this->db
                ->select('bc.*,u.truename,u.avatar,u.sex,u2.truename as r_truename')
                ->from('blog_comment bc')
                ->join('users u','bc.user_id=u.id','left')
                ->join('blog_comment bc2','bc.reply_id=bc2.id','left')
                ->join('users u2','bc2.user_id=u2.id','left')
                ->where_in('bc.blog_id',$ids)
                ->order_by('bc.created_at','asc')
                ->get()
                ->result_array();
        }else{
            $rst = false;
        }


        return $rst ? $rst : false;
    }
}