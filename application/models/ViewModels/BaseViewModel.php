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
    private $Title = "Tic Tac Toe";
    /** @var string */
    private $View = "";
    /** @var Collection  */
    private $JavaScript;

    public function __construct()
    {
        $this->JavaScript = new Collection();
    }

    /**
     * @return string
     */
    public function GetTitle() : string
    {
        return $this->Title;
    }

    /**
     * @param string $title
     * @return IViewModel
     */
    public function SetTitle(string $title) : IViewModel
    {
        $this->Title = $title;
        return $this;
    }

    /** @return string */
    public function GetView() : string
    {
        return $this->View;
    }

    /**
     * @param string $path
     * @return IViewModel
     */
    public function SetView(string $path) : IViewModel
    {
        $this->View = $path;

        return $this->SetJavaScript($path);
    }

    /**
     * @param string $path
     * @return IViewModel
     */
    public function SetJavaScript(string $path) : IViewModel
    {
        if (file_exists(APPPATH."../public/js/" . $path . ".js"))
        {
            $this->JavaScript->push(sprintf('/js/%s.js', $path));
        }

        return $this;
    }

    /** @return Collection */
    public function GetJavaScript() : Collection
    {
        return $this->JavaScript;
    }

    public function LoadJavaScript() : void
    {
        $this->JavaScript->each(function($js)
        {
            echo sprintf('<script src="%s" type="application/javascript"></script>%s', $js, "\n");
        });
    }
}