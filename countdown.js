window.onload = updateClock;

var totalTime = 5;

function updateClock() {
  document.getElementById('countdown').innerHTML = totalTime;
  if(totalTime==0){
    console.log('Final');
  }else{
    totalTime-=1;
    setTimeout("updateClock()",1000);
  }
}