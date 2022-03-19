<?php
/**
 * @param string|null $devServer | The development server, including the protocol, domain and port e.g http://localhost:3000 (default)
 * @param string|null $mainScript | The path to the main script relative to the project root, including the extension
 * @param string|null $publicBasePath | Public path relative to public_path()
 * @return HtmlString
 */

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Acacia\Core\Constants\FormFields;
use Acacia\Core\Models\AcaciaMenu;
use Symfony\Component\Process\Process;

if (!function_exists('vite_assets')) {
    function vite_assets(?string $devServer = "http://localhost:3000",
                         ?string $mainScript = "Core/Js/main.ts",
                         ?string $publicBasePath = 'vendor/acacia'): HtmlString
    {
        $devServerIsRunning = false;

        if (app()->environment('local')) {
            try {
                Http::get($devServer);
                $devServerIsRunning = true;
            } catch (Exception $ex) {
            }
        }

        if ($devServerIsRunning) {
            return new HtmlString(<<<HTML
            <script type="module" src="$devServer/@vite/client"></script>
            <script type="module" src="$devServer/$mainScript"></script>
        HTML
            );
        }

        $manifest = json_decode(file_get_contents(
            public_path("$publicBasePath/manifest.json")
        ), true);

        return new HtmlString(<<<HTML
        <script type="module" src="/$publicBasePath/{$manifest[$mainScript]['file']}"></script>
        <link rel="stylesheet" href="/$publicBasePath/{$manifest[$mainScript]['css'][0]}">
    HTML
        );
    }
}
if (!function_exists("runShellCommand")) {
    function run_shell_command(string $command, $console = null)
    {
        $process = Process::fromShellCommandline($command);
        $process->start();
        foreach ($process as $type => $data) {
            if ($process::OUT === $type) {
                if ($console)
                    $console->info(trim($data));
            } else {
                // $process::ERR === $type
                if ($console)
                    $console->warn(trim($data));
            }
        }
    }
}
if (!function_exists("prepare_menu")) {
    function prepare_menu(EloquentCollection $menu): EloquentCollection
    {
        $devModules = config('acacia.dev_modules',[]);
        return $menu->reject(function (AcaciaMenu $item) use ($devModules) {
            $mod = $item->module_name;
            $module = null;
            if ($mod) {
                $module = Module::find($mod);
            }
            return app()->environment('production')
                && $mod
                && in_array($mod, $devModules)
                && $module;
        })->map(function (AcaciaMenu $item) {
            $item->has_children = !!$item->children()->count();
            if ($item->has_children) {
                $item->children = prepare_menu($item->children);
            } else {
                $item->href = $item->route ? (Route::has($item->route) ? route($item->route) : '') : $item->url;
            }
            $item->active = $item->active_pattern && Route::is($item->active_pattern);
            $item->shown = Auth::check() && (!$item->permission_name || Auth::user()->hasPermissionTo($item->permission_name));
            return $item;
        });
    }
}

if (!function_exists("get_default_html_field")) {
    function get_default_html_field(string $dbColumnType): string
    {
        return match ($dbColumnType) {
            "boolean", "bool", "tinyinteger" => FormFields::SWITCH,
            "text", "longtext" => FormFields::TEXTAREA,
            "float", "double", "integer", "int", "bigint" => FormFields::NUMBER,
            "date" => FormFields::DATE,
            "datetime" => FormFields::DATETIME,
            default => FormFields::TEXT,
        };
    }
}
