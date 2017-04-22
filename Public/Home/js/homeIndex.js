/**
 * Created by Administrator on 2017/4/20.
 */
window.onload=function () {
    var oBody=document.getElementsByTagName('body')[0];
    var oMemberLogin=document.getElementById('memberLogin');
    var oMemberLoginFormSignIn=document.getElementById('memberLoginFormSignIn');
    var oCloseMemberLogoinForm=document.getElementById('closeMemberLogoinForm');
    var oNavigation=document.getElementById('navigation');
    var aA=oNavigation.getElementsByTagName('a');
    oMemberLoginFormSignIn.style.height=0;
    oMemberLogin.onclick=function(){
        oMemberLoginFormSignIn.style.height='479px';
        for(var i=0;i<aA.length;i++){
            a[i].style.backgroundPosition='-144px 0';
            a[i].style.color='#e4dec0';
        }
        this.style.backgroundPosition='0 0';
        this.style.color='#fff';
    }
    for(var i=0;i<aA.length;i++){
        aA[i].onclick=function(){
            for(var j=0;j<aA.length;j++){
                a[j].backgroundPosition='-144px 0';
                a[j].style.color='#e4dec0';
            }
            oMemberLogin.style.backgroundPosition='-144px 0';
            oMemberLogin.style.color='#e4dec0';
            this.style.backgroundPosition='0 0';
            this.style.color='#fff';
        }
    }
    oCloseMemberLogoinForm.onclick=function(){
        oMemberLoginFormSignIn.style.height=0;
    }
}
