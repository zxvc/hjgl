<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2018/2/26
 * Time: 13:40
 */

namespace App\Models\HJGL;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToolDispose extends Model
{
    use SoftDeletes;    //使用软删除
    protected $connection = 'hjgldb';   //慢病管理数据库名
    protected $table = 't_tool_dispose';
    public $timestamps = true;
    protected $dates = ['delete_time'];  //软删除
}