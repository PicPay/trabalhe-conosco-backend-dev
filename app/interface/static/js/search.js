const MODEL = "<tr><td>{id}</td><td>{name}</td><td>{username}</td></tr>";
var temp;
function onResult(result){
    result= JSON.parse(result);
    console.log(result);

    html = "";

    result.map((r)=>{
        html+= MODEL.replace("{id}",r.id).replace("{name}",r.name).replace("{username}",r.username);
    });

    document.getElementById("search_result").innerHTML = html;
    unlockAll();
    
}

function search(){
   var search = document.getElementById("search").value;
   var page = document.getElementById("paginacao").value;
   
   page = page < 0? 0 : page;

   var url = "http://localhost:8080/search";
   var data = "page="+page+"&data="+search;

   lockAll();
   ajax.postAsyncTask(onResult,url,data);

   return false;
}

function pageNext(){
    var page = document.getElementById("paginacao");
    page.value++;
    search();
}


function pagePrev(){
    var page = document.getElementById("paginacao");
    page.value--;
    search();
}

function lockAll(){
    var btnSearch = document.getElementById("btn_search");
    var btnNext  = document.getElementById("btn_next");
    var btnPrev  = document.getElementById("btn_prev");

    var inputPag = document.getElementById("paginacao");
    var inputSearch = document.getElementById("search");

    inputSearch.disabled = inputPag.disabled = btnNext.disabled = btnPrev.disabled = btnSearch.disabled = true;
    temp = btnSearch.style.backgroundColor;
    btnPrev.style.backgroundColor = btnNext.style.backgroundColor = btnSearch.style.backgroundColor = "red";
}

function unlockAll(){
    var btnSearch = document.getElementById("btn_search");
    var btnNext  = document.getElementById("btn_next");
    var btnPrev  = document.getElementById("btn_prev");
    
    var inputPag = document.getElementById("paginacao");
    var inputSearch = document.getElementById("search");

    inputSearch.disabled = inputPag.disabled = btnNext.disabled = btnPrev.disabled = btnSearch.disabled = false;
    btnPrev.style.backgroundColor = btnNext.style.backgroundColor = btnSearch.style.backgroundColor = temp;
}