function deleteCookie(cookieName) {
    document.cookie = cookieName + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}

logoutButton = document.querySelector("#logout");

logoutButton.addEventListener('click', () =>{
    deleteCookie('user_data')
});