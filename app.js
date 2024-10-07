const search = document.querySelector('#input');
const itemsContainer = document.querySelector('.items-grid');

search.addEventListener('input', searchEvent);

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