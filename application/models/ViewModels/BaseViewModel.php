<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/21/2017
 * Time: 10:59 PM
 */

namespace models\ViewModels;


class BaseViewModel implements IViewModel
{
    /** @var string */
    private $Title = "Tic Tac Toe";
    /** @var string */
    private $View = "";

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
        return $this;
    }
}