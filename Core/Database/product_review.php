<?php


namespace Projet\Database;


use Projet\Model\Table;


class product_review extends Table {
    protected static $table = 'product_review';

    public static function save($product_id,$user_id,$title,$rating,$review,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().'SET user_id= :user_id,product_id= :product_id,rating= :rating
        ,review= :review,title= :title';
        $baseParam = [':id_user'=>$user_id,':product_id' =>$product_id,':rating'=>$rating,
            ':title'=>$title,':review'=>$review,];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function countBySearchType($user_id=null,$product_id=null,$debut=null,$fin=null){
        $count = 'SELECT COUNT(*) AS Total, AVG(rating) AS moyenne FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($user_id)){
            $tuser_id = ' AND user_id = :user_id';
            $tab[':user_id'] = $user_id;
        }else{
            $tuser_id = '';
        }
        if(isset($product_id)){
            $tproduct_id = ' AND product_id = :product_id';
            $tab[':product_id'] = $product_id;
        }else{
            $tproduct_id = '';
        }
        if(isset($debut)){
            $tDebut = ' AND DATE(date) >= :debut';
            $tab[':debut'] = $debut;
        }else{
            $tDebut = '';
        }
        if(isset($fin)){
            $tFin = ' AND DATE(date) <= :fin';
            $tab[':fin'] = $fin;
        }else{
            $tFin = '';
        }
        return self::query($count.$where.$tuser_id.$tproduct_id.$tFin.$tDebut,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$user_id=null,$product_id=null,$debut=null,$fin=null){
        $limit = ' ORDER BY date DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($user_id)){
            $tuser_id = ' AND user_id = :user_id';
            $tab[':user_id'] = $user_id;
        }else{
            $tuser_id = '';
        }
        if(isset($product_id)){
            $tproduct_id = ' AND product_id = :product_id';
            $tab[':product_id'] = $product_id;
        }else{
            $tproduct_id = '';
        }
        if(isset($debut)){
            $tDebut = ' AND DATE(date) >= :debut';
            $tab[':debut'] = $debut;
        }else{
            $tDebut = '';
        }
        if(isset($fin)){
            $tFin = ' AND DATE(date) <= :fin';
            $tab[':fin'] = $fin;
        }else{
            $tFin = '';
        }
        return self::query(self::selectString().$where.$tuser_id.$tproduct_id.$tFin.$tDebut.$limit,$tab);
    }
}