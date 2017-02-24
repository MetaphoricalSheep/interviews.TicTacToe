function NewGameMenu() {
    var _items = [
        $(".NewGame .menu .item-1"),
        $(".NewGame .menu .item-2"),
        $(".NewGame .menu .item-3")
    ];

    var _active = _items[0];
    var _next = _items[1];
    var _previous = _items[2];
    var _start = $(".NewGame .menu .start");

    this.MoveDown = function() {
        _active.removeClass("active");
        var $oldActive = _active;
        _next.addClass("active");
        _active = _next;
        _next = _previous;
        _previous = $oldActive;
        _update();
    };

    this.MoveUp = function() {
        _active.removeClass("active");
        var $oldActive = _active;
        _previous.addClass("active");
        _active = _previous;
        _previous = _next;
        _next = $oldActive;
        _update();
    };

    this.Start = function() {
        _start[0].click();
    };

    var _update = function() {
        this.ActiveId = _active.data("id");
        _start.attr("href", "/game-setup/" + _active.data("id"));
        _start.text(_active.data("startLabel"));
    };

    _update();
}

menu = new NewGameMenu();

$(document).keydown(function (key) {
    switch (key.which) {
        case 13: // enter
            menu.Start();
            break;

        case 38: // up
            menu.MoveUp();
            break;

        case 40: // down
            menu.MoveDown();
            break;

        default: return;
    }
});
