<?php

namespace Encore\Admin\Controllers;

use Encore\Admin\Admin;
use Illuminate\Support\Arr;

class Dashboard
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function title()
    {
        return view('admin::dashboard.title');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function environment()
    {
        $envs = [
            ['name' => 'PHP version',       'value' => 'PHP/'.PHP_VERSION],
            ['name' => 'Laravel version',   'value' => app()->version()],
            ['name' => 'CGI',               'value' => php_sapi_name()],
            ['name' => 'Uname',             'value' => php_uname()],
            ['name' => 'Server',            'value' => Arr::get($_SERVER, 'SERVER_SOFTWARE')],

            ['name' => 'Cache driver',      'value' => config('cache.default')],
            ['name' => 'Session driver',    'value' => config('session.driver')],
            ['name' => 'Queue driver',      'value' => config('queue.default')],

            ['name' => 'Timezone',          'value' => config('app.timezone')],
            ['name' => 'Locale',            'value' => config('app.locale')],
            ['name' => 'Env',               'value' => config('app.env')],
            ['name' => 'URL',               'value' => config('app.url')],
        ];

        return view('admin::dashboard.environment', compact('envs'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function extensions()
    {
        $extensions = [
            'helpers' => [
                'name' => 'oficina4-admin-ext/helpers',
                'link' => 'https://github.com/oficina4/oficina4-admin-ext/helpers',
                'icon' => 'gears',
            ],
            'log-viewer' => [
                'name' => 'oficina4-admin-ext/log-viewer',
                'link' => 'https://github.com/oficina4/oficina4-admin-ext/log-viewer',
                'icon' => 'database',
            ],
            'backup' => [
                'name' => 'oficina4-admin-ext/backup',
                'link' => 'https://github.com/oficina4/oficina4-admin-ext/backup',
                'icon' => 'copy',
            ],
            'config' => [
                'name' => 'oficina4-admin-ext/config',
                'link' => 'https://github.com/oficina4/oficina4-admin-ext/config',
                'icon' => 'toggle-on',
            ],
            'api-tester' => [
                'name' => 'oficina4-admin-ext/api-tester',
                'link' => 'https://github.com/oficina4/oficina4-admin-ext/api-tester',
                'icon' => 'sliders',
            ],
            'media-manager' => [
                'name' => 'oficina4-admin-ext/media-manager',
                'link' => 'https://github.com/oficina4/oficina4-admin-ext/media-manager',
                'icon' => 'file',
            ],
            'scheduling' => [
                'name' => 'oficina4-admin-ext/scheduling',
                'link' => 'https://github.com/oficina4/oficina4-admin-ext/scheduling',
                'icon' => 'clock-o',
            ],
            'reporter' => [
                'name' => 'oficina4-admin-ext/reporter',
                'link' => 'https://github.com/oficina4/oficina4-admin-ext/reporter',
                'icon' => 'bug',
            ],
            'redis-manager' => [
                'name' => 'oficina4-admin-ext/redis-manager',
                'link' => 'https://github.com/oficina4/oficina4-admin-ext/redis-manager',
                'icon' => 'flask',
            ],
        ];

        foreach ($extensions as &$extension) {
            $name = explode('/', $extension['name']);
            $extension['installed'] = array_key_exists(end($name), Admin::$extensions);
        }

        return view('admin::dashboard.extensions', compact('extensions'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function dependencies()
    {
        $json = file_get_contents(base_path('composer.json'));

        $dependencies = json_decode($json, true)['require'];

        Admin::script("$('.dependencies').slimscroll({height:'510px',size:'3px'});");

        return view('admin::dashboard.dependencies', compact('dependencies'));
    }
}
