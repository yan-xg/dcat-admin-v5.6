<?php
use Illuminate\Support\Arr;

if (! function_exists('user_admin_config')) {
    function user_admin_config($key = null, $value = null)
    {
        $session = session();

        if (! $config = $session->get('admin.config')) {
            $config = config('admin');

            $config['name'] = admin_setting('name');
            $config['url'] = admin_setting('url');
            $config['logo'] = admin_setting('logo');
            $config['lang'] = admin_setting('lang',config('app.locale'));
        }
        if (is_array($key)) {
            admin_setting($key); //添加到数据库
            // 保存
            foreach ($key as $k => $v) {
                Arr::set($config, $k, $v);
            }

            $session->put('admin.config', $config);

            return;
        }

        if ($key === null) {
            return $config;
        }

        return Arr::get($config, $key, $value);
    }
}
