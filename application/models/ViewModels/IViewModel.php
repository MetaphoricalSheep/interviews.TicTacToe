<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/21/2017
 * Time: 10:41 PM
 */

namespace models\ViewModels;


interface IViewModel
{
    /** @return string */
    public function GetTitle() : string;

    /** @var string $title */
    public function SetTitle($title);
}