
export const validateUser = (userData) => {  
  return new Promise((resolve, reject) => { 
    let bodyData = {email: userData.email, name: userData.name}    
    fetch('/system/user/validate', {method: 'POST',headers: {'Content-Type': 'application/json'},  body: JSON.stringify(bodyData), credentials: 'same-origin'})
      .then((response) => response.json())
      .then((res) => {
        resolve(res);
      })
      .catch((error) => {
        reject(error);
      });
  });
}

export const searchUsers = (text, page, size) => { 
  let endpoint = text === '' ? '/user/all' : '/user/search';
  let body = text === '' ?  {page, size} : {page, size, text}
  return fetch(endpoint, {method: 'POST', headers: {'Content-Type': 'application/json'}, body: JSON.stringify(body), credentials: 'same-origin'})
  .then(response => {    
    if (response.ok) {
      return response.json();
    }      
    return {error: response.statusText};  
  }).then(json => {
      return json;
  }).catch(err =>  {
      return {error: err.message}
  });
}; 