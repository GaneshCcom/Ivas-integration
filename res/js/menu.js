const menu=document.querySelector('.menu');const menuSection=menu.querySelector('.menu-section');const menuArrow=menu.querySelector('.menu-mobile-arrow');const menuClosed=menu.querySelector('.menu-mobile-close');const menuTrigger=document.querySelector('.menu-mobile-trigger');const menuOverlay=document.querySelector('.overlay');let subMenu;menuSection.addEventListener('click',(e)=>{if(!menu.classList.contains('active')){return;}
if(e.target.closest('.menu-item-has-children')){const hasChildren=e.target.closest('.menu-item-has-children');showSubMenu(hasChildren);}});menuArrow.addEventListener('click',()=>{hideSubMenu();});menuTrigger.addEventListener('click',()=>{toggleMenu();});menuClosed.addEventListener('click',()=>{toggleMenu();});menuOverlay.addEventListener('click',()=>{toggleMenu();});function toggleMenu(){menu.classList.toggle('active');menuOverlay.classList.toggle('active');}
function showSubMenu(hasChildren){subMenu=hasChildren.querySelector('.menu-subs');subMenu.classList.add('active');subMenu.style.animation='slideLeft 0.5s ease forwards';const menuTitle=hasChildren.querySelector('i').parentNode.childNodes[0].textContent;menu.querySelector('.menu-mobile-title').innerHTML=menuTitle;menu.querySelector('.menu-mobile-header').classList.add('active');}
function hideSubMenu(){subMenu.style.animation='slideRight 0.5s ease forwards';setTimeout(()=>{subMenu.classList.remove('active');},300);menu.querySelector('.menu-mobile-title').innerHTML='';menu.querySelector('.menu-mobile-header').classList.remove('active');}
window.onresize=function(){if(this.innerWidth>991){if(menu.classList.contains('active')){toggleMenu();}}};




// ===== Scroll to Top ==== 
$(window).scroll(function() {
    if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
        $('#return-to-top').fadeIn(200);    // Fade in the arrow
    } else {
        $('#return-to-top').fadeOut(200);   // Else fade out the arrow
    }
});
$('#return-to-top').click(function() {      // When arrow is clicked
    $('body,html').animate({
        scrollTop : 0                       // Scroll to top of body
    }, 200);
});


function openNav() {
    document.getElementById("myNav").style.width = "482px";
}
  
function closeNav() {
    document.getElementById("myNav").style.width = "0%";
}




jQuery.noConflict();
(function( $ ) {
$('.inner-navr5 a').click(function(){
    $('html, body').animate({
        scrollTop: $( $(this).attr('href') ).offset().top - 110
    }, 500);
    return false;
});
})(jQuery);

// Create cookie
function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    let expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
// Delete cookie
function deleteCookie(cname) {
    const d = new Date();
    d.setTime(d.getTime() + (24*60*60*1000));
    let expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=;" + expires + ";path=/";
}
// Read cookie
function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
// Set cookie consent
function acceptCookieConsent(){
    deleteCookie('user_cookie_consent');
    setCookie('user_cookie_consent', 1, 30);
    document.getElementById("cookieNotice").style.display = "none";
}
let cookie_consent = getCookie("user_cookie_consent");
if(cookie_consent != ""){
    document.getElementById("cookieNotice").style.display = "none";
}else{
    document.getElementById("cookieNotice").style.display = "block";
}