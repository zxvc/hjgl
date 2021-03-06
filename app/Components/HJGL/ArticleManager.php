<?php

/**
 * Created by PhpStorm.
 * User: HappyQi
 * Date: 2017/9/28
 * Time: 10:30
 */

namespace App\Components\HJGL;

use App\Components\Utils;
use App\Models\HJGL\Article;
use Qiniu\Auth;

class ArticleManager
{

    /*
    * 根据id获取文章
    *
    * By Yuyang
    *
    * 2019-01-02
    */
    public static function getById($id)
    {
        $info = Article::where('id', '=', $id)->first();
        return $info;
    }

    /*
     * 根据条件获取列表
     *
     * By Yuyang
     *
     * 2019-01-02
     */
    public static function getListByCon($con_arr, $is_paginate)
    {
        $infos = new Article();
        //相关条件
        if (array_key_exists('type_id', $con_arr) && !Utils::isObjNull($con_arr['type_id'])) {
            $infos = $infos->where('type_id', '=', $con_arr['type_id']);
        }
        if (array_key_exists('source_type', $con_arr) && !Utils::isObjNull($con_arr['source_type'])) {
            $infos = $infos->where('source_type', '=', $con_arr['source_type']);
        }
        if (array_key_exists('type', $con_arr) && !Utils::isObjNull($con_arr['type'])) {
            $infos = $infos->where('type', '=', $con_arr['type']);
        }
        if (array_key_exists('source_name', $con_arr) && !Utils::isObjNull($con_arr['source_name'])) {
            $infos = $infos->where('source_name', '=', $con_arr['source_name']);
        }
        if (array_key_exists('source_chapter', $con_arr) && !Utils::isObjNull($con_arr['source_chapter'])) {
            $infos = $infos->where('source_chapter', '=', $con_arr['source_chapter']);
        }
        if (array_key_exists('source_page', $con_arr) && !Utils::isObjNull($con_arr['source_page'])) {
            $infos = $infos->where('source_page', '=', $con_arr['source_page']);
        }
        if (array_key_exists('published_year', $con_arr) && !Utils::isObjNull($con_arr['published_year'])) {
            $infos = $infos->where('published_year', '=', $con_arr['published_year']);
        }
        if (array_key_exists('published_place', $con_arr) && !Utils::isObjNull($con_arr['published_place'])) {
            $infos = $infos->where('published_place', '=', $con_arr['published_place']);
        }
        if (array_key_exists('published_date', $con_arr) && !Utils::isObjNull($con_arr['published_date'])) {
            $infos = $infos->where('published_date', '=', $con_arr['published_date']);
        }
        if (array_key_exists('search_word', $con_arr) && !Utils::isObjNull($con_arr['search_word'])) {
            $keyword = $con_arr['search_word'];
            $infos = $infos->where(function ($query) use ($keyword) {
                $query->where('title', 'like', "%{$keyword}%")
                    ->orwhere('author', 'like', "%{$keyword}%");
            });
        }
        $infos = $infos->orderby('id', 'desc');
        //配置规则
        if ($is_paginate) {
            $infos = $infos->paginate(Utils::PAGE_SIZE);
        } else {
            $infos = $infos->get();
        }
        return $infos;
    }

    /*
     * 根据级别获取信息
     *
     * By TerryQi
     *
     * 2018-06-15
     */
//    public static function getInfoByLevel($info, $level)
//    {
//        $info->jixing_str = Utils::medicine_jixing_val[$info->jixing];
//        $info->type_str = Utils::medicine_type_val[$info->type];
//        $info->class_str = Utils::medicine_class_val[$info->class];
//        // $info->medicineType = MedicineTypeManager::getById($info->medicineType_id);
////        dd($info);
//
//        return $info;
//    }


    /*
     * 设置文章信息，用于编辑
     *
     * By Yuyang
     *
     * 2019-01-02
     */
    public static function setInfo($info, $data)
    {
        if (array_key_exists('title', $data)) {
            $info->title = array_get($data, 'title');
        }
        if (array_key_exists('author', $data)) {
            $info->author = array_get($data, 'author');
        }
        if (array_key_exists('html', $data)) {
            $info->html = array_get($data, 'html');
        }
        if (array_key_exists('oper_type', $data)) {
            $info->oper_type = array_get($data, 'oper_type');
        }
        if (array_key_exists('oper_id', $data)) {
            $info->oper_id = array_get($data, 'oper_id');
        }
        return $info;
    }

    /*
     * 根据id用or条件获取文章(暂时用这个)
     *
     * By yuyang
     *
     * 2019-01-03
     */
    public static function getInfoByorId($info,$level = 0){
        if(strpos($level,'0')!== false){
            $ids = array();
            foreach($info as $v){
                $ids[] = $v->article_id;
            }
            $re = Article::wherein('id',$ids)->get();
            return $re;
        }else{
            return false;
        }
    }
}