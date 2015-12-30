function sevenAte9(str){
var newStr = [];
  for(i = 0; i < str.length; i++) {
    if(str[i]=="7") {
      if(str[i+2]=="7") {
        if(str[i+1]=="9") {
          let fbit = str.slice(0,i+1), lbit = str.slice(i+2);
          let newStr = fbit + lbit;
          return(sevenAte9(newStr));
        }
        else{
          newStr.push(str[i]);
        }
      }
      else{
        newStr.push(str[i]);
      }
    }
    else{
     newStr.push(str[i]);
    }
}
    return(newStr);
  }


  function validate(input){
    if(!input[0].match(/[a-z]/i)) {
    return(false);
    }
    else
    {
          var atPos =  input.search(/@/);
          var preFix = input.slice(0,atPos);
          for(j = 0; j < preFix.length; ++j) {
//          console.log(j);
          if(!preFix[j].match(/[a-z0-9_\.]/i)) {
              return(false);
              }
          }
          var sufFix = input.slice(atPos);
          var atPosSuf =  sufFix.search(/\./);
          if(atPosSuf < 2) {
          return(false);
          }
          else {
          if(!sufFix.match(/[a-z0-9_\.\@]/i)) {
              return(false);
              }
              else {
              return(true);
              }
            }
          }

}
