function Toggle(UserDetailDivIDX) {
    var userDetail = document.getElementById(UserDetailDivIDX);
    console.log(UserDetailDivIDX);
    if(userDetail.style.display === 'none'){
        userDetail.style.display = 'block';

    }else{
        userDetail.style.display = 'none';

    }
}

function YouSure(){
    //Toggle();
}

function DeleteThread(Thread_IDX_DB, Thread_IDX_HTML){
    var thread = Thread_IDX_HTML;
    var xmlhttp = new XMLHttpRequest();

    console.log(Thread_IDX_DB + Thread_IDX_HTML);

    xmlhttp.open("GET","deleteThread.php?thread_id=" + Thread_IDX_DB);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send();

    xmlhttp.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){
            thread.style.display = "none";
            console.log("DELETED");
        }else{
            //thread.innerHTML = "Loading...";
            thread.style.display = "block";
            console.log("NOT DELETED");
        }
    }
}

function testFunction(){};