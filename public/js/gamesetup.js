characterSetup = new Characters();

$(document).ready(() => {
    $(".GameSetup .start").click(() => {
        characterSetup.Create();
        return false;
    })
});

