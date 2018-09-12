<div id="splash"  class="flex-container" 
        style ="z-index: 9999999; background-image: url('/presta_pp/img/bigstock-Gray-Background-3368923.jpg');  height: 100%; 
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover; display: none"  >
      <!--   <input class="full-chk" id="full-menu" type="checkbox" />

        <label class="full-cntr" for="full-menu" >
          <span class="full-span"></span>
          <span class="full-span"></span>
          <span class="full-span"></span>
        </label> -->
        <img class="full-img" src="http://polyplace.ma/img/polyplace-logo-1516623280.jpg">

       <!--  <nav class="full-nav-sht" >
          <ul class="full-nav-sht-ul">
            <section class="full-nav-sht-cntr">
              <li>
                <p class="full-nav-sht-p">
                  <a class="full-nav-sht-a" href="#">
                    <span class="full-nav-sht-hltd">HOME</span>
                  </a>
                </p>
              </li>
              <li>
                <p class="full-nav-sht-p">
                  <a class="full-nav-sht-a" href="#">
                    <span class="full-nav-sht-hltd">CONTACT</span>
                  </a>
                </p>
              </li>
            </section>
          </ul>
        </nav> -->
    
     <!--Center align Splash contents in all screen sizes-->
         <div class ="flex-item" >
           <div class="container">
             <div class="pol">
              <ul>
              {foreach item=v from=$item}
                <li><a href="{$v.link_cat}"><img class="img-responsive " src="{$link->getMediaLink($smarty.const._MODULE_DIR_)}shtsplashcategories/img/{$v.image_cat}" title="{$v.titre}" alt="app_icon" /><h5>{$v.titre}</h5></a></li>    
              {/foreach}
              </ul>                
             </div>            
           </div>
       
         </div>
     </div>
  <!--  Scripts-->
  {literal}

  <script type="text/javascript">
    
    function fade(element) {
    var op = 1;  // initial opacity
    var timer = setInterval(function () {
        if (op <= 0.1){
            clearInterval(timer);
          
            element.style.display = 'none';
        }
        element.style.opacity = op;
        element.style.filter = 'alpha(opacity=' + op * 100 + ")";
        op -= op * 0.1;
    }, 50);
}
 if (sessionStorage.getItem('splash') !== 'true') {
        $('#splash').show();
        document.body.style.overflow = 'hidden';
        sessionStorage.setItem('splash','true');
    }
    // setTimeout(function(){ 
          
    //          if(typeof(Storage) !== "undefined") {
         
    //           console.log("Already shown" +sessionStorage.getItem('spalashShown'));

    //            if( !sessionStorage.getItem('spalashShown') || sessionStorage.getItem('spalashShown') === null ) {  
                 
    //            document.getElementById('splash') .style.display = 'inline';

    //             //Display splash
    //             setTimeout(function(){   

    //              fade(document.getElementById('splash'));
    //               // document.getElementById('splash') .style.display = 'none'
    //               // window.location = "http://hiteshsahu.com";
                  
    //              sessionStorage.setItem('spalashShown', true  );
    //           }
    //            ,6000);
      
    //               } else {
                    
    //                  //Display Main Content
    //                   document.getElementById('splash') .style.display = 'none'
    //                     console.log("Already shown");
    //                  }
    //               }
         
    //             else {
    //                     document.getElementById("result").innerHTML = "Sorry, your browser does not support web storage...";
    //                   }
    //                      }, 0);

    </script>
    {/literal}