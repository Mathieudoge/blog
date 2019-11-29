'use strict'

let deleteUserConfirm;
let test;
function deleteUser(e){
    e.preventDefault();
    $('#modal').modal('show');
    test = this.href;
}
function confirmDeleteUser(){
    location.href =  test
}
document.addEventListener('DOMContentLoaded', function(){
    $('.delete').on('click', deleteUser);
    $('.button').on('click', confirmDeleteUser);

})