const profilePictureSelect = document.querySelector('#profilePictures');



profilePictureSelect.addEventListener('change', () => {
    changeProfilePicture(profilePictureSelect);
});


function changeProfilePicture(selectElement) {
    var profileImage = document.querySelector('#profileImage');
    var selectedValue = selectElement.value;
    profileImage.src = '../../public/images/profilePictures/' + selectedValue + '.png';
}
