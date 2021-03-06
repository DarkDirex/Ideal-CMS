<?php
namespace Ideal\Core\Site;

use Ideal\Core\Config;
use Ideal\Structure\Part\Widget\MainMenu;

class Helper
{

    public $xhtml = false;

    public function getVariables($model)
    {
        // Получаем данные из виджета главного меню
        $mainMenu = new MainMenu($model);
        $vars['mainMenu'] = $mainMenu->getData();

        // Получаем телефон из конфига site_data.php
        $config = Config::getInstance();
        $vars['phone'] = $config->phone;

        return $vars;
    }

    /**
     * Метод предназначен для проведения финальных модификаций над текстом страницы
     *
     * @param string $text Окончательно сформированная страница
     * @return string Модифицированная страница
     */
    public function finishMod($text)
    {
        return $text;
    }
}
