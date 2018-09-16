function onResult(result){
    console.log(result);
    result = JSON.parse(result);
    console.log(result);
    if (result.success == true) 
         alert("LoginOK");   //window.location.href = "/";
    else 
        alert("Senha invalida");
}

function submitLogin(){
   var login = document.getElementById("search").value;
   var senha = document.getElementById("pag").value;
   var url = "http://localhost:8080/login";
   var data = "username="+login+"&password="+senha

   ajax.postAsyncTask(onResult,url,data);
   return false;
}