/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var me = document.getElementById('facebook-jssdk');
console.log(me);
var first_load = 0;
// This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback_4(response) {
    console.log("start status",first_load);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      //profilePhotoAPI();
      console.log("alerady login");
      if (first_load == 1){
        //trigger click on facebook button
        var element = document.getElementById('edit-facebook');
        element.click();

      }
      first_load = 1;
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      console.log('nisam logiran');
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      //if not start login process
      console.log('nisam logiran');

    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState_4() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback_4(response);
    });
  }

  //call back when user is logged in on facebook start to fetch login process
  var login_event_4 = function(response) {

    if (response.status == 'connected') {
      console.log('login is done');
      var element = document.getElementById('edit-facebook');
      element.click();
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
  console.log("start fb login");
  window.fbAsyncInit = function() {
    FB.init({
      appId      : facbookApikey,
      cookie     : true,  // enable cookies to allow the server to access
                          // the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v3.0' // use version 2.1
    });
    isLoaded = true;
    // In your JavaScript
    //assign login event to facebook
    FB.Event.subscribe('auth.login', login_event_4);

    console.log("init");
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
      statusChangeCallback_4(response);
    });


  };

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

  function fb_login(){
    FB.login(function(response) {
      if (response.authResponse) {
        console.log('Welcome!  Fetching your information.... ');
        //console.log(response); // dump complete info
        access_token = response.authResponse.accessToken; //get access token
        user_id = response.authResponse.userID; //get FB UID

        FB.api('/me', function(response) {
          // you can store this data into your database
        });

        checkLoginState_4();
      }
      else {
        //user hit cancel button
        console.log('User cancelled login or did not fully authorize.');
      }
    }, {scope: 'public_profile'});
  }
