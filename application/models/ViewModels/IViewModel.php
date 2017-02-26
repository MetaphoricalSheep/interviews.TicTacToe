<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/21/2017
 * Time: 10:41 PM
 */

namespace models\ViewModels;


use Illuminate\Support\Collection;

interface IViewModel
{
    /** @return string */
    public function GetTitle() : string;

    /**
     * @var string $title
     * @return IViewModel
     */
    public function SetTitle(string $title) : IViewModel;

    /** @return string */
    public function GetView() : string;

    /**
     * @param string $path
     * @return IViewModel
     */
    public function SetView(string $path) : IViewModel;

    /** @return Collection **/
    public function GetJavaScript() : Collection;

    /**
     * @param string $path
     * @return IViewModel
     */
    public function SetJavaScript(string $path) : IViewModel;

    public function LoadJavaScript() : void;

    /** @return Collection */
    public function GetCss() : Collection;

    /**
     * @param string $path
     * @return IViewModel
     */
    public function SetCss(string $path) : IViewModel;

    public function LoadCss() : void;

    /**
     * @param string $path
     * @return IViewModel
     */
    public function SetPartial(string $path) : IViewModel;

    /**
     * @param null|string $path
     * @return string
     */
    public function GetPartial(string $path) : ?string;
}