const sideBtn = document.querySelector('.hamburger-menu');
const sideBack = document.querySelector('#sidebar-back');

let btnOpen = false;
sideBtn.addEventListener('click', () => {
    if (!btnOpen) {
        sideBtn.classList.add('open');
        btnOpen = true;

        document.querySelector('nav').classList.add('open');
    } 
});

sideBack.addEventListener('click', () => {
    if (btnOpen) {
        sideBtn.classList.remove('open');
        btnOpen = false;
        
        document.querySelector('nav').classList.remove('open');
    }
})

var counter = 1;
      setInterval(function(){
        document.getElementById('radio' + counter).checked = true;
        counter++;
        if(counter > 4){
          counter = 1;
        }
      }, 5000);

const headerSearch = document.querySelector('#header-input');
const navSearch = document.querySelector('#nav-input');
      const itemsContainer = document.querySelector('.items-grid');
      
headerSearch.addEventListener('input', searchEvent);
navSearch.addEventListener('input', searchEvent)
      
      function searchEvent(e){ 
          const text = e.target.value.toLowerCase();
          const items = itemsContainer.querySelectorAll('.item-box');
          Array.from(items).forEach(function(item){
              const itemList= item.children[1].textContent;
              console.log(item)
               if(itemList.toLowerCase().indexOf(text) !=-1){
                   item.style.display = 'block';
               } else{
                   item.style.display = 'none';
               }
          })
      }      

const loginButton = document.getElementsByClassName("btn login");
const signupButton = document.getElementsByClassName("btn signup");
const cartButton = document.getElementsByClassName("cart");
const logoutButton = document.getElementsByClassName("exit");
const deadLinks = document.querySelectorAll(".dead-links");

cartButton[0].addEventListener('click',() => {
    alert("Feature Coming Soon");
});

logoutButton[0].addEventListener('click',() => {
    alert("You've Been Logged Out");
});

for (let i = 0; i < deadLinks.length; i++) {
    deadLinks[i].addEventListener('click',() => {
        console.log("clicked");
        alert("Feature Coming Soon");
    });
}