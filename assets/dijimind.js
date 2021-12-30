//spyhzer js

var app = new Framework7({
    // App root element
    el: '#app',
    // App Name
    name: 'Sphyzer',
    // App id
    
    id: 'com.truncgil.dijimind',
    // Enable swipe panel
    panel: {
      swipe: true,
    },
    on: {
      // each object key means same name event handler
      pageInit: function (page) {
        // do something on page init
        console.log("init");
      },
      popupOpen: function (popup) {
        // do something on popup open
      },
    },
    // Add default routes 
    routes: [
      {
        path: '/',
        url: 'index',
      },
      {
        name : "iletisim",
        path : "/app/(.*)",
        url : "iletisim"
      }
    ],
    // ... other parameters
  });
  
  var mainView = app.views.create('.view-main');

