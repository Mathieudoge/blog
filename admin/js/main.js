'use strict'

let deleteUserConfirm;
let redirection;
function deleteConfirm(e){
    e.preventDefault();
    $('#modal').modal('show');
    redirection = this.href;
}
function edit(e){
    e.preventDefault();
    $('#modal').modal('show');
    redirection = this.href;
}
function confirm(){
    location.href =  redirection
}
document.addEventListener('DOMContentLoaded', function(){
    $('.delete').on('click', deleteUConfirm);
    $('.button').on('click', confirm);
    $('.edit').on('click', deleteUConfirm);

})