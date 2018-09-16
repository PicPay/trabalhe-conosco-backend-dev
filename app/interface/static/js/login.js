function onResult(result){
    console.log(result);
    result = JSON.parse(result);
    console.log(result);
    if (result.success == true) 
         window.location.href = "/";
    else 
        alert("Senha invalida");
}

function submitLogin(){
   var login = document.getElementById("username").value;
   var senha = document.getElementById("password").value;
   var url = "http://localhost:8080/login";
   var data = "username="+login+"&password="+senha

   ajax.postAsyncTask(onResult,url,data);
   return false;
}