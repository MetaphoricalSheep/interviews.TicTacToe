<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/21/2017
 * Time: 10:59 PM
 */

namespace models\ViewModels;


use Illuminate\Support\Collection;

class BaseViewModel implements IViewModel
{
    /** @var string */
    private $_title = "Tic Tac Toe";
    /** @var string */
    private $_view = "";
    /** @var Collection  */
    private $_javaScript;
    /** @var Collection  */
    private $_css;

    public function __construct()
    {
        $this->_javaScript = new Collection();
        $this->_css = new Collection();
    }

    /**
     * @return string
     */
    public function GetTitle() : string
    {
        return $this->_title;
    }

    /**
     * @param string $title
     * @return IViewModel
     */
    public function SetTitle(string $title) : IViewModel
    {
        $this->_title = $title;
        return $this;
    }

    /** @return string */
    public function GetView() : string
    {
        return $this->_view;
    }

    /**
     * @param string $path
     * @return IViewModel
     */
    public function SetView(string $path) : IViewModel
    {
        $this->_view = $path;
        $this->SetCss($path);
        $this->SetJavaScript($path);
        return $this;
    }

    /**
     * @param string $path
     * @return IViewModel
     */
    public function SetJavaScript(string $path) : IViewModel
    {
        if (file_exists(APPPATH."../public/js/" . $path . ".js"))
        {
            $this->_javaScript->push(sprintf('/js/%s.js', $path));
        }

        return $this;
    }

    /** @return Collection */
    public function GetJavaScript() : Collection
    {
        return $this->_javaScript;
    }

    public function LoadJavaScript() : void
    {
        $this->_javaScript->each(function($js)
        {
            echo sprintf('<script src="%s" type="application/javascript"></script>%s', $js, "\n");
        });
    }

    /** @return Collection */
    public function GetCss() : Collection
    {
        return $this->_css;
    }

    /**
     * @param string $path
     * @return IViewModel
     */
    public function SetCss(string $path) : IViewModel
    {
        if (file_exists(APPPATH."../public/css/" . $path . ".css"))
        {
            $this->_css->push(sprintf('/css/%s.css', $path));
        }

        return $this;
    }

    public function LoadCss() : void
    {
        $this->_css->each(function($css)
        {
            echo sprintf('<link rel="stylesheet" href="%s">%s', $css, "\n");
        });
    }
}