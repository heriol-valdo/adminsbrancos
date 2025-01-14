<?php


namespace Projet\Database;


use Projet\Model\Table;

class Profile extends Table{

    protected static $table = 'profil';

    public static function save($nom,$privilege,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET nom = :nom,privilege = :privilege';
        $baseParam = [':privilege' => $privilege,':nom' => $nom];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function setPhoto($photo,$id){
        $sql = 'UPDATE '.self::getTable().' SET photo = :photo WHERE id = :id';
        $param = [':photo'=>($photo),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function countBySearchType($search = null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($search)){
            $tSearch = ' AND nom LIKE :search';
            $tab[':search'] = '%'.$search.'%';
        }else{
            $tSearch = '';
        }
        return self::query($count.$where.$tSearch,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$search = null){
        $limit = ' ORDER BY nom ASC, created_at DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($search)){
            $tSearch = ' AND nom LIKE :search';
            $tab[':search'] = '%'.$search.'%';
        }else{
            $tSearch = '';
        }
        return self::query(self::selectString().$where.$tSearch.$limit,$tab);
    }

}
