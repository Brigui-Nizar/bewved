let checkboxs = document.querySelectorAll('.checkboxbutton')
let labels = document.querySelectorAll('.checkboxlabel')


for (let i = 0; i < checkboxs.length; i++) {
    checkboxs[i].addEventListener("click", checkboxsbutton)
  }

  function checkboxsbutton(){
  for (let i = 0; i < checkboxs.length; i++) {
    checkboxs[i].checked == 1?labels[i].classList.add('checkboxlabelcheck'):labels[i].classList.remove('checkboxlabelcheck')
    /*  if (checkboxs[i].checked == 1){
            labels[i].classList.add('checkboxlabelcheck')
        }else{
            labels[i].classList.remove('checkboxlabelcheck')
        }  */
  }
}
checkboxsbutton()