/**
 * by griga
 */


export function addClassName(el: any, classNames: any): any{
  if(! Array.isArray(classNames)){
    classNames = [classNames]
  }

  classNames.forEach((className)=>{
    if (el.classList){
      el.classList.add(className);
    } else{
      el.className += ' ' + className;
    }
  });

  return el;

}

export function removeClassName(el: any, classNames: any): any{
  if(! Array.isArray(classNames) ){
    classNames = [classNames]
  }

  classNames.forEach((className)=>{
    if (el.classList){
      el.classList.remove(className);
    } else{
      el.className = el.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
    }
  });

  return el;

}


