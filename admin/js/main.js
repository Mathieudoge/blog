'use strict'

let deleteUserConfirm;

function deleteUser(e){
    e.preventDefault();
    alert('Êtes-vous sur de vouloir suprimmez cette utilisateur?')
    console.log(this);
}

document.addEventListener('DOMContentLoaded', function(){

    deleteUserConfirm = document.querySelector('.fa-trash-alt')
    deleteUserConfirm.addEventListener('click', deleteUser);

})