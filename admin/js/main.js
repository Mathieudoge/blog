'use strict'

let redirection;
function deleteConfirm(e){
    e.preventDefault();
    $('#modal').modal('show');
    redirection = this.href;
}
function confirm(){
    location.href =  redirection
}
document.addEventListener('DOMContentLoaded', function(){
    $('.delete').on('click', deleteConfirm);
    $('.button').on('click', confirm);

})