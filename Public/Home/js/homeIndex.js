/**
 * Created by Administrator on 2017/4/20.
 */
window.onload=function () {
    var oMemberLogin=document.getElementById('memberLogin');
    var oMemberLoginFormSignIn=document.getElementById('memberLoginFormSignIn');
    var oCloseMemberLogoinForm=document.getElementById('closeMemberLogoinForm');
    var oNavigation=document.getElementById('navigation');

    var oUserLogin=document.getElementById('userLogin');
    var oUserLoginFormSignIn=document.getElementById('userLoginFormSignIn');
    var oCloseUserLogoinForm=document.getElementById('closeUserLogoinForm');
    var aA=oNavigation.getElementsByTagName('a');
    oMemberLoginFormSignIn.style.height=0;
    oMemberLogin.onclick=function(){
        oMemberLoginFormSignIn.style.height='479px';
        oUserLoginFormSignIn.style.height=0;
        for(var i=0;i<aA.length;i++){
            a[i].style.backgroundPosition='-144px 0';
        }
        oUserLogin.style.backgroundPosition='-144px 0';
        this.style.backgroundPosition='0 0';
    }
    oCloseMemberLogoinForm.onclick=function(){
            oMemberLoginFormSignIn.style.height=0;
    }
//会员框User
    oUserLoginFormSignIn.style.height=0;
    oUserLogin.onclick=function(){
        oUserLoginFormSignIn.style.height='479px';
        oMemberLoginFormSignIn.style.height='0';
        for(var i=0;i<aA.length;i++){
            a[i].style.backgroundPosition='-144px 0';
        }
        oMemberLogin.style.backgroundPosition='-144px 0';
        this.style.backgroundPosition='0 0';
    }
    for(var i=0;i<aA.length;i++){
        aA[i].onclick=function(){
            for(var j=0;j<aA.length;j++){
                a[j].backgroundPosition='-144px 0';
            }
            oMemberLogin.style.backgroundPosition='-144px 0';
            oUserLogin.style.backgroundPosition='-144px 0';
            this.style.backgroundPosition='0 0';
        }
    }
    oCloseUserLogoinForm.onclick=function(){
        oUserLoginFormSignIn.style.height=0;
    }
    //shangpin
    var oShowMark=document.getElementById('showMark');
    oShowMark.onclick=function(){
        this.style.display='block';
    }
}
