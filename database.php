<?php

namespace App\Http\Controllers\ddns;

class serializeDatabase{

}

class database{
    protected $dbpath,$table,$result;

    public function __construct(){
        $this->dbpath = realpath(app_path()."/database");
    }

    public function table($tablename){
        if(!file_exists($this->dbpath."/".$tablename)){
            $instance = new serializeDatabase();
            file_put_contents($this->dbpath."/".$tablename,serialize($instance));
        }
        $this->table = $tablename;
        return $this;
    }

    public function insert($data){
        $instance = unserialize(file_get_contents($this->dbpath."/".$this->table));
        $instance->{$this->table}[] = $data;
        file_put_contents($this->dbpath."/".$this->table,serialize($instance));
    }

    public function select($where){
        $instance = unserialize(file_get_contents($this->dbpath."/".$this->table));
        $result = [];
        foreach($instance->{$this->table} as $key=>$value){
            $flag = true;
            foreach($where as $k=>$v){
                if($value[$k] != $v){
                    $flag = false;
                    break;
                }
            }
            if($flag){
                $result[] = $value;
            }
        }

        $this->result = $result;
        return $this;
    }

    public function first(){
        return $this->result[0];
    }

    public function get(){
        return $this->result;
    }

    public function count(){
        return count($this->result);
    }

    public function orderBy($field,$sort){
        $sort = strtolower($sort);
        if($sort == "desc"){
            usort($this->result,function($a,$b) use ($field){
                if($a[$field] == $b[$field]){
                    return 0;
                }
                return $a[$field] > $b[$field] ? -1 : 1;
            });
        }else{
            usort($this->result,function($a,$b) use ($field){
                if($a[$field] == $b[$field]){
                    return 0;
                }
                return $a[$field] > $b[$field] ? 1 : -1;
            });
        }
        return $this;
    }

    public function limit($start,$length){
        $this->result = array_slice($this->result,$start,$length);
        return $this;
    }

    

    public function update($where,$data){
        $instance = unserialize(file_get_contents($this->dbpath."/".$this->table));
        foreach($instance->{$this->table} as $key=>$value){
            $flag = true;
            foreach($where as $k=>$v){
                if($value[$k] != $v){
                    $flag = false;
                    break;
                }
            }
            if($flag){
                foreach($data as $k=>$v){
                    $instance->{$this->table}[$key][$k] = $v;
                }
            }
        }
        file_put_contents($this->dbpath."/".$this->table,serialize($instance));
    }

    public function delete($where){
        $instance = unserialize(file_get_contents($this->dbpath."/".$this->table));
        foreach($instance->{$this->table} as $key=>$value){
            $flag = true;
            foreach($where as $k=>$v){
                if($value[$k] != $v){
                    $flag = false;
                    break;
                }
            }
            if($flag){
                unset($instance->{$this->table}[$key]);
            }
        }
        file_put_contents($this->dbpath."/".$this->table,serialize($instance));
    }

    public function truncate(){
        $instance = new serializeDatabase();
        file_put_contents($this->dbpath."/".$this->table,serialize($instance));
    }


}