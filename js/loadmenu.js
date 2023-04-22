let loadMore = document.querySelector('#loadmenu');
let loadMore1 = document.querySelector('#loadmenu1');
let current = 3;

loadMore.onclick = () =>{
   let boxe = [...document.querySelectorAll('.menu .bmens .bmen')];
   let panjang = boxe.length;
   if(panjang % 3 >= 2){
        if( (current + 2) >= panjang ){
            for (var a = current; a < current + 2; a++){
                boxe[a].style.display = 'inline-block';
             }
            current+=2;
        }else{
            for (var a = current; a < current + 3; a++){
                boxe[a].style.display = 'inline-block';
             }
            current+=3;
        }
    }

    else if(panjang % 3 >= 1){
        if( (current + 1) >= panjang ){
            for (var a = current; a < current + 1; a++){
                boxe[a].style.display = 'inline-block';
             }
            current += 1;
        }else{
            for (var a = current; a < current + 3; a++){
                boxe[a].style.display = 'inline-block';
             }
            current+=3;
        }
    }

    else if(panjang % 3 >= 0){
        for (var a = current; a < current + 3; a++){
            boxe[a].style.display = 'inline-block';
         }
        current+=3;
    }

    if(current >= panjang){
        loadMore.style.display = 'none';
    }
  
    if(current >= 9){
        loadMore.style.display = 'none';
    }
  
    if(current < 9){
        loadMore1.style.display = 'none';
    }
  
    if(current >= 9){
        loadMore1.style.display = 'inline-block';
    }
}