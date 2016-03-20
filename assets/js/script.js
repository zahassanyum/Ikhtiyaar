
window.fbAsyncInit = function() {
    FB.init({
        appId      : '249684425365723',
        xfbml      : true,
        version    : 'v2.5'
    });
};

// Load the SDK asynchronously
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


function fb_login(myDropzone) {
    FB.login(function(response) {
        if (response.authResponse) {
            document.cookie = 'fb_token=' + response.authResponse.accessToken;
            // document.cookie = 'fb_user_id=' + response.authResponse.userID;
            disableSubmitButton();
            myDropzone.processQueue();
        } else {
            show_error("You must login using your Facebook account first to post your complaint.");
            return false;
        }
    }, {scope: 'public_profile, email'});
    return true;
}

$(document).ready(function() {

    $("#location").geocomplete({
        location: "Peshawar, Pakistan",
        details: "#location-details"
    });

    if ($.fn.lightcase) {
        $('a[data-rel^=lightcase]').lightcase();
    }
});

