const MODEL = "<tr><td>{id}</td><td>{name}</td><td>{username}</td></tr>";
var temp;
function onResult(result){
    console.log(result);
    result= JSON.parse(result);
    console.log(result);

    html = "";

    result.map((r)=>{
        html+= MODEL.replace("{id}",r.id).replace("{name}",r.name).replace("{username}",r.username);
    });

    document.getElementById("search_result").innerHTML = html;
    var btn = document.getElementById("btn_search");
    btn.disabled = false;
    btn.style.backgroundColor = temp;
}

function search(){
   var search = document.getElementById("search").value;
   var page = document.getElementById("paginacao").value;
   var btn = document.getElementById("btn_search");

   btn.disabled = true;
   temp = btn.style.backgroundColor;
   btn.style.backgroundColor = "red";
   var url = "http://localhost:8080/search";
   var data = "page="+page+"&data="+search;
    console.log(data);
   ajax.postAsyncTask(onResult,url,data);
   return false;
}