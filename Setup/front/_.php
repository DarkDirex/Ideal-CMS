<?php
namespace Ideal;

ini_set('display_errors', 'Off');

$cmsFolder = '[[CMS]]';
$subFolder = '[[SUBFOLDER]]';

// Абсолютный адрес корня сервера, не должен оканчиваться на слэш.
define('DOCUMENT_ROOT', getenv('SITE_ROOT') ? getenv('SITE_ROOT') : $_SERVER['DOCUMENT_ROOT']);

// В пути поиска по умолчанию включаем корень сайта, путь к Ideal и папке кастомизации CMS
set_include_path(
    get_include_path()
        . PATH_SEPARATOR . DOCUMENT_ROOT . $subFolder 
        . PATH_SEPARATOR . DOCUMENT_ROOT . $subFolder . '/' . $cmsFolder . '/Ideal.c/'
        . PATH_SEPARATOR . DOCUMENT_ROOT . $subFolder . '/' . $cmsFolder . '/Ideal/'
        . PATH_SEPARATOR . DOCUMENT_ROOT . $subFolder . '/' . $cmsFolder . '/Mods.c/'
        . PATH_SEPARATOR . DOCUMENT_ROOT . $subFolder . '/' . $cmsFolder . '/Mods/'
);

// Подключаем автозагрузчик классов
require_once 'Core/AutoLoader.php';

// Подключаем класс конфига
$config = Core\Config::getInstance();

// Каталог, в котором находятся модифицированные скрипты CMS
$config->cmsFolder = $subFolder . $cmsFolder;

// Куда будет вестись лог ошибок. Варианты file|display|comment|firebug|email
$config->errorLog = 'firebug';

// Загружаем список структур из конфигурационных файлов структур
$config->loadSettings();

// Инициализируем фронт контроллер
$page = new Core\FrontController();

if (strpos($_SERVER['REQUEST_URI'], $subFolder . $cmsFolder . '/') === 1) {
    // Обращение к административной части

    // Регистрируем плагин авторизации
    $pluginBroker = Core\PluginBroker::getInstance();
    $pluginBroker->registerPlugin('onPostDispatch', '\\Ideal\\Structure\\User\\Admin\\Plugin');

    // Запускаем фронт контроллер
    $page->run('admin');

} else {
    // Обращение к пользовательской части
    $page->run('site');
}