let boxes = [...document.querySelectorAll('.lokasi .bloks .blok')];
let boxe = [...document.querySelectorAll('.menu .bmens .bmen')];
let panjang = boxes.length;
let panjang1 = boxe.length;

if(panjang > 0){
    for (var a = 0; a < panjang; a++){
        boxes[a].style.display = 'inline-block';
    }
}
if(panjang1 > 0){
    for (var a = 0; a < panjang1; a++){
        boxe[a].style.display = 'inline-block';
    }
}