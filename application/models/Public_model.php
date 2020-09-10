<?php
/**
 * Company Foundation Model
 */
/**
 * @property CI_DB_active_record $db              This is the platform-independent base Active Record implementation class.
 * @property CI_DB_forge $dbforge                 Database Utility Class
 * @property CI_Benchmark $benchmark              This class enables you to mark points and calculate the time difference between them.<br />  Memory consumption can also be displayed.
 * @property CI_Calendar $calendar                This class enables the creation of calendars
 * @property CI_Cart $cart                        Shopping Cart Class
 * @property CI_Config $config                    This class contains functions that enable config files to be managed
 * @property CI_Controller $controller            This class object is the super class that every library in.<br />CodeIgniter will be assigned to.
 * @property CI_Email $email                      Permits email to be sent using Mail, Sendmail, or SMTP.
 * @property CI_Encrypt $encrypt                  Provides two-way keyed encoding using XOR Hashing and Mcrypt
 * @property CI_Exceptions $exceptions            Exceptions Class
 * @property CI_Form_validation $form_validation  Form Validation Class
 * @property CI_Ftp $ftp                          FTP Class
 * @property CI_Hooks $hooks                      Provides a mechanism to extend the base system without hacking.
 * @property CI_Image_lib $image_lib              Image Manipulation class
 * @property CI_Input $input                      Pre-processes global input data for security
 * @property CI_Lang $lang                        Language Class
 * @property CI_Loader $load                      Loads views and files
 * @property CI_Log $log                          Logging Class
 * @property CI_Model $model                      CodeIgniter Model Class
 * @property CI_Output $output                    Responsible for sending final output to browser
 * @property CI_Pagination $pagination            Pagination Class
 * @property CI_Parser $parser                    Parses pseudo-variables contained in the specified template view,<br />replacing them with the data in the second param
 * @property CI_Profiler $profiler                This class enables you to display benchmark, query, and other data<br />in order to help with debugging and optimization.
 * @property CI_Router $router                    Parses URIs and determines routing
 * @property CI_Session $session                  Session Class
 * @property CI_Sha1 $sha1                        Provides 160 bit hashing using The Secure Hash Algorithm
 * @property CI_Table $table                      HTML table generation<br />Lets you create tables manually or from database result objects, or arrays.
 * @property CI_Trackback $trackback              Trackback Sending/Receiving Class
 * @property CI_Typography $typography            Typography Class
 * @property CI_Unit_test $unit_test              Simple testing class
 * @property CI_Upload $upload                    File Uploading Class
 * @property CI_URI $uri                          Parses URIs and determines routing
 * @property CI_User_agent $user_agent            Identifies the platform, browser, robot, or mobile devise of the browsing agent
 * @property CI_Validation $validation            //dead
 * @property CI_Xmlrpc $xmlrpc                    XML-RPC request handler class
 * @property CI_Xmlrpcs $xmlrpcs                  XML-RPC server class
 * @property CI_Zip $zip                          Zip Compression Class
 * @property CI_Javascript $javascript            Javascript Class
 * @property CI_Jquery $jquery                    Jquery Class
 * @property CI_Utf8 $utf8                        Provides support for UTF-8 environments
 * @property CI_Security $security                Security Class, xss, csrf, etc...
 */
class Public_model extends CI_Model {
    public $pk_name;
    public $table;
    function __construct() {
        parent::__construct();
        log_message('debug', 'Com_Model class loaded');
    }

    public function get($sql, $params = FALSE) {
        $results = $this->db->query($sql, $params)->result_array();

        return empty($results) ? FALSE : $results[0];
    }

    public function lists($sql, $params = FALSE) {
        return $this->db->query($sql, $params)->result_array();
    }

    public function commit($data) {
        if ( ! isset($data[$this->pk_name]) || (string)$data[$this->pk_name] === '' || (int)$data[$this->pk_name] === 0) {
            // Remove the ID so the generated SQL will be clean (no empty String insert in the table PK field)
            unset($data[$this->pk_name]);
            $this->db->insert($this->table, $data);
            $data[$this->pk_name] = $this->db->insert_id();
        }
        else {

            $this->db->where($this->pk_name, $data[$this->pk_name]);
            $this->db->update($this->table, $data);
        }
        return $data[$this->pk_name];
    }

    public function commit_batch($data)
    {
        if ($data) {
            return $this->db->insert_batch($this->table, $data);
        } else {
            return true;
        }
    }

    public function update_batch($data)
    {
        return $this->db->update_batch($this->table, $data, $this->pk_name);
    }

    public function update_batch_by_week($data,$where)
    {
        return $this->db->update_batch($this->table, $data, $where);
    }

    public function submit($data) {
        $res = $this->db->where('user_id',$data['user_id'])->count_all_results($this->table);
        if ($res > 0) {
            //$this->db->where(user_id, $data['user_id']);
            $this->db->update($this->table, $data, array('user_id' => $data['user_id']));
            //$this->db->update($this->table, $data);
        }
        else {
            $this->db->insert($this->table, $data);
            $data[$this->pk_name] = $this->db->insert_id();
            return $data[$this->pk_name];

        }

    }

    /**
     * 更安全的保存 相较于 commit()
     * @param $data
     * @param bool $insert
     * @return object
     */
    public function commit_multi_keys($data, $insert = true) {
        foreach ($this->pks as $pk) {
            $this->db->where($pk, $data[$pk]);
        }
        if ($this->db->count_all_results($this->table)) {
            foreach ($this->pks as $pk) {
                $this->db->where($pk, $data[$pk]);
            }
            return $this->db->update($this->table, $data);
        }
        else if($insert) {
            return $this->db->insert($this->table, $data);
        }
    }

    public function count_all($table, $where = '') {
        $where = ! empty($where) ? ' WHERE '.$where : '';
        $sql = "SELECT count(*) c FROM $table $where ";
        $res = $this->db->query($sql)->row_array();
        return (int)$res['c'];
    }

    /**
     * 把返回的数据集转换成Tree
     * @access public
     * @param array $list 要转换的数据集
     * @param string $pk
     * @param string $pid parent标记字段
     * @param string $child level标记字段
     * @param integer $root
     * @return array
     * @author grg 2010-09-07 15:17:12
     */
    public function list_to_tree($list, $pk = 'id', $pid = 'p_id', $child = '_child', $root = 0) {
        // 创建Tree
        $tree = [];
        if (is_array($list)) {
            // 创建基于主键的数组引用
            $refer = [];
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] =& $list[$key];
            }
            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId = $data[$pid];
                if ($root == $parentId) {
                    $tree[] =& $list[$key];
                }
                else {
                    if (isset($refer[$parentId])) {
                        $parent =& $refer[$parentId];
                        $parent[$child][] =& $list[$key];
                    }
                }
            }
        }
        return $tree;
    }

    /**
     * Delete rows from table related to by $name
     *
     * @access public
     * @param mixed $where Rows to delete
     * @return Query Object
     */
    public function delete($where,$isTrue=true) {
        if($isTrue == true){
            $this->db->where($where);
            return $this->db->delete($this->table);
        }else{
            $this->db->update($this->table,['status'=>0],$where);
            return ;
        }
    }
    /*批量删除*/
    public function delete_batch($where){
        $this->db->where_in($this->pk_name,$where);
        return $this->db->delete($this->table);
    }
}

