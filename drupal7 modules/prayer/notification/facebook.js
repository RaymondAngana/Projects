/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var me = document.getElementById('facebook-jssdk');
console.log(me);
// This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log("start status");
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      profilePhotoAPI();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      console.log('nisam logiran');
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      //if not start login process
      console.log('nisam logiran');
      var loading_message = document.getElementById('loading-message');
      loading_message.innerHTML="Please logging using button or wait for pop dialog";
      FB.login();
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }
  //call back when user is logged in on facebook start to fetch login process
  var login_event = function(response) {

    if (response.status == 'connected') {
      profilePhotoAPI();

    }
  }
  var facbookApikey = 0;
  var host = new String(location.host);
  if (host.indexOf('localhost') === 0 || host.indexOf('0.0.0.0') === 0 || location.host == localStorage.getItem('path_local')) {
    facbookApikey = localStorage.getItem('fbapikey_local');
  }
  if (location.host == localStorage.getItem('path_dev') || location.host == localStorage.getItem('path_staging')) {
    facbookApikey = localStorage.getItem('fbapikey_dev');
  }
  if (location.host == localStorage.getItem('path_live')) {
    facbookApikey = localStorage.getItem('fbapikey_live');
  }

  window.fbAsyncInit = function() {
    FB.init({
      appId      : facbookApikey,
      cookie     : true,  // enable cookies to allow the server to access
                          // the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v3.0' // use version 2.1
    });

    // In your JavaScript
    //assign login event to facebook
    FB.Event.subscribe('auth.login', login_event);


    // Now that we've initialized the JavaScript SDK, we call
    // FB.getLoginStatus().  This function gets the state of the
    // person visiting this page and can return one of three states to
    // the callback you provide.  They can be:
    //
    // 1. Logged into your app ('connected')
    // 2. Logged into Facebook, but not your app ('not_authorized')
    // 3. Not logged into Facebook and can't tell if they are logged into
    //    your app or not.
    //
    // These three cases are handled in the callback function.

    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });


  };
  console.log("start to load");

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  if (me !== null) {
    window.fbAsyncInit();
  }

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function profilePhotoAPI() {
    console.log('Welcome!  Fetching your information.... ');
    var pic_wrapper = document.getElementById('fb-picture');

    FB.api('/me',
      "GET",
      {
        fields: "picture.width(180).height(180)",
      },
      function(response) {
        console.log('fetched');
        var pic_wrapper = document.getElementById('fb-picture');

        pic_wrapper.innerHTML = '<img id="facebook-profile-image" src="'+response.picture.data.url+'" alt="facebook profile image"/>';
        console.log('Successful login and fetching data');
        var login_button = document.getElementById('facebook-login-button');
        if (login_button !== null) {
          login_button.parentNode.removeChild(login_button);
        }

        //remove loading message
        var loading_message = document.getElementById('loading-message');
        if (loading_message !== null) {
          loading_message.parentNode.removeChild(loading_message);
        }
      }
    );
  }
