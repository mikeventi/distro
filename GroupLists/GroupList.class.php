<?php
/**
 * undocumented class
 *
 * @package default
 * @author Michael Ventimiglia Jr.
 **/
class GroupList
{
    public $id;
    public $db;
    public $list_name;
    public $active;
    public $users   =   array();

    public function __construct()
    {
        $this->db   =   new mysqli(
                "127.0.0.1",
                "vulcanmoto",
                "vulcanclub",
                "vulcanmotomsdb");
    }

    public function listName($id)
    {
        $result = $this->db->query("SELECT list_name FROM group_list WHERE list_id = $id");
        return $result;
        $result->close();
    }

    private function nextId()
    {
        $result = $this->db->query("SELECT max(list_id) as last_id FROM group_list");
        if ($id = $result->fetch_object()->last_id) {
            return $id + 1;
        }
        $result->close();
    }

    public function fetchAll($start = 0, $limit = 5)
    {
        $result = $this->db->query("SELECT * FROM group_list");
        return $result;
        $result->close();
    }

    public function newUser($user,$email)
    {
        $result = $this->db->query("INSERT INTO group_list_users (display_name,email,active) VALUES ('".$user."','".$email."',1)");
            if ($result) {
                 return true;
            }
    }

    public function newListUser($email)
    {
        $result = $this->db->query("INSERT INTO group_list_user (list_id,email) VALUES ('".$this->id."','".$email."')");
        if ($result) {
            return true;
        }
    }

    public function deleteListUser($email)
    {
        $result = $this->db->query("DELETE FROM group_list_user WHERE list_id = $this->id AND email = '".$email."'");
        if ($result) {
            return true;
        }
    }

    public function getListIdByName($name)
    {
        $result = $this->db->query("SELECT * FROM group_list WHERE list_name = '".$name."'");
        return $result->fetch_object()->list_id;
        $result->close();
    }

    public function getListUsers($id)
    {
        $result = $this->db->query("SELECT
            lists.list_id,
            users.email as email,
            users.display_name as name
            FROM group_list_user AS lists
            INNER JOIN group_list_users as users ON lists.list_id = '".$id."' AND lists.email = users.email");
        return $result;
        $result->close();
    }

    public function getUserCount($id)
    {
        $result = $this->db->query("SELECT * FROM group_list_user WHERE list_id = $id");
        return $result->num_rows;
        $result->close();
    }

    public function save()
    {
        if ($this->id == null) {
            $this->id = $this->nextId();
        }
        $result = $this->db->query("INSERT INTO group_list (list_id,list_name,active) VALUES ('".$this->id."','".$this->list_name."',1)");
            if ($result) {
                 return true;
            }
    }

    public function delete()
    {
        if ($this->id ==  null) {
            return false;
        }

        $query = $this->db->query("DELETE FROM group_list WHERE list_id = $this->id");

        if ($query) {
            return true;
        }
    }
} // END class DistributionList