# Interview Project: Tic Tac Toe

This is a Tic Tac Toe game that I wrote for a Senior PHP developer interview.

The project was created using CodeIgniter 3.1.3, bootstrap 4.0.0-alpha.6 and Doctrine 2 running on PHP 7.1.0 and Percona-Server 5.7 (Mysql Fork). 
Please stay away from IE...
I tested it quickly on Firefox and it seemed fine. I used the latest build of Chrome while developing.


## The Specification

> Using the Codeigniter framework (http://www.codeigniter.com/), build a tic tac toe game with the following features:
> * Take a name for the two players and begin a new game.
> * Use basic styling for the grid using css.
> * Allow the players to click the grid to make their move, and highlight when the game is finished.
> * Store the results of each match in a MySQL database, and have a page to view the results.
> * Use the bootstrap framework to make it responsive in the following ways:
>   * On mobile device, make the game full screen.
>   * On desktop browser have the results of the last 5 matches on the right hand side – do this in bootstrap, not php.
>
> * If you have more time, then please look at making an option of playing against the computer


## Prerequisites

You will need the following properly installed on your computer.

* [Git](http://git-scm.com/)
* [PHP 7.1.2](http://php.net/downloads.php)
* [MySQL 5.7](http://dev.mysql.com/downloads/)


## Installation

* `$ git clone https://github.com/MetaphoricalSheep/interviews.TicTacToe.git ./TicTacToe`
* `$ cd TicTacToe/application`
* `$ php composer.phar update`
* `$ vim config/database.php`
* `$ echo "create database TicTacToe" | mysql -u <user> -p<password>`
* `$ php cli-doctrine.php orm:schema-tool:create`
* `$ php cli.php seed:types`
* `$ php cli.php seed:marvin`


## Running

* `$ cd path/to/project/TicTacToe/public`
* `$ php -S [ip]:8000`
* Open Chrome and point it to [ip]:8000


## Todo

* The results page was a rush job. I missed it in the spec. Added it quickly as an afterthought. It needs refining.
* Marvin (the AI) always plays on the most difficult level at the moment. I need to add different difficulty levels.
* The history side bar hides on smaller screen sizes, but that is about the only thing that is currently responsive on this project.

I was busy implementing a multiplayer mode, but I ran out of time. The idea is to have both players' browsers connect to a pub/sub which will feed them updates as needed. The GameApi layer (and frontend) is the only thing that needs to change to facilitate this.
