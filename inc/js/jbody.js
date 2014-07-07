function ce(parentid,targetid){
 var p=document.getElementById(parentid).getElementsByTagName(targetid);
for(i=0;i<p.length;i++){
 var c=document.createElement('span');
 p[i].insertBefore(c,p[i].firstChild);
 };
 };
document.write('<link rel="stylesheet" href="/inc/css/styles.css" />');
function ca(parentid,targetid,attr){
 var p=document.getElementById(parentid);
if(p){
 var t=document.createAttribute(targetid);
 t.value=attr;
 p.setAttributeNode(t);
 };
 };
window.onload=function(){
ce('navigation','a');
ce('sidemenu','a');
ce('home-go','a');
ce('content','h1');
ca('main','role','main');
ca('test','role','navigation');
ca('navigation','role','navigation');
ca('sidemenu','role','navigation');
ca('crumbs','role','navigation');
ca('links','role','navigation');
ca('legal','role','navigation');
ca('searchbox','role','search');
ca('features','role','complementary');
ca('footer','role','contentinfo');
};