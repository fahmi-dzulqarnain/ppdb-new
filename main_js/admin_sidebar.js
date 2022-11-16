window.onload = function () {  
    includeHTML('sidebar.html', "sidebar")

    setTimeout(setToImage('imgLogo', localStorage.logoSekolah), 3000)
};

function signOut() {
    localStorage.removeItem('accessToken')
    window.location.href = `${viewURL}`
}