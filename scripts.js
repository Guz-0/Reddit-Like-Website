function Toggle(UserDetailDivIDX) {
    var userDetail = document.getElementById(UserDetailDivIDX);
    console.log(UserDetailDivIDX);
    if(userDetail.style.display === 'none'){
        userDetail.style.display = 'block';

    }else{
        userDetail.style.display = 'none';

    }
}

function GetThreads(){
    Object.size = function(arr) {
        var size = 0;
        for (var key in arr) {
            if (arr.hasOwnProperty(key)) size++;
        }
        return size;
    };

    let threadArray;
    
    var user;
    var text;
    var date;
    var container = document.getElementById("container");

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET","searchDB.php?action=getThreads");
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send();

    xmlhttp.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){

            threadArray = JSON.parse(this.response);
            var arrayLen = Object.size(threadArray);

            for(var i=0;i<arrayLen;i++){
                user = threadArray[i].thread_user_id;
                text = threadArray[i].thread_text;
                date = threadArray[i].thread_date;
                
                container.innerHTML +=
                '<div class="wrapper-header"> <p class="user" id="user">From '+ user + '</p> <p class="text" id="text" >' + text +'</p> <p class="date" id="date">' + date + '</p> </div>';
            }

            console.log("DATA RECEIVED");

        }else{
            //thread.innerHTML = "Loading...";
            
            console.log("DATA NOT RECEIVED");
        }
    }
    

    console.log(threadArray);    
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

function addThread(user_id){
    var thread_text = document.getElementById("textarea").value;
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET","searchDB.php?action=addThread&user_id="+user_id+"&thread_text="+thread_text);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send();

    xmlhttp.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){
            console.log(this.response);
            GetThreads();
        }else{
            
        }
    }
}

GetThreads();