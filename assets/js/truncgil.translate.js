$(function(){
    var data = [];
   $("h1,h2,h3,h4,h5,p,a,span").each(function(){
       var text = $(this).text().trim();
       if(text!="") {
        data.push(text);
       }
        
   });
//   console.log(JSON.stringify(data));
});