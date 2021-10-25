<?php
/**
 * Teamones
 * User: weijer
 * Date: 2021/4/9
 * Email: <weiwei163@foxmail.com>
 **/

declare (strict_types=1);

namespace app\validate;

use think\Validate;

// 文件名与控制器名称一致
class BaseValidate extends Validate
{
    /**
     * 验证是否唯一
     * @access public
     * @param mixed $value 字段值
     * @param mixed $rule 验证规则 格式：数据表,字段名,排除ID,主键名
     * @param array $data 数据
     * @param string $field 验证字段名
     * @return bool
     */
    public function unique($value, $rule, array $data = [], string $field = ''): bool
    {
        if (is_string($rule)) {
            $rule = explode(',', $rule);
        }

        if (false !== strpos($rule[0], '\\')) {
            // 指定模型类
            $db = new $rule[0];
        } else {
            // 指定模型类
            $className = "\\app\\model\\" . ucfirst($rule[0]);
            $db = new $className;
        }

        $key = $rule[1] ?? $field;
        $map = [];

        if (strpos($key, '^')) {
            // 支持多个字段验证
            $fields = explode('^', $key);
            foreach ($fields as $key) {
                if (isset($data[$key])) {
                    $map[] = [$key, '=', $data[$key]];
                }
            }
        } elseif (isset($data[$field])) {
            $map[] = [$key, '=', $data[$field]];
        } else {
            $map = [];
        }

        $pk = !empty($rule[3]) ? $rule[3] : $db->getPk();

        if (is_string($pk)) {
            if (isset($rule[2])) {
                $map[] = [$pk, '<>', $rule[2]];
            } elseif (isset($data[$pk])) {
                $map[] = [$pk, '<>', $data[$pk]];
            }
        }

        if ($db->where($map)->field($pk)->find()) {
            return false;
        }

        return true;
    }

    /**
     * 验证某个字段没有值的情况下必须
     * @access public
     * @param mixed $value 字段值
     * @param mixed $rule  验证规则
     * @param array $data  数据
     * @return bool
     */
    public function requireWithout($value, $rule, array $data = []): bool
    {
        $val = $this->getDataValue($data, $rule);

        if (empty($val)) {
            return !empty($value) || '0' == $value;
        }

        return true;
    }

    /**
     * 验证某个字段不等于某个值的时候必须
     * @access public
     * @param  mixed $value  字段值
     * @param  mixed $rule  验证规则
     * @param  array $data  数据
     * @return bool
     */
    public function requireIfNot($value, $rule, array $data = []): bool
    {
        list($field, $val) = explode(',', $rule);

        if ($this->getDataValue($data, $field) != $val) {
            return !empty($value) || '0' == $value;
        }

        return true;
    }
}