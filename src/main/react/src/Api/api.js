
export const validateUser = (userData) => {  
  return new Promise((resolve, reject) => { 
    fetch('/user/validate', {method: 'POST', body: JSON.stringify(userData)})
      .then((response) => response.json())
      .then((res) => {
        resolve(res);
      })
      .catch((error) => {
        reject(error);
      });
  });
}

export const getAllUsers = () => {      
  return fetch('/user/all', {method: 'POST', headers: {'Content-Type': 'application/json'}, body: JSON.stringify({page: 0, size: 15}), credentials: 'same-origin'})
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

export const searchUsers = (text) => {      
  return fetch('/user/search', {method: 'POST', headers: {'Content-Type': 'application/json'}, body: JSON.stringify({text, page: 0, size: 15}), credentials: 'same-origin'})
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