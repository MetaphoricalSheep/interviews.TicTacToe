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
    private $Title = "Tic Tac Toe";

    /**
     * @return string
     */
    public function GetTitle() : string
    {
        return $this->Title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function SetTitle($title)
    {
        $this->Title = $title;
        return $this;
    }
}