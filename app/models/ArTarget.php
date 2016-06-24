<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArTarget extends Model
{
    protected $table = 'Ar_Target';//表名
    protected $primaryKey = "id";//主键

    protected $fillable = ['id', 'name', 'targetId', 'trackingImage', 'date', 'appKey', 'signature', 'active', 'url', 'parameter', 'user_id'];

    /**
     * 获取应用到请求的验证规则
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:roles|max:255|min:2',
        ];
    }

    /**
     * 获取应用到请求的验证规则
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => '企业全称为必填项',


        ];
    }

    /**
     * 所有用户
     */
    public function users()
    {
        return $this->hasMany('App\Models\User');
    }

}
