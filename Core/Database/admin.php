<?php


namespace Projet\Database;


use Projet\Model\Table;


class admin extends  Table
{
    protected static $table = 'admin';

    public static function save($username,$email,$password,$profileimage,$status,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().'SET username= :username,email= :email,password= :password,profileimage= :profileimage,status= :status';
        $baseParam = [':username' =>$username,':email' =>$email,':password' =>$password,':profileimage' =>$profileimage,':status' =>$status];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }


}
