

function UserDetails(idx) {
    var userDetail = document.getElementById(idx);
    console.log(idx);
    if(userDetail.style.display === 'none'){
        userDetail.style.display = 'block';

    }else{
        userDetail.style.display = 'none';

    }
    
}