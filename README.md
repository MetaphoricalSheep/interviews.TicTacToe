# Interview Project: Tic Tac Toe

This is a Tic Tac Toe game that I wrote for a Senior PHP developer interview.

* I used the CodeIgniter 3.1.3 framework
* I used Eloqent ORM
* I used bootstrap
* I used composer


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
* [PHP 7](http://php.net/downloads.php)
* [MySQL](http://dev.mysql.com/downloads/)


## Installation

* `$ git clone https://github.com/MetaphoricalSheep/interviews.TicTacToe.git`
* `$ cd interview.TicTacToe`
* `$ php application/composer.phar install`
* `$ vim application/config/database.php`
* `$ mysql -u <username> -p<password> < database.sql`


## Running

* `$ cd path/to/project/interviews.TicTacToe`
* `$ php -S [ip]:8000`
* Open Chrome and point it to [ip]:8000 -t src/


## External packages used
