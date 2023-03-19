let loadMoreBtn = document.querySelector('#load');
let currentItem = 3;

loadMoreBtn.onclick = () =>{
   let boxes = [...document.querySelectorAll('.lokasi .bloks .blok')];
   let panjang = boxes.length;
   if(panjang % 3 >= 2){
        if( (currentItem + 2) >= panjang ){
            for (var a = currentItem; a < currentItem + 2; a++){
                boxes[a].style.display = 'inline-block';
             }
            currentItem+=2;
        }else{
            for (var a = currentItem; a < currentItem + 3; a++){
                boxes[a].style.display = 'inline-block';
             }
            currentItem+=3;
        }
    }

    else if(panjang % 3 >= 1){
        if( (currentItem + 1) >= panjang ){
            for (var a = currentItem; a < currentItem + 1; a++){
                boxes[a].style.display = 'inline-block';
             }
            currentItem += 1;
        }else{
            for (var a = currentItem; a < currentItem + 3; a++){
                boxes[a].style.display = 'inline-block';
             }
            currentItem+=3;
        }
    }

    else if(panjang % 3 >= 0){
        for (var a = currentItem; a < currentItem + 3; a++){
            boxes[a].style.display = 'inline-block';
         }
        currentItem+=3;
    }

   if(currentItem >= boxes.length){
      loadMoreBtn.style.display = 'none';
   }
   console.log(currentItem)
}