(window.webpackJsonp=window.webpackJsonp||[]).push([[0],{128:function(e){e.exports={web:{client_id:"306705764486-8hcnjbcj8gen1344pttlct5fond9iltr.apps.googleusercontent.com",project_id:"recommendation-l-1545398385520",auth_uri:"https://accounts.google.com/o/oauth2/auth",token_uri:"https://www.googleapis.com/oauth2/v3/token",auth_provider_x509_cert_url:"https://www.googleapis.com/oauth2/v1/certs",client_secret:"g5g3zInFjyrBA8S7kFJD25QM",javascript_origins:["http://localhost:8080"]}}},146:function(e,t,a){e.exports=a(329)},327:function(e,t,a){},329:function(e,t,a){"use strict";a.r(t);var n=a(25),r=a.n(n),s=a(0),o=a.n(s),i=a(26),l=a(331),c=a(333),p=a(334),u=a(124),m=a(36),h=a(144),g={user:{users:[],totalElements:0,totalPages:0,page:0,size:15,text:""},message:{show:!1,text:"",messageType:""}},d="SEARCH_USERS_REQUEST",f="SEARCH_USERS_SUCCESS",E="SEARCH_USERS_FAILURE",b="SHOW_MESSAGE",y=a(125),v=a.n(y),O=Object(m.c)({user:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:g.user,t=arguments.length>1?arguments[1]:void 0;switch(t.type){case f:return v()(e,{users:{$set:t.users},text:{$set:t.text},page:{$set:t.page},totalElements:{$set:t.totalElements},totalPages:{$set:t.totalPages}});default:return e}},message:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:g.message,t=arguments.length>1?arguments[1]:void 0;switch(t.type){case b:return{text:t.message.text,show:t.message.show,messageType:t.message.messageType};default:return e}}}),j=a(33),w=a.n(j),x=a(27),S=function(e){return new Promise(function(t,a){var n={email:e.email,name:e.name};fetch("/system/user/validate",{method:"POST",headers:{"Content-Type":"application/json"},body:JSON.stringify(n),credentials:"same-origin"}).then(function(e){return e.json()}).then(function(e){t(e)}).catch(function(e){a(e)})})},C=function(e,t,a){var n=""===e?{page:t,size:a}:{page:t,size:a,text:e};return fetch(""===e?"/user/all":"/user/search",{method:"POST",headers:{"Content-Type":"application/json"},body:JSON.stringify(n),credentials:"same-origin"}).then(function(e){return e.ok?e.json():{error:e.statusText}}).then(function(e){return e}).catch(function(e){return{error:e.message}})},k=a(126),N=a.n(k),_=w.a.mark(M),I=new N.a;function M(e){var t,a,n;return w.a.wrap(function(r){for(;;)switch(r.prev=r.next){case 0:return r.next=2,Object(x.b)(C,e.text,e.page,e.size);case 2:if((t=r.sent).error){r.next=9;break}return a=t.content.map(function(e){var t=e.id,a=e.userName,n=e.name,r=e.priority;return{_id:I.guid(),id:t,userName:a,name:n,priority:r}}),r.next=7,[Object(x.d)({type:f,users:a,text:e.text,page:t.number,totalElements:t.totalElements,totalPages:t.totalPages})];case 7:r.next=12;break;case 9:return n={text:t.error,messageType:"FAILURE",show:!0},r.next=12,[Object(x.d)({type:E,response:t}),Object(x.d)({type:b,message:n})];case 12:case"end":return r.stop()}},_,this)}var T=w.a.mark(z);function z(){return w.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,Object(x.e)(d,M);case 2:case"end":return e.stop()}},T,this)}var R=w.a.mark(P);function P(){return w.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,Object(x.a)([Object(x.c)(z)]);case 2:case"end":return e.stop()}},R,this)}var A="object"===typeof window&&window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__?window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__({}):m.d,D=Object(h.a)(),L=A(Object(m.a)(D)),U=function(){return Object(u.a)({},Object(m.e)(O,L),{runSaga:D.run(P)})},B=a(20),F=a(21),J=a(23),G=a(22),H=a(24),$=a(127),V=a(332),X=a(128),W=function(e){function t(e){var a;return Object(B.a)(this,t),(a=Object(J.a)(this,Object(G.a)(t).call(this,e))).onSignInSuccess=function(e){if(e.w3.U3){var t={name:e.w3.ig,email:e.w3.U3,provider_id:e.El,token:e.Zi.access_token,provider_pic:e.w3.Paa};S(t).then(function(e){e.content.length>0?(sessionStorage.setItem("userData",JSON.stringify(t)),a.setState({redirect:!0})):a.setState({loginError:!0})}).catch(function(e){a.setState({loginError:!0})})}},a.onSignInFailure=function(e){console.log(e),a.setState({loginError:!0})},a.state={loginError:!1,redirect:!1},a}return Object(H.a)(t,e),Object(F.a)(t,[{key:"render",value:function(){var e=sessionStorage.getItem("userData");return this.state.redirect||e&&e.name?o.a.createElement(V.a,{to:"/home"}):o.a.createElement("div",{className:"container"},o.a.createElement("div",{className:"row"},o.a.createElement("div",{style:{marginTop:"100px"},className:"col-sm-9 col-md-7 col-lg-5 mx-auto"},o.a.createElement("div",{className:"card my-5"},o.a.createElement("div",{className:"card-body"},o.a.createElement("div",{style:{marginBottom:"10px",display:"flex",alignItems:"center",justifyContent:"center"}},o.a.createElement("img",{alt:"",style:{width:"400px"},src:"/picpay-extended.png"})),o.a.createElement("div",{style:{display:"flex",justifyContent:"center",marginTop:"10px",marginBottom:"50px",alignItems:"center"}},o.a.createElement($.GoogleLogin,{clientId:X.web.client_id,theme:"light",buttonText:!e||e&&!e.name?"Sign in with Google":"Sign out",onSuccess:this.onSignInSuccess,onFailure:this.onSignInFailure})),o.a.createElement("div",{style:{color:"red",textAlign:"center"}},this.state.loginError?"You're not authorized to sign in.":null))))))}}]),t}(s.Component),Q=Object(i.b)()(W),q=function(e,t,a){return{type:d,text:e,page:t,size:a}},Y=a(83),Z=a.n(Y),K=a(84),ee=a.n(K),te=a(131),ae=a.n(te),ne=a(130),re=a.n(ne),se=a(66),oe=a.n(se),ie=a(50),le=a.n(ie),ce=a(78),pe=a(80),ue=a.n(pe),me=a(88),he=a.n(me),ge=a(87),de=a.n(ge),fe=a(129),Ee=a.n(fe),be=function(e){function t(){var e,a;Object(B.a)(this,t);for(var n=arguments.length,r=new Array(n),s=0;s<n;s++)r[s]=arguments[s];return(a=Object(J.a)(this,(e=Object(G.a)(t)).call.apply(e,[this].concat(r)))).state={value:""},a.handleChange=function(e){a.setState({value:e}),""!==e?a.props.dispatch(q(e,a.props.user.page,a.props.user.size)):a.props.dispatch(q("",a.props.user.page,a.props.user.pagination))},a}return Object(H.a)(t,e),Object(F.a)(t,[{key:"render",value:function(){var e=this;return o.a.createElement(Ee.a,{style:{height:"40px",width:"400px"},value:this.state.value,onChange:this.handleChange,onRequestSearch:function(){return""!==e.state.value?e.props.dispatch(q(e.state.value,e.props.user.page,e.props.user.size)):e.props.dispatch(q("",e.props.user.page,e.props.user.size))}})}}]),t}(s.Component),ye=Object(i.b)(function(e){return{user:e.user}})(be),ve=a(86),Oe=a.n(ve),je=a(132),we=a.n(je),xe=function(e){function t(){var e,a;Object(B.a)(this,t);for(var n=arguments.length,r=new Array(n),s=0;s<n;s++)r[s]=arguments[s];return(a=Object(J.a)(this,(e=Object(G.a)(t)).call.apply(e,[this].concat(r)))).handleIncreasePage=function(){a.props.user.page<=a.props.user.totalPages&&a.props.dispatch(q(a.props.user.text,a.props.user.page+1,a.props.user.size))},a.handleDecreasePage=function(){a.props.user.page>0&&a.props.dispatch(q(a.props.user.text,a.props.user.page-1,a.props.user.size))},a}return Object(H.a)(t,e),Object(F.a)(t,[{key:"componentDidMount",value:function(){this.props.dispatch(q("",this.props.user.page,this.props.user.size))}},{key:"render",value:function(){var e=this.props,t=e.user,a=e.classes;return o.a.createElement("div",null,o.a.createElement("div",{style:{display:"flex",marginTop:"10px"}},o.a.createElement("div",{style:{display:"flex"}},o.a.createElement(ye,null)),o.a.createElement("div",{style:{display:"flex",flexGrow:"1",justifyContent:"flex-end"}},0!==this.props.user.totalElements?o.a.createElement(le.a,{style:{color:"white",fontWeight:"600",fontSize:"15px",display:"flex",alignItems:"center"}},(t.page*t.size+1).toString().toLocaleString()," - ",((t.page+1)*t.size).toString().toLocaleString()," of ",t.totalElements.toLocaleString()):null,o.a.createElement(de.a,{disabled:0===this.props.user.totalElement||this.props.user.page<=0,style:{marginLeft:"7px",backgroundColor:"white"},variant:"contained",color:"default",className:a.button,onClick:this.handleDecreasePage},o.a.createElement(he.a,{className:a.rightIcon},"keyboard_arrow_left")),o.a.createElement(de.a,{disabled:0===this.props.user.totalElements||this.props.user.page>this.props.user.totalPages,style:{marginLeft:"7px",backgroundColor:"white"},variant:"contained",color:"default",className:a.button,onClick:this.handleIncreasePage},o.a.createElement(he.a,{className:a.rightIcon},"keyboard_arrow_right")))),o.a.createElement(Z.a,{component:"nav",style:{height:"780px",paddingTop:"0px",marginTop:"15px"},className:a.root},t.users.map(function(e){return o.a.createElement(ee.a,{key:e.id,className:"user-item",style:{paddingTop:"3px"},alignItems:"flex-start",button:!0},o.a.createElement(re.a,null,o.a.createElement(oe.a,{alt:e.name,src:"https://randomuser.me/api/portraits/"+(1===Oe.a.random(1,2)?"men":"women")+"/"+Oe.a.random(0,99)+".jpg",className:a.avatar})),o.a.createElement(ae.a,{primary:e.name,secondary:o.a.createElement(o.a.Fragment,null,o.a.createElement(le.a,{component:"span",className:a.inline},e.userName))}),o.a.createElement(we.a,{label:2===e.priority?"list 1":1===e.priority?"list 2":"no priority",color:2===e.priority?"secondary":1===e.priority?"primary":"default",className:a.chip}))})))}}]),t}(s.Component),Se=Object(i.b)(function(e){return{user:e.user}})(Object(ce.withStyles)(function(e){return{root:{width:"100%",overflow:"auto"},inline:{display:"inline"},purpleAvatar:{color:"#fff",backgroundColor:ue.a[500]},chip:{margin:e.spacing.unit}}})(xe)),Ce=a(37),ke=a(134),Ne=a.n(ke),_e=a(135),Ie=a.n(_e),Me=a(38),Te=a.n(Me),ze=a(45),Re=a.n(ze),Pe=a(51),Ae=a.n(Pe),De=a(34),Le=a(136),Ue=a.n(Le),Be=a(133),Fe=a.n(Be),Je=a(137),Ge=a.n(Je),He=function(e){function t(e){var a;return Object(B.a)(this,t),(a=Object(J.a)(this,Object(G.a)(t).call(this,e))).handleMenu=function(e){a.setState({anchorEl:e.currentTarget})},a.handleClose=function(){a.setState({anchorEl:null})},a.handleLogout=function(){a.setState({anchorEl:null}),sessionStorage.setItem("userData",null)},a.state={anchorEl:null},a}return Object(H.a)(t,e),Object(F.a)(t,[{key:"render",value:function(){var e=Boolean(this.state.anchorEl),t=this.props.classes,a=JSON.parse(sessionStorage.getItem("userData"));return a&&a.name?o.a.createElement("div",null,o.a.createElement(oe.a,{alt:a.name,onClick:this.handleMenu,src:a.provider_pic,className:t.avatar}),o.a.createElement(Ae.a,{style:{width:"400px",height:"250px"},anchorEl:this.state.anchorEl,anchorOrigin:{vertical:"top",horizontal:"right"},transformOrigin:{vertical:"top",horizontal:"right"},open:e,onClose:this.handleClose},o.a.createElement(Re.a,{onClick:this.handleLogout},"Logout"))):o.a.createElement(V.a,{to:"/"})}}]),t}(o.a.Component),$e=Object(ce.withStyles)({avatar:{margin:10},bigAvatar:{margin:10,width:60,height:60}})(He),Ve=function(e){function t(){var e,a;Object(B.a)(this,t);for(var n=arguments.length,r=new Array(n),s=0;s<n;s++)r[s]=arguments[s];return(a=Object(J.a)(this,(e=Object(G.a)(t)).call.apply(e,[this].concat(r)))).state={anchorEl:null,mobileMoreAnchorEl:null},a.handleProfileMenuOpen=function(e){a.setState({anchorEl:e.currentTarget})},a.handleMenuClose=function(){a.setState({anchorEl:null}),a.handleMobileMenuClose()},a.handleMobileMenuOpen=function(e){a.setState({mobileMoreAnchorEl:e.currentTarget})},a.handleMobileMenuClose=function(){a.setState({mobileMoreAnchorEl:null})},a}return Object(H.a)(t,e),Object(F.a)(t,[{key:"render",value:function(){var e=this.state,t=e.anchorEl,a=e.mobileMoreAnchorEl,n=this.props.classes,r=Boolean(t),s=Boolean(a),i=o.a.createElement(Ae.a,{anchorEl:t,anchorOrigin:{vertical:"top",horizontal:"right"},transformOrigin:{vertical:"top",horizontal:"right"},open:r,onClose:this.handleMenuClose},o.a.createElement(Re.a,{onClick:this.handleMenuClose},"Profile"),o.a.createElement(Re.a,{onClick:this.handleMenuClose},"My account")),l=o.a.createElement(Ae.a,{anchorEl:a,anchorOrigin:{vertical:"top",horizontal:"right"},transformOrigin:{vertical:"top",horizontal:"right"},open:s,onClose:this.handleMobileMenuClose},o.a.createElement(Re.a,{onClick:this.handleProfileMenuOpen},o.a.createElement(Te.a,{color:"inherit"},o.a.createElement(Fe.a,null)),o.a.createElement("p",null,"Profile")));return o.a.createElement("div",{className:n.root},o.a.createElement(Ne.a,{style:{backgroundColor:"white",padding:"0px"},position:"absolute"},o.a.createElement(Ie.a,null,o.a.createElement(Te.a,{className:n.menuButton,color:"default","aria-label":"Open drawer"},o.a.createElement(Ue.a,null)),o.a.createElement("img",{alt:"",style:{width:"110px"},src:"/picpay-extended.png"}),o.a.createElement("div",{className:n.grow}),o.a.createElement("div",{className:n.sectionDesktop},o.a.createElement($e,null)),o.a.createElement("div",{className:n.sectionMobile},o.a.createElement(Te.a,{"aria-haspopup":"true",onClick:this.handleMobileMenuOpen,color:"inherit"},o.a.createElement(Ge.a,null))))),i,l)}}]),t}(o.a.Component),Xe=Object(ce.withStyles)(function(e){return{root:{width:"100%"},grow:{flexGrow:1},menuButton:{marginLeft:-12,marginRight:20},title:Object(Ce.a)({display:"none"},e.breakpoints.up("sm"),{display:"block"}),search:Object(Ce.a)({position:"relative",borderRadius:e.shape.borderRadius,backgroundColor:Object(De.fade)(e.palette.common.white,.15),"&:hover":{backgroundColor:Object(De.fade)(e.palette.common.white,.25)},marginRight:2*e.spacing.unit,marginLeft:0,width:"100%"},e.breakpoints.up("sm"),{marginLeft:3*e.spacing.unit,width:"auto"}),searchIcon:{width:9*e.spacing.unit,height:"100%",position:"absolute",pointerEvents:"none",display:"flex",alignItems:"center",justifyContent:"center"},inputRoot:{color:"inherit",width:"100%"},inputInput:Object(Ce.a)({paddingTop:e.spacing.unit,paddingRight:e.spacing.unit,paddingBottom:e.spacing.unit,paddingLeft:10*e.spacing.unit,transition:e.transitions.create("width"),width:"100%"},e.breakpoints.up("md"),{width:200}),sectionDesktop:Object(Ce.a)({display:"none"},e.breakpoints.up("md"),{display:"flex"}),sectionMobile:Object(Ce.a)({display:"flex"},e.breakpoints.up("md"),{display:"none"})}})(Ve),We=a(143),Qe=a.n(We),qe=a(145),Ye=a(8),Ze=a.n(Ye),Ke=a(138),et=a.n(Ke),tt=a(140),at=a.n(tt),nt=a(141),rt=a.n(nt),st=a(142),ot=a.n(st),it=a(81),lt=a.n(it),ct=a(82),pt=a.n(ct),ut=a(85),mt=a.n(ut),ht=a(139),gt=a.n(ht),dt={success:et.a,warning:gt.a,error:at.a,info:rt.a},ft=function(e){function t(){return Object(B.a)(this,t),Object(J.a)(this,Object(G.a)(t).apply(this,arguments))}return Object(H.a)(t,e),Object(F.a)(t,[{key:"render",value:function(){var e=this.props,t=e.classes,a=e.className,n=e.message,r=e.onClose,s=e.variant,i=Object(qe.a)(e,["classes","className","message","onClose","variant"]),l=dt[s];return o.a.createElement(mt.a,Object.assign({className:Ze()(t[s],a),"aria-describedby":"client-snackbar",message:o.a.createElement("span",{id:"client-snackbar",className:t.message},o.a.createElement(l,{className:Ze()(t.icon,t.iconVariant)}),n),action:[o.a.createElement(Te.a,{key:"close","aria-label":"Close",color:"inherit",className:t.close,onClick:r},o.a.createElement(ot.a,{className:t.icon}))]},i))}}]),t}(o.a.Component),Et=ft=Object(ce.withStyles)(function(e){return{success:{backgroundColor:lt.a[600]},error:{backgroundColor:e.palette.error.dark},info:{backgroundColor:e.palette.primary.dark},warning:{backgroundColor:pt.a[700]},icon:{fontSize:20},iconVariant:{opacity:.9,marginRight:e.spacing.unit},message:{display:"flex",alignItems:"center"}}})(ft),bt=function(e,t,a){return{type:b,message:{text:e,show:t,messageType:a}}},yt=function(e){function t(){var e,a;Object(B.a)(this,t);for(var n=arguments.length,r=new Array(n),s=0;s<n;s++)r[s]=arguments[s];return(a=Object(J.a)(this,(e=Object(G.a)(t)).call.apply(e,[this].concat(r)))).handleClose=function(e,t){a.props.dispatch(bt("",!1,""))},a}return Object(H.a)(t,e),Object(F.a)(t,[{key:"render",value:function(){var e=!(!this.props.message||"SUCCESS"!==this.props.message.messageType),t=!(!this.props.message||"FAILURE"!==this.props.message.messageType),a=!(!this.props.message||"INFO"!==this.props.message.messageType),n=!(!this.props.message||"WARNING"!==this.props.message.messageType);return e||t||a||n?o.a.createElement("div",null,o.a.createElement(Qe.a,{anchorOrigin:{vertical:"top",horizontal:"center"},open:this.props.message.show,autoHideDuration:6e3,onClose:this.handleClose},e?o.a.createElement(Et,{onClose:this.handleClose,variant:"success",message:this.props.message.text}):t?o.a.createElement(Et,{onClose:this.handleClose,variant:"error",message:this.props.message.text}):a?o.a.createElement(Et,{onClose:this.handleClose,variant:"info",message:this.props.message.text}):n?o.a.createElement(Et,{onClose:this.handleClose,variant:"warning",message:this.props.message.text}):null)):o.a.createElement("div",null)}}]),t}(o.a.Component),vt=yt=Object(i.b)(function(e){return{message:e.message}})(yt),Ot=function(e){function t(e){var a;return Object(B.a)(this,t),(a=Object(J.a)(this,Object(G.a)(t).call(this,e))).state={name:""},a}return Object(H.a)(t,e),Object(F.a)(t,[{key:"componentDidMount",value:function(){var e=JSON.parse(sessionStorage.getItem("userData"));e&&this.setState({name:e.name})}},{key:"render",value:function(){var e=JSON.parse(sessionStorage.getItem("userData"));return!e||e&&!e.name||this.state.redirect?o.a.createElement(V.a,{to:"/"}):o.a.createElement("div",{style:{display:"flex",flexDirection:"column"}},o.a.createElement(vt,null),o.a.createElement(Xe,null),o.a.createElement("div",{style:{marginTop:"50px",marginLeft:"70px",marginRight:"90px",padding:"20px",height:"100%"}},o.a.createElement(Se,null)))}}]),t}(s.Component),jt=Object(i.b)()(Ot),wt=(a(327),U());r.a.render(o.a.createElement(i.a,{store:wt},o.a.createElement(l.a,null,o.a.createElement(c.a,null,o.a.createElement(p.a,{path:"/home",component:jt}),o.a.createElement(p.a,{path:"/",component:Q})))),document.getElementById("root"))}},[[146,2,1]]]);
//# sourceMappingURL=main.b269b2b0.chunk.js.map