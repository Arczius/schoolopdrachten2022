"use strict";

class ManageCookies{

  /**
  * a function used to create a cookie
  * 
  * @param {string} name - the name of the cookie
  * @param {string} val - the value the cookie will have when stored
  * @param {int} days - amount of days till the cookie expires
  * @param {string} sameSite - the samesite attribute for the cookie, choose between: none, Lax, Strict
  */
  create(name, val, days, sameSite){
      document.cookie = `${name}=${val};expires=${this.calculateDays(days)};path=/;SameSite=${sameSite}`;        
  }

  /**
  * return the value of the time it takes for a cookie to expire
  * @param {int} days - The amount of days a item has to go past to expire
  * @returns 
  */
  calculateDays(days){
      return new Date(new Date().getTime() + (days * 24 * 60 * 60 * 100));
  }

  /**
  * a function to check if a cookie existst 
  * @param {string} name - the name of the cookie it checks for if it exists
  * @returns 
  */
  exists(name){
      return document.cookie.includes(name);
  }

  /**
  * a function to read the value of a cookie
  * @param {string} name - the name of the cookie you want to know the value of
  * @returns
  */
  value(name){
    return (name = (document.cookie + ';').match(new RegExp(name + '=.*;'))) && name[0].split(/=|;/)[1];
  }

  /**
   * a function to delete a cookie, it does this by setting the expiration time for the cookie in about 1ms from the moment it is fired
   * @param {string} name - the name of the cookie you want to delete
   */
  delete(name){
      document.cookie = `${name}=null;expires=1;path=/;SameSite=Strict`;
  }
}